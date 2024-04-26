<?php
session_start();
?>

<?php

include("cipher.php");

$login = str_replace("'", "\\'", $_POST['login']);
$haslo = str_replace("'", "\\'", $_POST['password']);

if(time() - $_POST['start'] < 7){ //prevents entering log in data too fast (min 7 sec. is requied to pass)
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['err'] = 3;
    header("Location: login.php");
    exit;
}

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
if(!$id){
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['err'] = 1;
    $_SESSION['errcode'] = mysqli_connect_errno();
    $_SESSION['errdesc'] = mysqli_connect_error();
    header("Location: login.php");
    exit;
}

$res = mysqli_query($id, "select login, haslo, id_klienta from klient;");

if(!$res){
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['err'] = 2;
    $_SESSION['errcode'] = mysqli_errno();
    $_SESSION['errdesc'] = mysqli_error();
    header("Location: login.php");
    exit;
}

$found = false;
while($row = mysqli_fetch_row($res)){
    if($row[0] == $login && $row[1] == $haslo){
        $found = true;
        $USER_ID = $row[2];
    }
}

if(!$found){
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['err'] = 3;
    header("Location: login.php");
    exit;
}


$_SESSION['uid'] = $USER_ID;
header("Location: index.php");
exit;

?>
