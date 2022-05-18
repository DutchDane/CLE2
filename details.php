<?php
/** @var mysqli $db */

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

// redirect when uri does not contain an id
if(!isset($_GET['id']) || $_GET['id'] == '') {
    // redirect to index.php
    header('Location: reservations.php');
    exit;
}

require_once "includes/database.php";

$reservationId = mysqli_escape_string($db, $_GET['id']);

$query = "SELECT * FROM reservations WHERE id = '$reservationId'";
$result = mysqli_query($db, $query)
or die ('Error: ' . $query );

if(mysqli_num_rows($result) != 1)
{
    // redirect when db returns no result
    header('Location: reservations.php');
    exit;
}

$reservation = mysqli_fetch_assoc($result);

//Close connection
mysqli_close($db);
?>

<!doctype html>
<html lang="en">

<?php
require_once "includes/head.html";
?>

<body>

<?php
if (isset($errors['db'])) {
    echo $errors['db'];
} elseif (isset($success)) {
    echo $success;
}
?>

<?php
require_once "sections/header.php";
?>

<h1><?= htmlentities($reservation['last_name']) . ' - ' . htmlentities($reservation['id']) ?></h1>

<ul>
    <li>Voornaam:  <?= htmlentities($reservation['first_name']) ?></li>
    <li>Achternaam:   <?= htmlentities($reservation['last_name']) ?></li>
    <li>Aantal: <?= htmlentities($reservation['amount_of_people']) ?></li>
    <li>Email: <?= htmlentities($reservation['email']) ?></li>
    <li>Telefoon: <?= htmlentities($reservation['phone']) ?></li>
</ul>
<div>
    <a href="reservations.php">Go back to the list</a>
</div>
</body>
</html>