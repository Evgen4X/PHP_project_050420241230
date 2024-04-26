<?php
session_start();
?>
<?php

$id = mysqli_connect('localhost', 'root', '', 'ksiegarnia');
if(!$id){
    $_SESSION['err'] = 1;
    $_SESSION['errdesc'] = mysqli_connect_error();
    $_SESSION['errcode'] = mysqli_connect_errno();
    header('Location: order.php');
    exit;
}

$res = mysqli_query($id, 'update ksiazki set ilosc = ilosc - '.$_POST['ilosc'].' where id_ksiazki = '.$_POST['kid']);
if(!$res){
    $_SESSION['err'] = 2;
    $_SESSION['errdesc'] = mysqli_error();
    $_SESSION['errcode'] = mysqli_errno();
    header('Location: order.php');
    exit;
}

$_SESSION['err'] = 0;
$_SESSION['errdesc'] = null;
$_SESSION['errcode'] = null;
header('Location: order.php');
exit;

?>