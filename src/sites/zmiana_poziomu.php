<?php

include_once('inc/common.php');

$is_permitted = check_permission(4);

if(!$is_permitted) {
    die('Permission denited');
}

if(isset($_POST['wyslij'])) {
    $id = (int) $_POST['id'];

    if($id == $_SESSION['user_id']){
        die('Nie możesz zmienić sobie uprawnień.');
    }

    $uprawnienia = (int) $_POST['uprawnienia'];

    $sql = "UPDATE user SET uprawnienia='".$uprawnienia."' WHERE ID='".$id."';";

    //echo $sql;
    $result = mysql_query($sql);
    if (!$result || $result != 1) {
        die('Invalid query: ' . mysql_error());
    }
    header('Location: index.php?site=12');
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

$SQL = 'SELECT COUNT(*) FROM user;';
$wynik1 = mysql_query($SQL);
if (!$wynik1) {
    die('Invalid query: ' . mysql_error());
}
$num1 = mysql_result($wynik1, 0, 'Count(*)');

$SQL = 'SELECT COUNT(*) FROM user ORDER BY id asc LIMIT '.$start.','.$employees_perPage.';';
$wynik = mysql_query($SQL);
if (!$wynik) {
    die('Invalid query: ' . mysql_error());
}
$num = mysql_result($wynik, 0, 'Count(*)');

$max=ceil($num1/$employees_perPage);

$SQL = 'SELECT * FROM user ORDER BY id asc LIMIT '.$start.','.$employees_perPage.';';
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
        <td>Login</td>
        <td>Poziom</td>
        <td>&nbsp;</td>
    </tr>
    <?php
    while ($result = mysql_fetch_assoc($rows)) {
        $uprawnienia = (int) $result['uprawnienia'];
        ?>
        <form action="" method="post" id="form_<?php echo sanitize_string($result['id']); ?>">
            <tr>
                <input name="id" id="id" type="hidden" value="<?php echo sanitize_string($result['id']); ?>">
                <td> <?php echo sanitize_string($result['id']); ?> </td>
                <td> <?php echo sanitize_string($result['imie']); ?></td>
                <td> <?php echo sanitize_string($result['nazwisko']); ?></td>
                <td> <?php echo sanitize_string($result['login']); ?></td>
                <td><select name="uprawnienia" form="form_<?php echo sanitize_string($result['id']); ?>">
                    <option value="0" <?php if($uprawnienia == 0){ echo 'selected'; } ?>>0</option>
                    <option value="1" <?php if($uprawnienia == 1){ echo 'selected'; } ?>>1</option>
                    <option value="2" <?php if($uprawnienia == 2){ echo 'selected'; } ?>>2</option>
                    <option value="3" <?php if($uprawnienia == 3){ echo 'selected'; } ?>>3</option>
                    <option value="4" <?php if($uprawnienia == 4){ echo 'selected'; } ?>>4</option>
                </select>
                </td>
                <td><input name="wyslij" type="submit" value="Potwierdź zmiany" /></td>
            </tr>
        </form>
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
        echo '<a href="index.php?site=12&page='.$prev.'"><-</a>';
    } else {
        echo '<-';
    }

    for($i=0; $i<$max; $i++)
    {
        $tmp = $i + 1;
        echo '<a href="index.php?site=12&page='.$tmp.'">'.$tmp.'</a>';
        if(($i!=$max)-1)
            echo" |";

    }

    if($next<=$max){
        echo '<a href="index.php?site=12&page='.$next.'">-></a>';
    } else {
        echo '->';
    }

    ?>
</div>