<?php

$id = mysqli_connect("localhost", "root", "", "ksiegarnia_internetowa");
if(!$id){
    
}

$res = mysqli_query($id, "select login, haslo from klient;");

if(!res){

}

$login = $_POST['login'];
$password = $_POST['password'];

while($row = mysqli_fetch_rows($res)){
    if($row[0] == $login && $row[2] == $password){

    }
}

?>