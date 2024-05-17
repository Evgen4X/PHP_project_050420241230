<?php
session_start();
?>

<?php

unset($_SESSION['errcode']);
unset($_SESSION['errdesc']);
unset($_SESSION['err']);

$login = str_replace("'", "\\'", $_POST['login']);
$haslo = str_replace("'", "\\'", $_POST['password']);

if(time() - $_POST['start'] < 5){ //prevents entering log in data too fast
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['err'] = 3;
    header("Location: login.php");
    die;
}

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
if(!$id){
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['err'] = 1;
    $_SESSION['errcode'] = mysqli_connect_errno();
    $_SESSION['errdesc'] = mysqli_connect_error();
    header("Location: login.php");
    die;
}

$res = mysqli_query($id, "select login, haslo, id_klienta from klient;");

if(!$res){
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $haslo;
    $_SESSION['err'] = 2;
    $_SESSION['errcode'] = mysqli_errno();
    $_SESSION['errdesc'] = mysqli_error();
    header("Location: login.php");
    die;
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
    die;
}


$_SESSION['uid'] = $USER_ID;
header("Location: index.php");
die;

?>
