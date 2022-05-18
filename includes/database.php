<?php

$host       = "localhost";
$user       = "root";
$password   = "";
$database   = "reservations_kaap";

$db = mysqli_connect($host, $user, $password, $database)
or die("Error: " . mysqli_connect_error());
