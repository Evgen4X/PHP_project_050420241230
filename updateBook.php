<?php
session_start();
?>
<?php

$id = mysqli_connect("localhost", "root", "", "ksiegarnia");
foreach($_POST as $k => $v){
    if(preg_match("/delete.*/", $k)){
        if($v == "1"){
            $idd = explode("_", $k)[1];
            mysqli_query($id, "DELETE FROM ksiazki WHERE id_ksiazki = $idd;");
        }
        continue;
    }
    $vv = $v;
    $what = join("_", explode("-", explode("_", $k)[0]));
    $idd = explode("_", $k)[1];
    if(!preg_match("/.*(cena|id|ilosc|rok).*/", $k)){
        $vv = '"'.$v.'"';
    }
    mysqli_query($id, "UPDATE ksiazki SET $what = $vv WHERE id_ksiazki = $idd;");
}

header("Location: admin.php");
die;

?>