<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ksiegarnia Internetowa</title>
</head>
<body>
    <?php
    $id = mysqli_connect("localhost", "root", "", "ksiegarnia");
    echo "<nav>".
        (isset($_SESSION['uid']) ? "<div><a href='logout.php'>Log out</a></div>" : "<div><a href='login.php'>Log in</a></div>").
        (isset($_SESSION['uid']) ? "<div><a href='settings.php'>Ustawienia</a></div>" : "").
        "</nav>";

    echo "<main><div id='main'>";


    for($i = 1; $i < 100; ++$i){
        $book = mysqli_query($id, "select ksiazki.tytul, concat(substr(autor.imie, 1, 1), '. ', autor.nazwisko), ksiazki.cena,  ksiazki.gatunek, ksiazki.jezyk_ksiazki, ksiazki.rok_wydania, ksiazki.id_ksiazki from ksiazki join autor using (id_autora) limit $i, 1;");
        if($book){
            $data = mysqli_fetch_row($book);
            echo "<div class='ksiazka'>
                    <form action='order.php' method='post'>
                        <h2>".$data[0]."</h2>
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

    echo "</div></main>";

    echo "<aside>
        <h2>Fil</h2>
        <form action='index.php' method='post'>
            <fieldset>
                <legend>Cena</legend>
                <input type='number' value='0' placeholder='min' name='cena-min' id='cena-min'>
                <input type='number' value='10000' placeholder='max' name='cena-max' id='cena-max'>
            </fieldset>
            <fieldset>
                <legend>Sortuj</legend>
                <table>
                    <tr><td>Cena</td><td><input type='checkbox' name='sortuj-cena'></td></tr>
                </table>
            </fieldset>
            <input type='submit'>
        </form>
    </aside>";
      
    echo "<footer>Created by <a href='https://github.com/Evgen4X'>Evgen4X</a></footer>";

    ?>
</body>
</html>