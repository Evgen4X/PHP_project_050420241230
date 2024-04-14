<?php

function encode($text){
    $res = "";
    $text = strval($text);
    for($i = 0; $i < strlen($text); ++$i){
        $char = $text[$i];
        $rnd = rand(0, 15);
        $code = ord($char);
        if($code - $rnd == 38){
            ++$rnd;
        }

        $res .= chr($code + 30 - $rnd).chr($code + 30 + $rnd);
    }

    return $res;
}

function decode($text){
    $res = "";
    $text = strval($text);
    for($i = 0; $i < strlen($text); $i += 2){
        $c1 = ord($text[$i]);
        $c2 = ord($text[$i + 1]);
        $res .= chr(($c1 + $c2 - 60) / 2);
    }

    return $res;
}

?>