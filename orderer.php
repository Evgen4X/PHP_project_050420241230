<?php

$id = mysqli_connect('localhost', 'root', '', 'ksiegarnia');
if(!$id){
    echo "<form action='order.php' method='post' id='form'>
    <input type='hidden' name='uid' value='".$_POST['uid']."'>
    <input type='hidden' name='data' value='".$_POST['kid']."'>
    <input type='hidden' name='err' value='1'>
    <input type='hidden' name='errcode' value='".mysqli_connect_errno()."'>
    <input type='hidden' name='errdesc' value='".mysqli_connect_error()."'>
    </form>

    <script>$('#form').submit();</script>";
}

$res = mysqli_query($id, 'update ksiazki set ilosc = ilosc - '.$_POST['ilosc'].' where id_ksiazki = '.$_POST['kid']);
if(!$res){
    echo "<form action='order.php' method='post' id='form'>
    <input type='hidden' name='uid' value='".$_POST['uid']."'>
    <input type='hidden' name='data' value='".$_POST['kid']."'>
    <input type='hidden' name='err' value='2'>
    <input type='hidden' name='errcode' value='".mysqli_errno($id)."'>
    <input type='hidden' name='errdesc' value='".mysqli_error($id)."'>
    </form>

    <script>$('#form').submit();</script>";
}

echo "<form action='order.php' method='post' id='form'>
    <input type='hidden' name='uid' value='".$_POST['uid']."'>
    <input type='hidden' name='data' value='".$_POST['kid']."'>
    <input type='hidden' name='err' value='0'>
    </form>

    <script>$('#form').submit();</script>";

?>