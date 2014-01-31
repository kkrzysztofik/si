<?php
if($_SESSION['user_id']) {
    $idpracownika= (int) $_SESSION['user_id'];

    $SQL = "SELECT * FROM user WHERE id='".$idpracownika."' LIMIT 1;";
    $rows = mysql_query($SQL);
    if (!$rows) {
        die('Invalid query: ' . mysql_error());
    }

    $row = mysql_fetch_assoc($rows);

    $imie = $row['imie'];
} else {
    $imie = 'nieznajomy';
};

echo 'Witaj '.$imie.'!';