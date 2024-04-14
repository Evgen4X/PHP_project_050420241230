<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ksiegarnia internetowa</title>
</head>
<body>
    <nav><?php
        include("cipher.php");

        $id = mysqli_connect("localhost", "root", "", "ksiegarnia");
        $data = mysqli_fetch_row(mysqli_query($id, "select imie, nazwisko, data_urodzenia, kod_pocztowy, miejscowosc, ulica, nr_domu, telefon, adres_e_mail from klient where id_klienta = ".decode($_GET['uid']).";"));
        $imie = $data[0] ? "'".$data[0]."'" : "''";
        $nazwisko = $data[1] ? "'".$data[1]."'" : "''";
        $data_urodzenia = $data[2] ? "'".$data[2]."'" : "''";
        $kod_pocztowy = $data[3] ? "'".$data[3]."'" : "''";
        $miejscowosc = $data[4] ? "'".str_replace("'", "\'", $data[4])."'" : "''";
        $ulica = $data[5] ? "'".str_replace("'", "\'", $data[5])."'" : "''";
        $nr_domu = $data[6] ? "'".$data[6]."'" : "''";
        $telefon = $data[7] ? "'".$data[7]."'" : "''";
        $adres_e_mail = $data[8] ? "'".$data[8]."'" : "''";

        echo "<a id='main' href='index.php?uid=".$_GET['uid']."'><div></div></a>";

        echo "Witaj, ".($imie ? substr($imie, 1, strlen($imie) - 2) : '').'!';
        echo "<button onclick=\"toggle('Konto', $imie, $nazwisko, $data_urodzenia, $kod_pocztowy, $miejscowosc, $ulica, $nr_domu, $telefon, $adres_e_mail, ".decode($_GET['uid']).");\">Konto</button>

        "; 

        echo "<script> setTimeout(() => {toggle('Konto', $imie, $nazwisko, $data_urodzenia, $kod_pocztowy, $miejscowosc, $ulica, $nr_domu, $telefon, $adres_e_mail, ".decode($_GET['uid']).")}, 200);</script>";
    ?>
</nav>

    <main></main>

    <footer></footer>

    <script>
        function toggle(name, imie, nazwisko, birthdate, code, city, street, house, tel, email, id){
            if(name == 'Konto'){
                main.innerHTML = `
                <form action="updater.php" method="post">
                    <h1>Konto</h1>
                    <div><label for="imie">Imię</label><input type="text" id="imie" name="imie" value="${imie}"></div>
                    <div><label for="nazwisko">Nazwisko</label><input type="text" id="nazwisko" name="nazwisko" value="${nazwisko}"></div>
                    <div><label for="data_urodzenia">Data urodzenia</label><input type="date" id="data_urodzenia" name="data_urodzenia" value="${birthdate}"></div>
                    <div><label for="kod_pocztowy">Kod pocztowy</label><input type="text" id="kod_pocztowy" name="kod_pocztowy" pattern="[0-9]{2,3}-[0-9]{2,3}" title="przyklad: 12-345" placeholder="000-00" value="${code}"></div>
                    <div><label for="miejscowosc">Miejscowosc</label><input type="text" id="miejscowosc" name="miejscowosc" value="${city}"></div>
                    <div><label for="ulica">Ulica</label><input type="text" id="ulica" name="ulica" value="${street}"></div>
                    <div><label for="nr_domu">Nr domu</label><input type="text" id="nr_domu" name="nr_domu" value="${house}"></div>
                    <div><label for="telefon">Telefon</label><input type="text" id="telefon" pattern="[0-9]{9,}" placeholder="000-000-000" title="przyklad: 123456789" name="telefon" value="${tel}"></div>
                    <div><label for="adres_e_mail">Adres e-mail</label><input type="text" id="adres_e_mail" pattern="^[a-zA-Z0-9\-\+\._]+@[a-zA-Z]+\.[a-zA-Z]+$" placeholder="przyklad@adresu.email" title="przyklad: przyklad@gmail.com" "name="adres_e_mail" value="${email}"></div>
                    <input type="hidden" name="origin" value="settings.php">
                    <input type="hidden" name="uid" value="${parseInt(id)}">

                    <input type="submit" value="Zapisz">
                </form>
                `;
            }   
        }

        const main = document.querySelector('main');
    </script>

</body>
</html>