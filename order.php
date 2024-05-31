<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl" class="light">
<head>
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="order.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zamówienie</title>
</head>
<body>
    <?php
    $id = mysqli_connect("localhost", "root", "", "ksiegarnia");
    $data = mysqli_fetch_row(mysqli_query($id, "select imie, nazwisko, data_urodzenia, plec, kod_pocztowy, miejscowosc, ulica, nr_domu, telefon, adres_e_mail from klient where id_klienta = ".$_SESSION['uid'].";"));
    $imie = $data[0] ? "'".$data[0]."'" : "''";
    $kod_pocztowy = $data[4] ? "'".$data[4]."'" : "''";
    $miejscowosc = $data[5] ? "'".str_replace("'", "\'", $data[5])."'" : "''";
    $ulica = $data[6] ? "'".str_replace("'", "\'", $data[6])."'" : "''";
    $nr_domu = $data[7] ? "'".$data[7]."'" : "''";
    $telefon = $data[8] ? "'".$data[8]."'" : "''";
    $adres_e_mail = $data[9] ? "'".$data[9]."'" : "''";
    
    echo "<nav>";

    echo "Witaj, ".($imie ? substr($imie, 1, strlen($imie) - 2) : '').'!';
    echo "
        <div onclick='window.location.href = window.location.href.replace(\"order\", \"index\");'>Wróć</div>
        <div id='light-dark-toggle' onclick='toggleTheme();'></div>
    </nav>";
    echo "<main>";

    $data = mysqli_fetch_row(mysqli_query($id, "select tytul, concat(substr(imie, 1, 1), '. ', nazwisko), ilosc, cena, jezyk_ksiazki from ksiazki join autor using (id_autora) where ksiazki.id_ksiazki = ".$_POST['data'].";"));
    $tytul = $data[0] ? $data[0] : "";
    $autor = $data[1] ? $data[1] : "";
    $ilosc = $data[2] ? $data[2] : "";
    $cena = $data[3] ? $data[3] : "";
    $jezyk = $data[4] ? $data[4] : "";
    echo "<table><tr><th>Tytul</th><th>Autor</th><th>Jezyk</th><th>Cena</th><th>Ilość</th></tr>";
    echo "<tr><td>$tytul</td><td>$autor</td><td>$jezyk</td><td><span id='cena'>$cena zł * 1 = $cena zł</span></td><td><input type='number' name='ilosc' id='ilosc' value='1'></td></tr></table>";

    echo "</table>
    <form action='orderer.php' method='post'>
        <input type='hidden' value='".$_POST['uid']."' name='uid'>
        <input type='hidden' value='".$_POST['data']."' name='kid'>
        <input type='hidden' value='1' id='ilosc2' name='ilosc'>
        <input type='submit' value='Kup'>
    </form>";

    if(isset($_POST['err'])){
        if($_POST['err'] == 1){
            echo "<div id='errno'>"; //TODO

        }
    }

    echo "</main><footer>Created by <a href='https://github.com/Evgen4X'>Evgen4X</a></footer>";

    echo "<script>
        document.getElementById('ilosc').onchange = () => {
            let v = document.getElementById('ilosc');
            if(v.value > $ilosc){
                v.value = $ilosc;
            } else if(v.value < -1){
                v.value = -1;
            }

            document.getElementById('cena').innerHTML = '$cena zł * ' + v.value + ' = ' + parseInt(v.value) * parseInt($cena) + 'zł';
            document.getElementById('ilosc2').value = parseInt(v.value) * parseInt($cena);
        };
    </script>";

    ?>

    <script>
        function toggleTheme(){
            html.classList.toggle('light');
            html.classList.toggle('dark');
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