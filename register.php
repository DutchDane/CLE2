<?php

session_start();

if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

if(isset($_POST['submit'])) {
    require_once "includes/database.php";

    /** @var mysqli $db */

    $username = mysqli_escape_string($db, $_POST['username']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    $errors = [];
    if($username == '') {
        $errors['username'] = 'Voer een gebruikersnaam in.';
    }
    if($email == '') {
        $errors['email'] = 'Voer een emailadres in.';
    }
    if($password == '') {
        $errors['password'] = 'Voer een wachtwoord in.';
    }

    if(empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        $result = mysqli_query($db, $query)
        or die('Db Error: '.mysqli_error($db).' with query: '.$query);

        if ($result) {
            header('Location: login.php');
            exit;
        }
    }
}
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

<main>
    <section>
        <div class="reservations_and_faq">
            <div class="reservations_form">
                <form action="" method="post">
                    <h2>Registreren</h2>

                    <?php if ($login == true) { ?>
                        <p>Je bent al ingelogd. <a href="reservations.php">Ga naar Reserveringen</a></p>
                    <?php } ?>

                    <label for="username">Gebruikersnaam<span style="color: orange">*</span></label><br>
                    <input type="text" name="username" required="true" value="<?= $username ?? '' ?>"><br>
                    <?php
                    if (isset($errors['username'])) { ?>
                        <span class="span-errors"><?php echo $errors['username']; ?></span><br><br>
                    <?php } ?>

                    <label for="email">Email<span style="color: orange">*</span></label><br>
                    <input type="text" name="email" required="true" value="<?= $email ?? '' ?>"><br>
                    <?php
                    if (isset($errors['email'])) { ?>
                        <span class="span-errors"><?php echo $errors['email']; ?></span><br><br>
                    <?php } ?>

                    <label for="password">Wachtwoord<span style="color: orange">*</span></label><br>
                    <input type="text" name="password" required="true" value="<?= $password ?? '' ?>"><br>
                    <?php
                    if (isset($errors['password'])) { ?>
                        <span class="span-errors"><?php echo $errors['password']; ?></span><br><br>
                    <?php } ?>

                    <input type="submit" name="submit" value="Registreren">

                </form>
                <br>
            </div>
        </div>
    </section>
</main>
</body>
</html>
