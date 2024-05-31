<?php
session_start();
?>
<?php

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
$toInsert = "INSERT INTO klient VALUE (null, ";
foreach($_POST as $k => $v){
    if(preg_match("/delete.*/", $k)){
        if($v == "1"){
            $idd = explode("_", $k)[1];
            mysqli_query($id, "DELETE FROM klient WHERE id_klienta = $idd;");
        }
        continue;
    }
    $vv = $v;
    $what = join("_", explode("-", explode("_", $k)[0]));
    $idd = explode("_", $k)[1];
    if(!preg_match("/.*(nr_domu|plec).*/", $what)){
        $vv = '"'.$v.'"';
    }
    if($idd == 'NULL'){
        $toInsert .= $vv . ',';
    } else {
        mysqli_query($id, "UPDATE klient SET $what = $vv WHERE id_klienta = $idd;");
    }
}

if($toInsert != "INSERT INTO klient VALUE (null, "){
    mysqli_query($id, substr($toInsert, 0, strlen($toInsert) - 1).");");
}

header("Location: admin.php");
die;

?>