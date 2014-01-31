<?php
if($_SESSION['user_id']) {

} else {
    $imie = 'nieznajomy';
};

echo 'Witaj '.$imie.'!';