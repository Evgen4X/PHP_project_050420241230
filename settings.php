<?php
session_start();
?>
<!DOCTYPE html>
<html class="light" lang="pl">
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
        $data = mysqli_fetch_array(mysqli_query($id, "select imie, nazwisko, data_urodzenia, plec, kod_pocztowy, miejscowosc, ulica, nr_domu, telefon, adres_e_mail from klient where id_klienta = ".$_SESSION['uid'].";"));
        $imie = $data['imie'] ? "'".$data['imie']."'" : "''";
        $nazwisko = $data['nazwisko'] ? "'".$data['nazwisko']."'" : "''";
        $data_urodzenia = $data['data_urodzenia'] ? "'".$data['data_urodzenia']."'" : "''";
        $plec = $data['plec'] ? "'".$data['plec']."'" : "''";
        $kod_pocztowy = $data['kod_pocztowy'] ? "'".$data['kod_pocztowy']."'" : "''";
        $miejscowosc = $data['miejscowosc'] ? "'".str_replace("'", "\'", $data['miejscowosc'])."'" : "''";
        $ulica = $data['ulica'] ? "'".str_replace("'", "\'", $data['ulica'])."'" : "''";
        $nr_domu = $data['nr_domu'] ? "'".$data['nr_domu']."'" : "''";
        $telefon = $data['telefon'] ? "'".$data['telefon']."'" : "''";
        $adres_e_mail = $data['adres_e_mail'] ? "'".$data['adres_e_mail']."'" : "''";

        echo "<nav>";

        echo "<span>Witaj, ".($imie ? substr($imie, 1, strlen($imie) - 2) : '').'!</span>';
        echo "
            <div onclick='window.location.href = window.location.href.replace(\"settings\", \"index\");'>Wróć</div>
            <div id='setting-konto' onclick=\"toggle('konto', $imie, $nazwisko, $data_urodzenia, $plec, $kod_pocztowy, $miejscowosc, $ulica, $nr_domu, $telefon, $adres_e_mail, ".$_SESSION['uid'].");\">Konto</div>
            <div id='setting-preferencje' onclick=\"toggle('preferencje', ".$_SESSION['uid'].");\">Preferencje</div>
            <div id='light-dark-toggle' onclick='toggleTheme();'></div>
        </nav>"; 

        echo "<main></main><footer><span>Created by <a href='https://github.com/Evgen4X'>Evgen4X</a></span><span>".date("d.m.Y")."</span></footer>";

        echo "<script> setTimeout(() => {toggle('konto', ".$_SESSION['uid'].", $imie, $nazwisko, $data_urodzenia, $plec, $kod_pocztowy, $miejscowosc, $ulica, $nr_domu, $telefon, $adres_e_mail)}, 200);</script>";
    ?>

    <script>
        function change_plec(){
            let val = parseFloat(document.getElementById("plec").value);
            document.getElementById('plec-val').innerHTML = (val * 50 + 50).toFixed(1) + '%';
        }
        
        function toggle(name, id, imie="", nazwisko="", birthdate="", plec="", code="", city="", street="", house="", tel="", email=""){
            document.querySelectorAll('nav div:not([id="light-dark-toggle"])').forEach(div => {
                div.style.backgroundColor = html.classList.contains('dark') ? '#6f6f6f' : '#3f3f3f';
                div.style.borderColor = html.classList.contains('dark') ? '#6f6f6f' : '#3f3f3f';
            });
            document.getElementById('setting-' + name).style.backgroundColor = '#ef6461';
            document.getElementById('setting-' + name).style.borderColor = '#ef6461';
            if(name == 'konto'){
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

                    <input type="submit" value="Zapisz">
                </form>
                `;
                
            } else if(name == 'preferencje'){
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

                    <input type="submit" value="Zapisz">
                </form>
                `;
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