<?php
session_start();
?>
<?php

include("cipher.php");

$login = str_replace("'", "\\'", $_POST['login']);
$haslo = str_replace("'", "\\'", $_POST['password']);
$telefon = str_replace("'", "\\'", $_POST['telefon']);
$email = str_replace("'", "\\'", $_POST['adres_e_mail']);

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
if(!$id){
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['email'] = $email;
    $_SESSION['tel'] = $telefon;
    $_SESSION['err'] = 1;
    $_SESSION['errcode'] = mysqli_connect_errno();
    $_SESSION['errdesc'] = mysqli_connect_error();
    header("Location: register.php");
    die;
}

$klients = mysqli_query($id, "select * from klient");
while($k = mysqli_fetch_row($klients)){
    if($k[0] == -1){
        continue;
    }
    if($k[12] == $email){
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $haslo;
        $_SESSION['email'] = $email;
        $_SESSION['tel'] = $telefon;
        $_SESSION['err'] = 4;
        header("Location: register.php");
        die;
    }
    if($k[1] == $login){
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $haslo;
        $_SESSION['email'] = $email;
        $_SESSION['tel'] = $telefon;
        $_SESSION['err'] = 2;
        header("Location: register.php");
        die;
    }
    if($k[2] == $haslo){
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $haslo;
        $_SESSION['email'] = $email;
        $_SESSION['tel'] = $telefon;
        $_SESSION['err'] = 3;
        header("Location: register.php");
        die;
    }
}

if(!preg_match("/[a-zA-Z0-9\.\-+]+@[a-zA-Z0-9]+\.[a-zA-Z]+/", $email)){
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['email'] = $email;
    $_SESSION['tel'] = $telefon;
    $_SESSION['err'] = 7;
    header("Location: register.php");
    die;
}

if(!preg_match("/.{6,}/", $login)){
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['email'] = $email;
    $_SESSION['tel'] = $telefon;
    $_SESSION['err'] = 8;
    header("Location: register.php");
    die;
}

if(!preg_match("/[0-9]{9,}/", $telefon)){
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['email'] = $email;
    $_SESSION['tel'] = $telefon;
    $_SESSION['err'] = 9;
    header("Location: register.php");
    die;
}

if(strlen($haslo) < 8 ||
    !preg_match("/[A-Z]{2,}/", $haslo) ||
    !preg_match("/[a-z]{2,}/", $haslo) ||
    !preg_match("/[0-9]{2,}/", $haslo) ||
    !preg_match("/[^A-Z^a-z^0-9]{2,}/", $haslo) ||
    !preg_match("/[0-9]*[50][^0-9]?/", $haslo)){
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['email'] = $email;
    $_SESSION['tel'] = $telefon;
    $_SESSION['err'] = 6;
    header("Location: register.php");
    die;
}

mysqli_query($id, "start transaction;");

if(!mysqli_query($id, "insert into klient(login, haslo, telefon, adres_e_mail) value ('$login', '$haslo', '$telefon', '$email');")){
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['email'] = $email;
    $_SESSION['tel'] = $telefon;
    $_SESSION['err'] = 5;
    $_SESSION['errcode'] = mysqli_errno($id);
    $_SESSION['errdesc'] = mysqli_error($id);
    header("Location: register.php");
    die;
}

$USER_ID = mysqli_query($id, "select id_klienta from klient where login = '$login' and haslo = '$haslo' and adres_e_mail = '$email'");
$USER_ID = mysqli_fetch_row($USER_ID)[0];

if(!$USER_ID){
    mysqli_query($id, "rollback;");
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['email'] = $email;
    $_SESSION['tel'] = $telefon;
    $_SESSION['err'] = 5;
    header("Location: register.php");
    die;
}

mysqli_query($id, "commit;");

$_SESSION['uid'] = $USER_ID;
$_SESSION['errcode'] = null;
$_SESSION['errdesc'] = null;
$_SESSION['err'] = null;

header("Location: settings.php");
die;

?>