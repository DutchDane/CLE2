<?php

session_start();

//May I even visit this page?
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

/** @var $db */
require_once "includes/database.php";

// If ID is not valid, return to reservations page.
if (!isset($_GET['id']) || $_GET['id'] == "") {
    header('Location: reservations.php');
    exit;
}

// Retrieve the ID from the URL
$reservationId = mysqli_escape_string($db, $_GET['id']);

// Create the DELETE query
$query = "DELETE FROM reservations WHERE id = '$reservationId'";

$result = mysqli_query($db, $query) or die(mysqli_error($db));

// Return to reservations page.
header('Location: reservations.php');
exit;

?>