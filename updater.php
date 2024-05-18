<?php
session_start();
?>
<?php

$origin = $_POST['origin'];

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
if(!$id){
    $_SESSION['err'] = 1;
    $_SESSION['errcode'] = mysqli_connect_errno();
    $_SESSION['errdesc'] = mysqli_connect_error();
    header("Location: $origin");
    die;
}

$query = "update klient set ";
$comma = false;

foreach($_POST as $key => $val){
    if(in_array($key, ['imie', 'nazwisko', 'data_urodzenia', 'plec', 'kod_pocztowy', 'miejscowosc', 'ulica', 'nr_domu', 'telefon', 'adres_e_mail'])){
        $query .= ($comma ? ', ' : '').$key." = '".str_replace("'", "\\'", $val)."'";
        $comma = true;
    } elseif(in_array($key, ['gatunki', 'jezyki'])){
        $value = "";
        foreach($val as $valval){
            $value .= $valval . ", ";
        }
    }
}

if($query != "update klient set "){
    $query .= " where id_klienta = ".$_SESSION['uid'];


    $result = mysqli_query($id, $query);
    if(!$result){
        $_SESSION['err'] = 2;
        $_SESSION['errcode'] = mysqli_errno($id);
        $_SESSION['errdesc'] = mysqli_error($id);
        header("Location: $origin");
        die;
    }
}

header("Location: $origin");
die;

?>