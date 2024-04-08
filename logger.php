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

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
if(!$id){
    header("Location: login.php?err=1&errdesc=".mysqli_error($id));
    exit;
}

$res = mysqli_query($id, "select login, haslo, id_klienta from klient;");

if(!$res){
    header("Location: login.php?err=2&errdesc=".mysqli_error($id));
    exit;
}

$login = $_POST['login'];
$password = $_POST['password'];

$USER_ID = -1;

$found = false;
while($row = mysqli_fetch_row($res)){
    if($row[0] == $login && $row[1] == $password){
        $found = true;
        $USER_ID = $row[2];
    }
}

if(!$found){
    header("Location: login.php?err=3");
    exit;
}

header("Location: index.php?uid=.".encode($USER_ID));
exit;

?>