<?php
$kasutaja='raamatukogu'; //larionov
$server='localhost'; // localhost
$andmebaas='raamatukogu';
$salasyna='123456';//d113366_markbaas 123456
//teeme käsk mis ühendab andmebaasiga
$yhendus=new mysqli($server,$kasutaja,$salasyna,$andmebaas);
$yhendus ->set_charset('UTF8');
?>