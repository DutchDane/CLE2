<?php

session_start();

// Checks if this page may be visited
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

//Get username from session
$username = $_SESSION['loggedInUser']['username'];

/** @var $db */
require_once "includes/database.php";

$time = date('G:i');

$query = "SELECT * FROM reservations";

// Query uitvoeren op de database. Als dit goed gaat, geeft mysqli_query een mysqli_result terug. Let op, dit is een tabel.
$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$reservations = [];

while($row = mysqli_fetch_assoc($result))
{
    // elke rij (dit is een reservering) wordt aan de array 'reservations' toegevoegd.
    $reservations[] = $row;
}

mysqli_close($db);

?>

<!doctype html>
<html lang="en">

<?php
require_once "includes/head.html";
?>

<body>

<?php
require_once "sections/header.php";
?>

<div class="reservations-table">
    <h1><?php include_once "includes/greeting.php"; ?> <?= htmlentities($username) ?>, het is <?= $time ?>.</h1>

    <div class="reservations-overview-functions">
    <p><a href="create.php">Reservering aanmaken</a></p>
    <p><a href="logout.php">Uitloggen</a></p>
    </div>

    <table>
    <thead>
        <tr>
            <th>#</th>
            <th>Voornaam</th>
            <th>Achternaam</th>
            <th>Aantal</th>
            <th>Datum</th>
            <th>Email</th>
            <th>Telefoon</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="8">&copy; Kaap</td>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($reservations as $reservation) {?>
        <tr>
            <td><?= htmlentities($reservation['id']) ?></td>
            <td><?= htmlentities($reservation['first_name']) ?></td>
            <td><?= htmlentities($reservation['last_name']) ?></td>
            <td><?= htmlentities($reservation['amount_of_people']) ?></td>
            <td><a href="mailto:<?= htmlentities($reservation['email']) ?>"><?= htmlentities($reservation['email']) ?></a></td>
            <td><?= htmlentities($reservation['date']) ?></td>
            <td><a href="tel:<?= htmlentities($reservation['phone']) ?>"><?= htmlentities($reservation['phone']) ?></a></td>
            <td><a href="details.php?id=<?= htmlentities($reservation['id']) ?>"><img src="../yartroom/assets/view.png" class="reservations-table-icons" width="25px"></a></td>
            <td><a href="edit.php?id=<?= htmlentities($reservation['id']) ?>"><img src="../yartroom/assets/edit.png" class="reservations-table-icons" width="25px"></a></td>
            <td><a href="delete.php?id=<?= htmlentities($reservation['id']) ?>"><img src="../yartroom/assets/bin.png" class="reservations-table-icons" width="25px"></a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

    <?php if (mysqli_num_rows($result) == 0) { ?>
        <span class="span-errors"><?= 'Je hebt (nog) geen reserveringen voor vandaag.' ?></span>
    <?php } ?>

</div>
</body>
</html>