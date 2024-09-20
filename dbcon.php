<?php
$host = "localhost";
$user ="root";
$pass = "";
$dbname = "phptutorial";

$conn = mysqli_connect($host,$user,$pass,$dbname);

if(!$conn)
{
    echo "Not connected". mysqli_connect_error();
}
else
{
    echo "";
}