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
    header("Location: register.php?err=7&errcode=".mysqli_errno($id)."&errdesc=".mysqli_error($id)."&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

if(!preg_match("/.{6,}/", $_POST['login'])){
    header("Location: register.php?err=8&errcode=".mysqli_errno($id)."&errdesc=".mysqli_error($id)."&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

if(!preg_match("/[0-9]{9,}/", $_POST['telefon'])){
    header("Location: register.php?err=9&errcode=".mysqli_errno($id)."&errdesc=".mysqli_error($id)."&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

if(strlen($haslo) < 8 ||
    !preg_match("/[A-Z]{2,}/", $haslo) ||
    !preg_match("/[a-z]{2,}/", $haslo) ||
    !preg_match("/[0-9]{2,}/", $haslo) ||
    !preg_match("/[!@#\$%\^&\*\(\)\-_+=\.,<>\[\]\{\}:;\\/`~|\"']{2,}/", $haslo) ||
    !preg_match("/[0-9]*[50][^0-9]/", $haslo)){
    header("Location: register.php?err=6&errcode=".mysqli_errno($id)."&errdesc=".mysqli_error($id)."&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
if(!$id){
    header("Location: register.php?err=1&errcode=".mysqli_connect_errno()."&errdesc=".mysqli_connect_error()."&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

$klients = mysqli_query($id, "select * from klient");
while($k = mysqli_fetch_row($klients)){
    if($k[0] == -1){
        continue;
    }
    if($k[1] == $_POST['login']){
        print_r($k);
    }
    if($k[2] == $haslo){
        header("Location: register.php?err=3&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
        exit;
    }
    if($k[12] == $_POST['adres_e_mail']){
        header("Location: register.php?err=4&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    }
}

if(!mysqli_query($id, "insert into klient(login, haslo, telefon, adres_e_mail) value ('".$_POST['login']."', '$haslo', '".$_POST['telefon']."', '".$_POST['adres_e_mail']."')")){ //TODO: do.
    echo "insert into klient(login, haslo, telefon, adres_e_mail) value ('".$_POST['login']."', '$haslo', '".$_POST['telefon']."', '".$_POST['adres_e_mail']."'";
    header("Location: register.php?err=5&errcode=".mysqli_errno($id)."&errdesc=".mysqli_error($id)."&login=".$_POST['login']."&password=$haslo&email=".$_POST['adres_e_mail']."&tel=".$_POST['telefon']);
    exit;
}

$USER_ID = mysqli_query($id, "select id from klient where login = ".$_POST['login']." and haslo = $haslo");

header("Location: index.php/?uid=".encode($USER_ID)."&first=1");
exit;


?>