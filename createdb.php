<?php

$id = mysqli_connect("localhost", "root", "");
mysqli_query($id, "drop database ksiegarnia;");
mysqli_query($id, "create database ksiegarnia;");
mysqli_select_db($id, "ksiegarnia");

$file = fopen("ksiegarnia.sql", "r");
if($file){
    $commented = false;
    $query = "";
    while(($line = fgets($file)) != false){
        // echo $line.'<br>';

        if(substr($line, 0, 2) == '--'){
            continue;
        }
        if(substr($line, 0, 2) == '/*'){
            $commented = true;
        }
        if($commented){
            if(preg_match('/.*\*\/;/', $line)){
                $commented = false;
            }
            continue;
        }

        $query .= trim($line);
        if(preg_match('/.*;.?/', $line)){
            try{
            mysqli_query($id, $query);}
            catch(Exception $e){}
            $query = "";
        }
    }

    echo $query;

    fclose($file);
}

?>