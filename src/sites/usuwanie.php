<?php

include_once('inc/common.php');

$is_permitted = check_permission(3);

if(!$is_permitted) {
    die('Permission denited');
}

if (!empty($_GET['page']) && isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int) $_GET['page'];
    if ($page < 1) {
        $page = 1;
    }
}
else {
    $page = 1;
}

$start = ($page - 1) * $employees_perPage;

$SQL = 'SELECT COUNT(*) FROM formularz;';
$wynik1 = mysql_query($SQL);
if (!$wynik1) {
    die('Invalid query: ' . mysql_error());
}
$num1 = mysql_result($wynik1, 0, 'Count(*)');

$SQL = 'SELECT COUNT(*) FROM formularz ORDER BY id asc LIMIT '.$start.','.$employees_perPage.';';
$wynik = mysql_query($SQL);
if (!$wynik) {
    die('Invalid query: ' . mysql_error());
}
$num = mysql_result($wynik, 0, 'Count(*)');

$max=ceil($num1/$employees_perPage);

$SQL = 'SELECT * FROM formularz ORDER BY id asc LIMIT '.$start.','.$employees_perPage.';';
$rows = mysql_query($SQL);
if (!$rows) {
    die('Invalid query: ' . mysql_error());
}
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
        <td>&nbsp;</td>
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
            <td><a href="index.php?site=8&id=<?php echo sanitize_string($result['id']); ?>">Usuń</a></td>
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
        echo '<a href="/index.php?site=6&page='.$prev.'"><-</a>';
    } else {
        echo '<-';
    }

    for($i=0; $i<$max; $i++)
    {
        $tmp = $i + 1;
        echo '<a href="/index.php?site=6&page='.$tmp.'">'.$tmp.'</a>';
        if(($i!=$max)-1)
            echo" |";

    }

    if($next<$max){
        echo '<a href="/index.php?site=6&page='.$next.'">-></a>';
    } else {
        echo '->';
    }

    ?>
</div>