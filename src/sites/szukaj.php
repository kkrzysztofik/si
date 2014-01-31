<?php

include_once('inc/common.php');

$is_permitted = check_permission(1);

if(!$is_permitted) {
    die('Permission denited');
}

if(isset($_POST["szukaj"])){
    $_SESSION['zapytanie'] = sanitize_string($_POST["zapytanie"]);
}
$tmp = $_SESSION['zapytanie'];

echo("Wynik wyszukiwania dla: ". $_SESSION['zapytanie']);

if (!empty($_GET['page']) && isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int) $_GET['page'];
    if ($page < 1) {
        $page = 1;
    }
} else {
    $page = 1;
}

$tmp_table = explode(' ', $tmp);
//$tmp = preg_replace('/\s+/', '', $tmp);
//$tmp_table = explode('&', $tmp_table);
//$tmp_table = str_replace('amp;', '', $tmp_table);
//var_dump($tmp_table);
//foreach ($tmp_table as $string){
//    $string = str_replace('&', '', $string);
//}

$start = ($page - 1) * $employees_perPage;

$SQL = "SELECT COUNT(*) FROM formularz WHERE ";
for($i = 0; $i < count($tmp_table); $i++) {
    $SQL = $SQL . "nazwisko LIKE '%$tmp_table[$i]%' ";
    if($i < count($tmp_table)-1) {
        $SQL = $SQL ."OR ";
    }
}
$SQL = $SQL . "ORDER BY id ASC";

$wynik1 = mysql_query($SQL);
$num1 = mysql_result($wynik1, 0, 'Count(*)');

//$SQL = "SELECT COUNT(*) FROM formularz WHERE nazwisko LIKE '%".$tmp."%' ORDER BY id asc LIMIT ".$start.','.$employees_perPage.';';
//$wynik = mysql_query($SQL);
//$num = mysql_result($wynik, 0, 'Count(*)');

$max=ceil($num1/$employees_perPage);

$SQL = "SELECT * FROM formularz WHERE ";
for($i = 0; $i < count($tmp_table); $i++) {
    $SQL = $SQL . "nazwisko LIKE '%$tmp_table[$i]%' ";
    if($i < count($tmp_table)-1) {
        $SQL = $SQL ."OR ";
    }
}
$SQL = $SQL . "ORDER BY id asc LIMIT ".$start.','.$employees_perPage.';';

//echo $SQL;
$rows = mysql_query($SQL);
?>

<table>
    <tr>
        <td>ID</td>
        <td>Imię</td>
        <td>Nazwisko</td>
        <td>Płeć</td>
        <td>Nazwisko panieńskie</td>
        <td>Email</td>
        <td>Kod pocztowy</td>
    </tr>
    <?php
    while ($result = mysql_fetch_assoc($rows)) {
        ?>
        <tr>
            <td> <?php echo sanitize_string($result['id']); ?> </td>
            <td> <?php echo sanitize_string($result['imie']); ?></td>
            <td> <?php echo sanitize_string($result['nazwisko']); ?></td>
            <td> <?php if($result['plec']) { echo 'Kobieta'; } else { echo 'Mężczyzna'; }; ?></td>
            <td> <?php echo sanitize_string($result['nazw_panienskie']); ?></td>
            <td> <?php echo sanitize_string($result['email']); ?></td>
            <td> <?php echo sanitize_string($result['kod_pocztowy']); ?></td>
        </tr>
    <?php
    }
    ?>
</table>
<div id="paging">
    <?php
    /////////////////////////////////////////////////////////////
    $prev = $page - 1;
    $next = $page + 1;

    ///..................numery stron
    if($prev > 0) {
        echo '<a href="index.php?site=4&page='.$prev.'"><-</a>';
    } else {
        echo '<-';
    }

    for($i=0; $i<$max; $i++)
    {
        $tmp = $i + 1;
        echo '<a href="index.php?site=4&page='.$tmp.'">'.$tmp.'</a>';
        if(($i!=$max)-1)
            echo" |";

    }

    if($next<=$max){
        echo '<a href="index.php?site=4&page='.$next.'">-></a>';
    } else {
        echo '->';
    }

    ?>
</div>
