<?php
if($_GET[rid]<1)$_GET[rid]=1;
header("location:../index.php?rid=$_GET[rid]");
?>