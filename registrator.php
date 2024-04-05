<?php

$id = mysqli_connect("localhost", "root", "", "ksiegarnia_internetowa");
if(!$id){

}

$klients = mysqli_query($id, "select * from klient");
while($k = mysqli_fetch_rows($klients)){
    if($k[] = ...)
}

if(!mysqli_query($id, "insert into klient value (null, ".$_POST['imie'].", )")){ //TODO: do.

}


?>