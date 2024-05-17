<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="settings.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ksiegarnia internetowa</title>
</head>
<body>
    <?php
        $id = mysqli_connect("localhost", "root", "", "ksiegarnia");
        $data = mysqli_fetch_row(mysqli_query($id, "select imie, nazwisko, data_urodzenia, plec, kod_pocztowy, miejscowosc, ulica, nr_domu, telefon, adres_e_mail from klient where id_klienta = ".$_SESSION['uid'].";"));
        $imie = $data[0] ? "'".$data[0]."'" : "''";
        $nazwisko = $data[1] ? "'".$data[1]."'" : "''";
        $data_urodzenia = $data[2] ? "'".$data[2]."'" : "''";
        $plec = $data[3] ? "'".$data[3]."'" : "''";
        $kod_pocztowy = $data[4] ? "'".$data[4]."'" : "''";
        $miejscowosc = $data[5] ? "'".str_replace("'", "\'", $data[5])."'" : "''";
        $ulica = $data[6] ? "'".str_replace("'", "\'", $data[6])."'" : "''";
        $nr_domu = $data[7] ? "'".$data[7]."'" : "''";
        $telefon = $data[8] ? "'".$data[8]."'" : "''";
        $adres_e_mail = $data[9] ? "'".$data[9]."'" : "''";

        echo "<nav>";

        echo "Witaj, ".($imie ? substr($imie, 1, strlen($imie) - 2) : '').'!';
        echo "
            <div onclick='window.location.href = window.location.href.replace(\"settings\", \"index\");'>Wróć</div>
            <div id='setting-konto' onclick=\"toggle('Konto', $imie, $nazwisko, $data_urodzenia, $plec, $kod_pocztowy, $miejscowosc, $ulica, $nr_domu, $telefon, $adres_e_mail, ".$_SESSION['uid'].");\">Konto</div>
            <div id='setting-preferencje' onclick=\"toggle('Preferencje', ".$_SESSION['uid'].");\">Preferencje</div>
        </nav>"; 

        echo "<main></main><footer><span>Created by <a href='https://github.com/Evgen4X'>Evgen4X</a></span><span>".date("d.m.Y")."</span></footer>";

        echo "<script> setTimeout(() => {toggle('Konto', ".$_SESSION['uid'].", $imie, $nazwisko, $data_urodzenia, $plec, $kod_pocztowy, $miejscowosc, $ulica, $nr_domu, $telefon, $adres_e_mail)}, 200);</script>";
    ?>

    <script>
        function change_plec(){
            let val = parseFloat(document.getElementById("plec").value);
            document.getElementById('plec-val').innerHTML = (val * 50 + 50).toFixed(1) + '%';
        }
        
        function toggle(name, id, imie="", nazwisko="", birthdate="", plec="", code="", city="", street="", house="", tel="", email=""){
            document.querySelectorAll('nav div').forEach(div => {
                div.style.backgroundColor = '#2f2f2f';
                div.style.borderColor = '#2f2f2f';
            });
            document.getElementById('setting-' + name).style.backgroundColor = '#ef6461';
            document.getElementById('setting-' + name).style.borderColor = '#ef6461';
            if(name == 'Konto'){
                main.innerHTML = `
                <form action="updater.php" method="post">
                    <h1>Konto</h1>
                    <table>
                    <tr><td><label for="imie">Imię</label></td><td><input type="text" id="imie" name="imie" value="${imie}"></td></tr>
                    <tr><td><label for="nazwisko">Nazwisko</label></td><td><input type="text" id="nazwisko" name="nazwisko" value="${nazwisko}"></td></tr>
                    <tr><td><label for="data_urodzenia">Data urodzenia</label></td><td><input type="date" id="data_urodzenia" name="data_urodzenia" value="${birthdate}"></td></tr>
                    <tr><td><label for="plec">Plec</label></td><td><div><div id="male"></div><input onchange="change_plec();" type="range" id="plec" name="plec" value="${plec}" min="-1" max="1" step="0.01"><div id="female"></div><span id="plec-val">${(plec * 50 + 50).toFixed(1)}%</span></div></td></tr>
                    <tr><td><label for="kod_pocztowy">Kod pocztowy</label></td><td><input type="text" id="kod_pocztowy" name="kod_pocztowy" pattern="[0-9]{2,3}-[0-9]{2,3}" title="przyklad: 12-345" placeholder="000-00" value="${code}"></td></tr>
                    <tr><td><label for="miejscowosc">Miejscowosc</label></td><td><input type="text" id="miejscowosc" name="miejscowosc" value="${city}"></td></tr>
                    <tr><td><label for="ulica">Ulica</label></td><td><input type="text" id="ulica" name="ulica" value="${street}"></td></tr>
                    <tr><td><label for="nr_domu">Nr domu</label></td><td><input type="text" id="nr_domu" name="nr_domu" value="${house}"></td></tr>
                    <tr><td><label for="telefon">Telefon</label></td><td><input type="text" id="telefon" pattern="[0-9]{9,}" placeholder="000-000-000" title="przyklad: 123456789" name="telefon" value="${tel}"></td></tr>
                    <tr><td><label for="adres_e_mail">Adres e-mail</label></td><td><input type="text" id="adres_e_mail" pattern="^[a-zA-Z0-9\-\+\._]+@[a-zA-Z]+\.[a-zA-Z]+$" placeholder="przyklad@adresu.email" title="przyklad: przyklad@gmail.com" "name="adres_e_mail" value="${email}"></td></tr>
                    </table>
                    <input type="hidden" name="origin" value="settings.php">
                    <input type="hidden" name="uid" value="${parseInt(id)}">

                    <input type="submit" value="Zapisz">
                </form>
                `;
                
            } else if(name == 'Preferencje'){
                main.innerHTML = `
                <form action="updater.php" method="post">
                    <h1>Preferencje</h1>
                    <table>
                    <tr><td><label for="gatunki">Ulubione gatunki</label></td><td><select name="gatunki[]" id="gatunki" multiple="multiple" size="17">
                        <option>legenda</option>
                        <option>komedia</option>
                        <option>piesn</option>
                        <option>opowiadanie</option>
                        <option>nowela</option>
                        <option>tren</option>
                        <option>dramat romantyczny</option>
                        <option>pamietnik</option>
                        <option>bajka</option>
                        <option>romans</option>
                        <option>sonet</option>
                        <option>poemat</option>
                        <option>tragedia</option>
                        <option>opera</option>
                        <option>powiesc</option>
                        <option>dramat</option>
                        <option>basn</option>
                    </select></td></tr>
                    <tr><td><label for="jezyki">Języki</label></td><td><select name="jezyki[]" id="jezyki" multiple="multiple" size="5">
                        <option>francuski</option>
                        <option>angielski</option>
                        <option>polski</option>
                        <option>niemiecki</option>
                        <option>hiszpanski</option>
                    </select></td></tr>
                    </table>

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