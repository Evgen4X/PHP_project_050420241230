<?php
session_start();
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" href="icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <?php
        $id = mysqli_connect("localhost", "root", "", "ksiegarnia");
        $data = mysqli_fetch_row(mysqli_query($id, "select imie, nazwisko, admin from klient where id_klienta = ".$_SESSION['uid'].";"));
        $imie = $data[0] ? "'".$data[0]."'" : "''";
        $nazwisko = $data[1] ? "'".$data[1]."'" : "''";
        if($data[2] != 1){
            header("Location: index.php");
            die;
        }

        echo "<nav>";

        echo "Witaj, ".($imie ? substr($imie, 1, strlen($imie) - 2) : '').'!';
        echo "
            <div onclick='window.location.href = window.location.href.replace(\"admin\", \"index\");'>Wróć</div>
            <div id='type-klient' onclick=\"toggle('klient');\">Klient</div>
            <div id='type-ksiazka' onclick=\"toggle('ksiazka');\">Książka</div>
            <div id='light-dark-toggle' onclick='toggleTheme();'></div>
        </nav>";

        echo "<main></main>";

        echo "<footer><span>Created by <a href='https://github.com/Evgen4X' target='_blank'>Evgen4X</a></span><span>".date("d.m.Y")."</span></footer>";

        echo "<script> setTimeout(() => {toggle('klient');}, 200); </script>";
        
    ?>

    <script>
        function toggleDelete(id){
            let input = document.getElementById(`delete_${id}`);
            let div = document.getElementById('delete_' + id + '_' + input.value);
            input.value = input.value == '1' ? '0' : '1';
            div.id = 'delete_' + id + '_' + input.value;
        }
        function toggle(type){
            document.querySelectorAll('nav div').forEach(div => {
                div.style.backgroundColor = html.classList.contains('dark') ? '#6f6f6f' : '#3f3f3f';
                div.style.borderColor = html.classList.contains('dark') ? '#6f6f6f' : '#3f3f3f';
            });
            document.getElementById('type-' + type).style.backgroundColor = '#ef6461';
            document.getElementById('type-' + type).style.borderColor = '#ef6461';
            if(type == 'ksiazka'){
                main.innerHTML = `<h1>Edycja książki</h1>`; //TODO: do.
                main.innerHTML += <?php
                    $data = mysqli_query($id, 'select * from ksiazki where id_ksiazki > -1');
                    $inner = '<form action="updateBook.php" method="post"><table><tr><th></th><th>Tytuł</th><th>ID autora</th><th>Cena</th><th>Ilość</th><th>Wydawnictwo</th><th>Temat</th><th>Gatunek</th><th>Miejsce wydania</th><th>Język książki</th><th>Opis</th><th>Rok wydania</th></tr>';
                    while(($line = mysqli_fetch_row($data))){
                        $inner .= "
                        <tr>
                            <td>
                                <input id='delete_".$line[0]."' name='delete_".$line[0]."' type='hidden' value='0'>
                                <div class='delete' id='delete_".$line[0]."_0' onclick='toggleDelete(".$line[0].");'></div>
                            </td>
                            <td><input name='tytul_".$line[0]."' value='".$line[1]."'></td>
                            <td><input type='number' name='id-autora_".$line[0]."' value='".$line[2]."'></td>
                            <td><input type='number' name='cena_".$line[0]."' value='".$line[3]."'></td>
                            <td><input type='number' name='ilosc_".$line[0]."' value='".$line[4]."'></td>
                            <td><input name='wydawnictwo_".$line[0]."' value='".$line[5]."'></td>
                            <td><input name='temat_".$line[0]."' value='".$line[6]."'></td>
                            <td><input name='gatunek_".$line[0]."' value='".$line[7]."'></td>
                            <td><input name='miejsce-wydania_".$line[0]."' value='".$line[8]."'></td>
                            <td><input name='jezyk-ksiazki_".$line[0]."' value='".$line[9]."'></td>
                            <td><input name='opis_".$line[0]."' value='".$line[10]."'></td>
                            <td><input type='number' name='rok-wydania_".$line[0]."' value='".$line[11]."'></td>
                        </tr>
                        ";
                    }

                    echo "`".$inner."</table><input type='submit' value='Zapisz zmiany'></form>`";
                ?>
            } else if(type == 'klient'){
                main.innerHTML = `<h1>Edycja klienta</h1>`; //TODO: do.
            }
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
            document.querySelectorAll('nav div:not([id="light-dark-toggle"])').forEach(div => {
                div.style.backgroundColor = html.classList.contains('dark') ? '#6f6f6f' : '#3f3f3f';
                div.style.borderColor = html.classList.contains('dark') ? '#6f6f6f' : '#3f3f3f';
            });
        }
        const html = document.querySelector('html');

        if(localStorage.getItem('theme') == 'dark'){
            html.classList.toggle('light');
            html.classList.toggle('dark');
        }

        const main = document.querySelector('main');

    </script>
</body>
</html>