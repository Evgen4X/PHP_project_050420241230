<?php

include("cipher.php");

$login = str_replace("'", "\\'", $_POST['login']);
$haslo = str_replace("'", "\\'", $_POST['password']);
$telefon = str_replace("'", "\\'", $_POST['telefon']);
$email = str_replace("'", "\\'", $_POST['adres_e_mail']);

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
if(!$id){
    header("Location: register.php?err=1&errcode=".mysqli_connect_errno()."&errdesc=".mysqli_connect_error()."&login=$login&password=$haslo&email=$email&tel=".$telefon);
    exit;
}

$klients = mysqli_query($id, "select * from klient");
while($k = mysqli_fetch_row($klients)){
    if($k[0] == -1){
        continue;
    }
    if($k[12] == $email){
        header("Location: register.php?err=4&login=$login&password=$haslo&email=$email&tel=".$telefon);
        exit;
    }
    if($k[1] == $login){
        header("Location: register.php?err=2&login=$login&password=$haslo&email=$email&tel=".$telefon);
        exit;
    }
    if($k[2] == $haslo){
        header("Location: register.php?err=3&login=$login&password=$haslo&email=$email&tel=".$telefon);
        exit;
    }
}

if(!preg_match("/[a-zA-Z0-9\.\-+]+@[a-zA-Z0-9]+\.[a-zA-Z]+/", $email)){
    header("Location: register.php?err=7&login=$login&password=$haslo&email=$email&tel=".$telefon);
    exit;
}

if(!preg_match("/.{6,}/", $login)){
    header("Location: register.php?err=8&login=$login&password=$haslo&email=$email&tel=".$telefon);
    exit;
}

if(!preg_match("/[0-9]{9,}/", $telefon)){
    header("Location: register.php?err=9&login=$login&password=$haslo&email=$email&tel=".$telefon);
    exit;
}

if(strlen($haslo) < 8 ||
    !preg_match("/[A-Z]{2,}/", $haslo) ||
    !preg_match("/[a-z]{2,}/", $haslo) ||
    !preg_match("/[0-9]{2,}/", $haslo) ||
    !preg_match("/[^A-Z^a-z^0-9]{2,}/", $haslo) ||
    !preg_match("/[0-9]*[50][^0-9]?/", $haslo)){
    header("Location: register.php?err=6&login=$login&password=$haslo&email=$email&tel=".$telefon);
    exit;
}

mysqli_query($id, "start transaction;");

if(!mysqli_query($id, "insert into klient(login, haslo, telefon, adres_e_mail) value ('$login', '$haslo', '$telefon', '$email');")){
    header("Location: register.php?err=5&errcode=".mysqli_errno($id)."&errdesc=".mysqli_error($id)."&login=$login&password=$haslo&email=$email&tel=".$telefon);
    exit;
}

$USER_ID = mysqli_query($id, "select id_klienta from klient where login = '$login' and haslo = '$haslo' and adres_e_mail = '$email'");
$USER_ID = mysqli_fetch_row($USER_ID)[0];

if(!$USER_ID){
    mysqli_query($id, "rollback;");
    header("Location: register.php?err=5&login=$login&password=$haslo&email=$email&tel=$telefon");
    exit;
}

try{
    encode($USER_ID);
} catch(Exception $ex){
    header("Location: register.php?err=5&errdesc=$ex&login=$login&password=$haslo&email=$email&tel=$telefon");
    exit;
}

mysqli_query($id, "commit;");

header("Location: settings.php?uid=".encode($USER_ID));
exit;

?>