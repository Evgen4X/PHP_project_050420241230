<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zamówienie</title>
</head>
<body>
    <?php
    include("cipher.php");

    $id = mysqli_connect("localhost", "root", "", "ksiegarnia");
    $data = mysqli_fetch_row(mysqli_query($id, "select imie, nazwisko, data_urodzenia, plec, kod_pocztowy, miejscowosc, ulica, nr_domu, telefon, adres_e_mail from klient where id_klienta = ".decode($_POST['uid']).";"));
    $imie = $data[0] ? "'".$data[0]."'" : "''";
    $kod_pocztowy = $data[4] ? "'".$data[4]."'" : "''";
    $miejscowosc = $data[5] ? "'".str_replace("'", "\'", $data[5])."'" : "''";
    $ulica = $data[6] ? "'".str_replace("'", "\'", $data[6])."'" : "''";
    $nr_domu = $data[7] ? "'".$data[7]."'" : "''";
    $telefon = $data[8] ? "'".$data[8]."'" : "''";
    $adres_e_mail = $data[9] ? "'".$data[9]."'" : "''";
    
    setcookie("lista", $_COOKIE['lista'] . ', ' . $_POST['data'], time() + 3600);

    echo "<nav>";

    echo "Witaj, ".($imie ? substr($imie, 1, strlen($imie) - 2) : '').'!';
    echo "
        <div onclick='window.location.href = window.location.href.replace(\"settings\", \"index\");'>Wróć</div>
    </nav>";
    echo "<main><table>";

    $lista = [];
    $i = 0;
    $val = "";
    while($i < strlen($_COOKIE['lista'])){
        if($i == ','){
            array_push($lista, $val);
        }
        elseif($i != ' '){
            $val .= $i;
        }

        ++$i;
    }

    foreach($lista as $i){
        $data = mysqli_fetch_row(mysqli_query("select tytul, concat(substr(imie, 1, 1), '. ', nazwisko), ilosc, cena, jezyk_ksiazki from ksiazki join autor using (id_autora);"));
        $tytul = $data[0] ? "'".$data[0]."'" : "''";
        $autor = $data[1] ? "'".$data[1]."'" : "''";
        $ilosc = $data[2] ? "'".$data[2]."'" : "''";
        $cena = $data[3] ? "'".$data[3]."'" : "''";
        $jezyk = $data[4] ? "'".$data[4]."'" : "''";
        echo "<tr><td>$tytul</td><td>$autor</td><td>$jezyk</td><td>$cena</td><td><input type='number' name='ilosc' id='ilosc$i' value='1'></td></tr>";
    }

    echo "</table></main>";

    echo "<footer>Created by <a href='https://github.com/Evgen4X'>Evgen4X</a></footer>";

    ?>
</body>
</html>