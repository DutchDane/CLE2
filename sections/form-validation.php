<?php
//Checks if the data is valid & generates an error if not so
$errors = [];

if ($last_name == "") {
    $errors['last_name'] = "Vul alstublieft uw achternaam in.";
}

if ($amount_of_people == "") {
    $errors['amount_of_people'] = "Vul alstublieft het aantal mensen in.";
}

if ($date == "") {
    $errors['date'] = "Vul alstublieft de datum waarop u wilt reserveren in.";
}

if (strlen($date) != 10) {
    $errors['date'] = 'Herschrijf uw datum in dit format: "dd-mm-yyyy".';
}

if ($phone == "") {
    $errors['phone'] = "Vul alstublieft uw telefoonnummer in.";
}