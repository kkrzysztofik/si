<?php

include_once('inc/common.php');

if(isset($_POST['zaloguj'])) {
    $login = sanitize_string($_POST['login']);
    $password = sanitize_string($_POST['haslo']);
    $mdpassw = md5($password);

    $SQL = "SELECT * FROM user WHERE login='".$login."' AND haslo='".$mdpassw."';";

    $wynik1 = mysql_query($SQL);
    if (!$wynik1) {
        die('Invalid query: ' . mysql_error());
    }
    $num1 = mysql_num_rows($wynik1);

    if(!$num1) {
        echo 'Błędny login lub hasło.<br>';
    } else {
        $user = mysql_fetch_assoc($wynik1);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['permission'] = $user['uprawnienia'];
        header('Location: index.php');
    }
}
?>

<form action="" method="post">
        <table>
            <tr>
                <td><label for="login">Login:</label></td>
                <td>
                    <input id="login" type="text" name="login" />
                </td>
            </tr>
            <tr>
                <td><label for="haslo">Hasło:</label></td>
                <td>
                    <input id="haslo" type="password" name="haslo" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input name="zaloguj" type="submit" value="Zaloguj" />
                </td>
            </tr>
        </table>
</form>
