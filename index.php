<?php

session_start();

if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

//Require database in this file
/** @var $db */
require_once "includes/database.php";

$currentDate = date('d:m:Y');

if (isset($_POST['submit'])) {

    $first_name = mysqli_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_escape_string($db, $_POST['last_name']);
    $amount_of_people = mysqli_escape_string($db, $_POST['amount_of_people']);
    $date = mysqli_escape_string($db, $_POST['date']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $phone = mysqli_escape_string($db, $_POST['phone']);

    //Require the form validation handling
    require_once "includes/form-validation.php";

    if (empty($errors)) {
        //INSERT in DB
        $query = "INSERT INTO reservations (first_name, last_name, amount_of_people, date, email, phone) VALUES ('$first_name', '$last_name', '$amount_of_people', '$email', '$date', '$phone')";

        $result = mysqli_query($db, $query) or die('Error: ' .mysqli_error($db).' with query: '.$query);
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
if (isset($errors['db'])) {
    echo $errors['db'];
} elseif (isset($success)) {
    echo $success;
}
?>

<?php
require_once "sections/header.php";
?>

<main>
    <section>
        <div class="reservations_and_faq">
        <div class="reservations_form">
            <form action="" method="post">
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
                <input type="text" name="date" value="<?= $currentDate ?>">
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

        <div class="faq">
            <div class="cd-faq__items">
                <ul id="basics" class="cd-faq__group">
                    <h2>F.A.Q.</h2>
                    <li class="cd-faq__item">
                        <span class="cd-faq_title">How do I change my password?</span>
                        <div class="cd-faq__content">
                            <div class="text-component">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae quidem blanditiis delectus corporis, possimus officia sint sequi ex tenetur id impedit est pariatur iure animi non a ratione reiciendis.</p>
                            </div>
                        </div>
                    </li>
                    <li class="cd-faq__item">
                        <span class="cd-faq_title">How do I change my password?</span>
                        <div class="cd-faq__content">
                            <div class="text-component">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi cupiditate et laudantium esse adipisci consequatur modi possimus accusantium vero atque excepturi nobis in doloremque repudiandae</p>
                            </div>
                        </div>
                    </li>
                    <li class="cd-faq__item">
                        <span class="cd-faq_title">How do I change my password?</span>
                        <div class="cd-faq__content">
                            <div class="text-component">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis provident officiis, reprehenderit numquam. Praesentium veritatis eos tenetur magni debitis inventore fugit, magnam, reiciendis, saepe obcaecati ex vero quaerat distinctio velit.</p>
                            </div>
                        </div>
                    </li>
                    <li class="cd-faq__item">
                        <span class="cd-faq_title">How do I change my password?</span>
                        <div class="cd-faq__content">
                            <div class="text-component">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis provident officiis, reprehenderit numquam. Praesentium veritatis eos tenetur magni.</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        </div>
    </section>
</main>
</body>
</html>
