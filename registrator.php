<?php

$haslo = $_POST['password'];

if(strlen($haslo) < 8 || !preg_match("/[A-Z]{2,}/", $haslo) || !preg_match("/[a-z]{2,}/", $haslo) || !preg_match("/[0-9]{2,}/", $haslo)){
    header("Location: register.php?err=6&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
if(!$id){
    header("Location: register.php?err=1&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

$klients = mysqli_query($id, "select * from klient");
while($k = mysqli_fetch_row($klients)){
    if($k['login'] = $_POST['login']){
        header("Location: register.php?err=2&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
        exit;
    }
    if($k['haslo'] == $haslo){
        header("Location: register.php?err=3&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
        exit;
    }
    if($k['adres_e_mail'] == $_POST['adres_e_mail']){
        header("Location: register.php?err=4&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    }
}

if(!mysqli_query($id, "insert into klient value (null, ".$_POST['imie'].", )")){ //TODO: do.
    header("Location: register.php?err=5&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}


?>