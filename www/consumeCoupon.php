<?php
$connect=mysql_connect("localhost","echo","1351915");
$mysql=mysql_select_db("echo",$connect);
if(!$connect) echo "wrong connect";

$couponId = $_GET["couponId"];
$query = "update coupon set used = 1 where id = \"$couponId\" ";
$result = mysql_query($query);
echo $result;
?>