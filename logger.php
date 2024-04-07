<?php

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
if(!$id){
    header("Location: login.php?err=1");
    exit;
}

$res = mysqli_query($id, "select login, haslo from klient;");

if(!$res){
    header("Location: login.php?err=2");
    exit;
}

$login = $_POST['login'];
$password = $_POST['password'];

$found = false;
while($row = mysqli_fetch_row($res)){
    if($row[0] == $login && $row[2] == $password){
        $found = true;
    }
}

if(!$found){
    header("Location: login.php?err=3");
    exit;
}

?>