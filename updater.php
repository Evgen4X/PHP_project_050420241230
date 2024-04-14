<?php

include("cipher.php");

$origin = $_POST['origin'];

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
if(!$id){
    header("Location: $origin?uid=".encode($_POST['uid'])."&err=1&errcode=".mysqli_connect_errno().'&errdesc='.mysqli_connect_error());
    exit;
}

$query = "update klient set ";
$comma = false;

foreach($_POST as $key => $val){
    if(in_array($key, ['imie', 'nazwisko', 'data_urodzenia', 'kod_pocztowy', 'miejscowosc', 'ulica', 'nr_domu', 'telefon', 'adres_e_mail'])){
        $query .= ($comma ? ', ' : '').$key." = '".str_replace("'", "\\'", $val)."'";
        $comma = true;
    }
}

$query .= " where id_klienta = ".$_POST['uid'];


$result = mysqli_query($id, $query);
if(!$result){
    header("Location: $origin?uid=".encode($_POST['uid'])."&err=2&errcode=".mysqli_errno($id).'&errdesc='.mysqli_error($id));
    exit;
}

header("Location: $origin?uid=".encode($_POST['uid']));
exit;


?>