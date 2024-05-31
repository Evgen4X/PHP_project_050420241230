<?php
session_start();
?>
<!DOCTYPE html>
<html class="light" lang="pl">
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
                main.innerHTML += "<button class='div-submit' style='width: 8em; height: 1.5em;' onclick='addBook();'>Dodaj książkę</button>";
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

                    echo "`".$inner."</table><input type='submit' value='Zapisz zmiany' style='width: 8em; height: 1.5em;'></form>`";
                ?>
            } else if(type == 'klient'){
                main.innerHTML = `<h1>Edycja klienta</h1>`;
                main.innerHTML += "<button class='div-submit' style='width: 8em; height: 1.5em;' onclick='addClient();'>Dodaj klienta</button>";
                main.innerHTML += <?php
                    $data = mysqli_query($id, 'select * from klient where id_klienta > -1');
                    $inner = '<form action="updateClient.php" method="post"><table><tr><th></th><th>Login</th><th>Hasło</th><th>Nazwisko</th><th>Imię</th><th>Data urodzenia</th><th>Płeć</th><th>Kod pocztowy</th><th>Miejscowość</th><th>Ulica</th><th>Nr domu</th><th>PESEL</th><th>Telefon</th><th>Adres e-mail</th><th>Admin</th></tr>';
                    while(($line = mysqli_fetch_row($data))){
                        $inner .= "
                        <tr>
                            <td>
                                <input id='delete_".$line[0]."' name='delete_".$line[0]."' type='hidden' value='0'>
                                <div class='delete' id='delete_".$line[0]."_0' onclick='toggleDelete(".$line[0].");'></div>
                            </td>
                            <td><input name='login_".$line[0]."' value='".$line[1]."'></td>
                            <td><input name='haslo_".$line[0]."' value='".$line[2]."'></td>
                            <td><input name='nazwisko_".$line[0]."' value='".$line[3]."'></td>
                            <td><input name='imie_".$line[0]."' value='".$line[4]."'></td>
                            <td><input type='date' name='data-urodzenia_".$line[0]."' value='".$line[5]."'></td>
                            <td><input type='number' min='0' max='1' step='0.01' name='plec_".$line[0]."' value='".$line[6]."'></td>
                            <td><input name='kod-pocztowy_".$line[0]."' value='".$line[7]."'></td>
                            <td><input name='miejscowosc_".$line[0]."' value='".$line[8]."'></td>
                            <td><input name='ulica_".$line[0]."' value='".$line[9]."'></td>
                            <td><input type='number' name='nr-domu_".$line[0]."' value='".$line[10]."'></td>
                            <td><input name='pesel_".$line[0]."' value='".$line[11]."'></td>
                            <td><input name='telefon_".$line[0]."' value='".$line[12]."'></td>
                            <td><input name='adres-e-mail_".$line[0]."' value='".$line[13]."'></td>
                            <td><input name='admin_".$line[0]."' value='".$line[14]."'></td>
                        </tr>
                        ";
                    }

                    echo "`".$inner."</table><input type='submit' value='Zapisz zmiany' style='width: 8em; height: 1.5em;'></form>`";
                ?>
            }
        }

        function addBook(){
            let html = document.querySelector('form table tbody').innerHTML;
            let length = "<tr><th></th><th>Tytuł</th><th>ID autora</th><th>Cena</th><th>Ilość</th><th>Wydawnictwo</th><th>Temat</th><th>Gatunek</th><th>Miejsce wydania</th><th>Język książki</th><th>Opis</th><th>Rok wydania</th></tr>".length;

            html = html.substr(0, length) + `
            <tr>
                <td><input id='delete_NULL' name='delete_NULL' type='hidden' value='0'></td>
                <td><input name='tytul_NULL' value=''></td>
                <td><input type='number' name='id-autora_NULL' value='1'></td>
                <td><input type='number' name='cena_NULL' value='1'></td>
                <td><input type='number' name='ilosc_NULL' value='0'></td>
                <td><input name='wydawnictwo_NULL' value=''></td>
                <td><input name='temat_NULL' value=''></td>
                <td><input name='gatunek_NULL' value=''></td>
                <td><input name='miejsce-wydania_NULL' value=''></td>
                <td><input name='jezyk-ksiazki_NULL' value=''></td>
                <td><input name='opis_NULL' value=''></td>
                <td><input type='number' name='rok-wydania_NULL' value=''></td>
            </tr>
            ` + html.substr(length);

            document.querySelector('form table tbody').innerHTML = html;
        }

        function addClient(){
            let html = document.querySelector('form table tbody').innerHTML;
            let length = "<tr><th></th><th>Login</th><th>Hasło</th><th>Nazwisko</th><th>Imię</th><th>Data urodzenia</th><th>Płeć</th><th>Kod pocztowy</th><th>Miejscowość</th><th>Ulica</th><th>Nr domu</th><th>PESEL</th><th>Telefon</th><th>Adres e-mail</th><th>Admin</th></tr>".length;
    
            html = html.substr(0, length) + `
                <td><input id='delete_NULL' name='delete_NULL' type='hidden' value='0'></td>
                <td><input name='login_NULL' value=''></td>
                <td><input name='haslo_NULL' value=''></td>
                <td><input name='nazwisko_NULL' value=''></td>
                <td><input name='imie_NULL' value=''></td>
                <td><input type='date' name='data-urodzenia_NULL' value=''></td>
                <td><input type='number' min='0' max='1' step='0.01' name='plec_NULL' value=''></td>
                <td><input name='kod-pocztowy_NULL' value=''></td>
                <td><input name='miejscowosc_NULL' value=''></td>
                <td><input name='ulica_NULL' value=''></td>
                <td><input type='number' name='nr-domu_NULL' value=''></td>
                <td><input name='pesel_NULL' value=''></td>
                <td><input name='telefon_NULL' value=''></td>
                <td><input name='adres-e-mail_NULL' value=''></td>
                <td><input name='admin_NULL' value='0'></td>
            ` + html.substr(length);

            document.querySelector('form table tbody').innerHTML = html;
        }

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