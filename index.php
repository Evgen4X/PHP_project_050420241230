<?php
session_start();
?>
<!DOCTYPE html>
<html class="light" lang='pl'>
<head>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ksiegarnia Internetowa</title>
</head>
<body>
    <?php
    $id = mysqli_connect("localhost", "root", "");
    try{
        if(!mysqli_select_db($id, "ksiegarnia")){
            $_SESSION['origin'] = 'index.php';
            header('Location: createdb.php');
            die;
        }
    } catch(Exception $ex){
        $_SESSION['origin'] = 'index.php';
        header('Location: createdb.php');
        die;
    }

    echo "<nav>";
    if(isset($_SESSION['uid'])){
        echo "<div><a href='logout.php'>Log out</a></div>
            <div><a href='settings.php'>Ustawienia</a></div>";
        $a = mysqli_query($id, "select admin from klient where id_klienta = ".$_SESSION['uid'].";");
        if($a && mysqli_fetch_row($a)[0] == 1){
            echo "<div><a href='admin.php'>Admin</a></div>";
        }
    }
    else{
        echo "<div><a href='login.php'>Log in</a></div>";
    }

    echo "<div id='light-dark-toggle' onclick='toggleTheme();'></div></nav><main><div id='main'>";

    $query = "select count(*)
    from ksiazki join autor using (id_autora)
    WHERE".(isset($_POST['nazwa']) && trim($_POST['nazwa']) != '' ? ' lcase(ksiazki.tytul) = "'.strtolower(trim($_POST['nazwa'])).'" AND' : "").
    " ksiazki.id_ksiazki > -1
    AND ksiazki.cena BETWEEN ".(isset($_POST['cena-min']) ? $_POST['cena-min'] : 0)." AND ".(isset($_POST['cena-max']) ? $_POST['cena-max'] : 10000)." ".
    (isset($_POST['sort-cena']) && $_POST['sort-cena'] != '2' ? "order by ksiazki.cena ".($_POST['sort-cena'] == '1' ? 'asc' : 'desc') : "").
    (isset($_POST['sort-autor']) && $_POST['sort-autor'] != '2' ? (isset($_POST['sort-cena']) && $_POST['sort-cena'] != '2' ? ', ' : 'order by ')."autor.imie ".($_POST['sort-autor'] == 1 ? 'asc' : 'desc') : "").
    (isset($_POST['sort-rok-wydania']) && $_POST['sort-rok-wydania'] != '2' ? (isset($_POST['sort-cena']) && $_POST['sort-cena'] != '2' || isset($_POST['sort-autor']) && $_POST['sort-autor'] != '2' ? ', ' : 'order by ').'ksiazki.rok_wydania '.($_POST['sort-rok-wydania'] == '1' ? 'asc' : 'desc') : '');

    $query = mysqli_query($id, $query);

    if($query && mysqli_fetch_row($query)[0] == 0){
        echo "<div id='nothing-found'>Nie znaleziono książek</div>";
    } else {
        for($i = 0; $i < 100; ++$i){
            $query = "select ksiazki.tytul, concat(substr(autor.imie, 1, 1), '. ', autor.nazwisko), ksiazki.cena,  ksiazki.gatunek, ksiazki.jezyk_ksiazki, ksiazki.rok_wydania, ksiazki.id_ksiazki
                    from ksiazki join autor using (id_autora)
                    WHERE".(isset($_POST['nazwa']) && trim($_POST['nazwa']) != '' ? ' lcase(ksiazki.tytul) = "'.strtolower(trim($_POST['nazwa'])).'" AND' : "").
                    " ksiazki.id_ksiazki > -1
                    AND ksiazki.cena BETWEEN ".(isset($_POST['cena-min']) ? $_POST['cena-min'] : 0)." AND ".(isset($_POST['cena-max']) ? $_POST['cena-max'] : 10000)." ".
                    (isset($_POST['sort-cena']) && $_POST['sort-cena'] != '2' ? "order by ksiazki.cena ".($_POST['sort-cena'] == '1' ? 'asc' : 'desc') : "").
                    (isset($_POST['sort-autor']) && $_POST['sort-autor'] != '2' ? (isset($_POST['sort-cena']) && $_POST['sort-cena'] != '2' ? ', ' : 'order by ')."autor.imie ".($_POST['sort-autor'] == 1 ? 'asc' : 'desc') : "").
                    (isset($_POST['sort-rok-wydania']) && $_POST['sort-rok-wydania'] != '2' ? (isset($_POST['sort-cena']) && $_POST['sort-cena'] != '2' || isset($_POST['sort-autor']) && $_POST['sort-autor'] != '2' ? ', ' : 'order by ').'ksiazki.rok_wydania '.($_POST['sort-rok-wydania'] == '1' ? 'asc' : 'desc') : '').
                    " limit $i, 1;";

            $book = mysqli_query($id, $query);
            if($book){
                $data = mysqli_fetch_row($book);
                if($data){
                    echo "<div class='ksiazka'>
                            <form action='order.php' method='post'>
                                <div class='title'>".$data[0]."</div>
                                <div class='autor'>".$data[1]."</div>
                                <div class='cena'>".$data[2]."</div>
                                <div class='gatunek'>".$data[3]."</div>
                                <div class='jezyk'>".$data[4]."</div>
                                <div class='rok'>".$data[5]."</div>
                                <input type='hidden' name='data' value=".$data[6].">
                                ".(isset($_SESSION['uid']) ? "
                                <input type='hidden' name='uid' value='".$_SESSION['uid']."'>
                                <input type='submit' class='kup' value='kup'>" : "<a href='login.php' style='display: block;' class='div-submit kup'>kup</a>")."
                            </form>
                        </div>";
                }
            }
        }
    }

    echo "</div></main>";

    echo "<aside>
        <h2>Fil</h2>
        <form action='index.php' method='post'>
            <fieldset>
                <input value='".(!isset($_POST['nazwa']) ? '' : $_POST['nazwa'])."' placeholder='tytuł' name='nazwa'>
            </fieldset>
            <fieldset>
                <legend>Cena</legend>
                <input type='number' value='".(!isset($_POST['cena-min']) ? 0 : $_POST['cena-min'])."' placeholder='min' name='cena-min' id='cena-min'>
                <input type='number' value='".(!isset($_POST['cena-max']) ? 10000 : $_POST['cena-max'])."' placeholder='max' name='cena-max' id='cena-max'>
            </fieldset>
            <fieldset>
                <legend>Sortuj</legend>
                <table>
                    <tr><td>Cena</td><td><div class='checkbox".(!isset($_POST['sort-cena']) ?  '2' : $_POST['sort-cena'])."' onclick='toggle(this, \"sort-cena\");'></div><input type='hidden' value='".(isset($_POST['sort-cena']) ? $_POST['sort-cena'] : '2')."' name='sort-cena' id='sort-cena'></td></tr>
                    <tr><td>Autor</td><td><div class='checkbox".(!isset($_POST['sort-autor']) ? '2' : $_POST['sort-autor'])."' onclick='toggle(this, \"sort-autor\");'></div><input type='hidden' value='".(isset($_POST['sort-autor']) ? $_POST['sort-autor'] : '2')."' name='sort-autor' id='sort-autor'></td></tr>
                    <tr><td>Rok wydania</td><td><div class='checkbox".(!isset($_POST['sort-rok-wydania']) ? '2' : $_POST['sort-rok-wydania'])."' onclick='toggle(this, \"sort-rok-wydania\");'></div><input type='hidden' value='".(isset($_POST['sort-rok-wydania']) ? $_POST['sort-rok-wydania'] : '2')."' name='sort-rok-wydania' id='sort-rok-wydania'></td></tr>
                </table>
            </fieldset>
            <div style='display: flex; justify-content: space-evenly; align-items: center; width: 90%; margin-top: 1vh;'>
                <input type='submit' value='Zapisz' style='height: 100%;'>
                <div class='div-submit' onclick='resetForm();' style='height: 100%;'>Wyczyść</div>
            </div>
        </form>
    </aside>";
      
    echo "<footer><span>Created by <a href='https://github.com/Evgen4X' target='blank_'>Evgen4X</a></span><span>".date("d.m.Y")."</span></footer>";

    ?>

    <script>
        function resetForm(){
            document.querySelector('input[name="nazwa"]').value = '';
            document.querySelector('input[name="cena-min"]').value = 0;
            document.querySelector('input[name="cena-max"]').value = 10000;
            document.querySelectorAll('div[class*="checkbox"]').forEach(el => {
                el.classList.remove('checkbox0');
                el.classList.remove('checkbox1');
                el.classList.add('checkbox2');
            });
            document.querySelectorAll('input[name*="sort"]').forEach(el => {
                el.value = '2';
            })
        }
        function toggle(div, name){
            if(div.classList.contains('checkbox0')){
                div.classList.remove('checkbox0');
                div.classList.add('checkbox1');
            } else if(div.classList.contains('checkbox1')){
                div.classList.remove('checkbox1');
                div.classList.add('checkbox2');
            } else if(div.classList.contains('checkbox2')){
                div.classList.remove('checkbox2');
                div.classList.add('checkbox0');
            }
            document.getElementById(name).value = div.classList.contains('checkbox1') ? '1' : div.classList.contains('checkbox2') ? '2' : '0';
        }

        function toggleTheme(){
            html.classList.toggle('light');
            html.classList.toggle('dark');
            console.log(html.classList.contains('dark'));
            if(html.classList.contains('dark')){
                localStorage.setItem('theme', 'dark')
            } else {
                localStorage.setItem('theme', 'light')
            }
        }

        const html = document.querySelector('html');
        if(localStorage.getItem('theme') == 'dark'){
            html.classList.toggle('light');
            html.classList.toggle('dark');
        }
    </script>

</body>
</html>
