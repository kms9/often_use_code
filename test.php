<?php
include_once "AesCode2.php";

$testKey = "just a test key".time();

$encKey = "";
if(version_compare(PHP_VERSION,'7.0.0','ge')) {

    echo "\n  php7 \n";
    $encKey = AesCode2::encrypt_openssl($testKey);
    var_dump($encKey);
}else{
    echo "\n  php5 \n";
    $encKey = AesCode2::encrypt_mcrypt($testKey);
    var_dump($encKey);
}

$encKey = "HhL8Pf2+LTcG+AHUxwZm9ZkLtVsi7INwDJ8CAd9pYJUHcIL1dSCYtTUUdDwqPDx3";

var_dump($encKey);


if(version_compare(PHP_VERSION,'7.0.0','ge')) {

    echo "\n  php7 \n";
    $decKey = AesCode2::decrypt_openssl($encKey);
    var_dump($decKey);
}else{
    echo "\n  php5 \n";
    $decKey = AesCode2::decrypt_mcrypt($encKey);
    var_dump($decKey);

}

