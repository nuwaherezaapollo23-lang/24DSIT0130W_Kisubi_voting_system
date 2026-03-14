<?php
$host="localhost";
$user="root";
$password="23031";
$db="kisubi_voting";

$con=mysqli_connect($host,$user,$password,$db);
if(!$con){
die("Connection Failed");
}
?>
