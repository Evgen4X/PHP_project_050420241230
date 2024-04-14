<?php

include("cipher.php");

$login = str_replace("'", "\\'", $_POST['login']);
$password = str_replace("'", "\\'", $_POST['password']);

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
if(!$id){
    header("Location: login.php?login=$login&password=$haslo&err=1&errcode=".mysqli_connect_errno()."&errdesc=".mysqli_connect_error());
    exit;
}

$res = mysqli_query($id, "select login, haslo, id_klienta from klient;");

if(!$res){
    header("Location: login.php?login=$login&password=$haslo&err=2&errcode=".mysqli_errno($id)."&errdesc=".mysqli_error($id));
    exit;
}

$found = false;
while($row = mysqli_fetch_row($res)){
    if($row[0] == $login && $row[1] == $password){
        $found = true;
        $USER_ID = encode($row[2]);
    }
}

if(!$found){
    header("Location: login.php?login=$login&password=$haslo&err=3");
    exit;
}

// header("Location: index.php?uid=".encode($USER_ID));
header("Location: index.php?uid=$USER_ID");
exit;

?>
