<?php
error_reporting(0);
include "../include/phpqrcode.php";
QRcode::png($_GET['url'], false, 'L', 5, 2);
?>