<?php

function encode($text){
    $res = "";
    foreach($text as $char){
        $rnd = ord($char) * 5 + rand(0, 4);
        $rnd1 = $rnd / 2 + rand(-5, 5);
        $rnd2 = $rnd - $rnd1;

        $res .= chr($rnd1).chr($rnd2);
    }

    return $res;
}

$haslo = $_POST['password'];

if(!preg_match("/[a-zA-Z0-9\.\-+]+@[a-zA-Z0-9]+\.[a-zA-Z]+/", $_POST['adres_e_mail'])){
    header("Location: register.php?err=7&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

if(!preg_match("/.{6,}/", $_POST['login'])){
    header("Location: register.php?err=8&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

if(!preg_match("/[0-9]{9,}/", $_POST['telefon'])){
    header("Location: register.php?err=9&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

if(strlen($haslo) < 8 ||
    !preg_match("/[A-Z]{2,}/", $haslo) ||
    !preg_match("/[a-z]{2,}/", $haslo) ||
    !preg_match("/[0-9]{2,}/", $haslo) ||
    !preg_match("/[!@#\$%\^&\*\(\)\-_+=\.,<>\[\]\{\}:;\\/`~|\"']{2,}/", $haslo) ||
    !preg_match("/[0-9]*[50][^0-9]/", $haslo)){
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

if(!mysqli_query($id, "insert into klient value (null, ".$_POST['login'].", $haslo, null, null, null, null, null, null, null, null, ".$_POST['telefon'].", ".$_POST['adres_e_mail'])){ //TODO: do.
    header("Location: register.php?err=5&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

$USER_ID = mysqli_query($id, "select id from klient where login = ".$_POST['login']." and haslo = $haslo");

header("Location: index.php/?uid=".encode($USER_ID)."&first=1");
exit;


?>