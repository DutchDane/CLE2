<?php

// Get the number for the current hour (24 clock)
$hours = date('G');

// It is morning when the hours of the day contain:
// 00, 01, 02, 03, 04, 05
if ($hours < 6) {
    $greeting = 'Goedenacht';
}
// 06, 07, 08, 09, 10 ,11
elseif ($hours < 12) {
    $greeting = 'Goedemorgen';
}
elseif ($hours < 18) {
    $greeting = 'Goedemiddag';
}
else {
    $greeting = 'Goedenavond';
}

?>

<?= $greeting ?>
