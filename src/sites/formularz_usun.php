<?php

include_once("inc/common.php");

$is_permitted = check_permission(3);

if(!$is_permitted) {
    die('Permission denited');
}


$idpracownika= (int) $_GET['id'];

$SQL = "SELECT COUNT(*) FROM formularz WHERE id='".$idpracownika."';";
$rows = mysql_query($SQL);
if (!$rows) {
    die('Invalid query: ' . mysql_error());
}

$num = mysql_result($rows, 0, 'Count(*)');
if (!$num) {
    header('Location: index.php?site=6');
}

if(isset($_POST["tak"])) {
    $strSQL =  "DELETE FROM formularz WHERE ID='".$idpracownika."';";
    $result = mysql_query ($strSQL);
    if (!$result) {
            die('Invalid query: ' . mysql_error());
    }

    echo("Operacja wykonana pomyślnie");
    echo ('<form action="index.php?site=6" method="post">
                <input type="submit" value="OK" name="OK"/>
           </form>');

} else if(isset($_POST["nie"])) {
    header('Location: index.php?site=6');
} else {
    $strSQL = "SELECT * FROM formularz WHERE ID='$idpracownika'";
    $result = mysql_query($strSQL);

    $imie = mysql_result($result, 0, "imie");
    $nazwisko = mysql_result($result, 0, "nazwisko");

    echo("Czy na pewno chcesz usunąć pracownika $imie $nazwisko ?");
    echo (' <form action="index.php?site=8&id='.$idpracownika.'" method="post">
        <input type="submit" value="tak" name="tak"/> <input type="submit" value="nie" name="nie"/>
        ');
}