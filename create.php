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

$currentDate = date('d:m:Y');

//Check if Post isset, else do nothing
if (isset($_POST['submit'])) {
    //Require database in this file
    require_once "includes/database.php";

    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $first_name = mysqli_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_escape_string($db, $_POST['last_name']);
    $amount_of_people = mysqli_escape_string($db, $_POST['amount_of_people']);
    $date = mysqli_escape_string($db, $_POST['date']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $phone = mysqli_escape_string($db, $_POST['phone']);

    //Require the form validation handling
    require_once "includes/form-validation.php";

    if (empty($errors)) {

        //Save the record to the database
        $query = "INSERT INTO reservations (first_name, last_name, amount_of_people, date, email, phone)
                  VALUES ('$first_name', '$last_name', '$amount_of_people', '$date', '$email', '$phone')";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        if ($result) {
            header('Location: reservations.php');
            exit;
        } else {
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        //Close connection
        mysqli_close($db);
    }
}
?>

<!doctype html>
<html lang="en">

<?php
require_once "includes/head.html";
?>

<?php
require_once "sections/header.php";
?>

<body>
<h1>Reservering aanmaken</h1>
<?php if (isset($errors['db'])) { ?>
    <div><span class="errors"><?= $errors['db']; ?></span></div>
<?php } ?>

<!-- enctype="multipart/form-data" no characters will be converted -->
<div class="reservations_form">
    <form action="" method="post" enctype="multipart/form-data">
        <h2>Reserveren</h2>
        <label for="first_name">Voornaam</label><br>
        <input type="text" name="first_name"><br>

        <label for="last_name">Achternaam<span style="color: orange">*</span></label><br>
        <input type="text" name="last_name" required="true"><br>
        <?php
        if (isset($errors['last_name'])) { ?>
            <span class="span-errors"><?php echo $errors['last_name']; ?></span><br><br>
        <?php } ?>

        <label for="amount_of_people">Aantal mensen<span style="color: orange">*</span></label><br>
        <select name="amount_of_people" required="true">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="Meer dan 6">Meer dan 6</option>
        </select><br>
        <?php
        if (isset($errors['amount_of_people'])) { ?>
            <span class="span-errors"><?php echo $errors['amount_of_people']; ?></span><br><br>
        <?php } ?>

        <label for="date">Datum<span style="color: orange">*</span></label><br>
        <!--                <input type="date" name="date" value="--><?//= $currentDate ?><!--" min="2021-12-01" max="2022-01-31">-->
        <input type="text" name="date" required="true" value="<?= $currentDate ?>">
        <?php
        if (isset($errors['date'])) { ?>
            <span class="span-errors"><?php echo $errors['date']; ?></span><br><br>
        <?php } ?>

        <label for="email">Email</label><br>
        <input type="email" name="email"><br>

        <label for="phone">Telefoon<span style="color: orange">*</span></label><br>
        <input type="tel" name="phone" required="true"><br>
        <?php
        if (isset($errors['phone'])) { ?>
            <span class="span-errors"><?php echo $errors['phone']; ?></span><br><br>
        <?php } ?>

        <input type="submit" name="submit" value="Reserveer">

        <?php if ($result) {?>
            <span><?php  echo("Je hebt gereserveerd. Bedankt!") ?></span>
        <?php } else { $errors['db'] = mysqli_error($db); } ?>
    </form>
    <br>
</div>
<div>
    <a href="reservations.php">Go back to the list</a>
</div>
</body>
</html>