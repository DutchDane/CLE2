<?php
session_start();

if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

/** @var mysqli $db */
require_once "includes/database.php";

if (isset($_POST['submit'])) {
    $username = mysqli_escape_string($db, $_POST['username']);
    $password = $_POST['password'];

    $errors = [];
    if($username == '') {
        $errors['username'] = 'Voer een gebruikersnaam in.';
    }
    if($password == '') {
        $errors['password'] = 'Voer een wachtwoord in.';
    }

    if(empty($errors))
    {
        //Get record from DB based on username
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $login = true;

                $_SESSION['loggedInUser'] = [
                    'username' => $user['username'],
                    'id' => $user['id']
                ];

                header('Location: reservations.php');
            } else {
                //error onjuiste inloggegevens
                $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend.';
            }
        } else {
            //error onjuiste inloggegevens
            $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend.';
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
                    <h2>Inloggen</h2>

                    <?php if ($login) { ?>
                        <p>Je bent ingelogd!</p>
                        <p><a href="logout.php">Uitloggen</a></p>
                    <?php } ?>

                    <label for="username">Gebruikersnaam<span style="color: orange">*</span></label><br>
                    <input type="text" name="username" required="true" value="<?= $username ?? '' ?>"><br>
                    <?php
                    if (isset($errors['username'])) { ?>
                        <span class="span-errors"><?php echo $errors['username']; ?></span><br><br>
                    <?php } ?>

                    <label for="password">Wachtwoord<span style="color: orange">*</span></label><br>
                    <input type="text" name="password" required="true" value="<?= $password ?? '' ?>"><br>
                    <?php
                    if (isset($errors['password'])) { ?>
                        <span class="span-errors"><?php echo $errors['password']; ?></span><br><br>
                    <?php } ?>

                    <p class="errors"><?= $errors['loginFailed'] ?? '' ?></p>
                    <input type="submit" name="submit" value="Inloggen">

                </form>
                <br>
            </div>
        </div>
    </section>
</main>
</body>
</html>
