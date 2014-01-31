<?php
include_once("inc/common.php");

$is_permitted = check_permission(1);

if(!$is_permitted) {
    die('Permission denited');
}

$error = false;
$error_string = "";

$elements = array('imie' => 'Imię', 'nazwisko' => 'Nazwisko', 'login' => 'Login',
//    'haslo' => 'Hasło', 'powt_haslo' => 'Powtórne hasło'
);

function check_if_exists($elements_array) {
    global $error_string;
    $error = false;

    foreach($elements_array as $key => $value){
        if(empty($_POST[$key]) or !isset($_POST[$key])){
            $error_string = $error_string . $value . ' nie jest podany <br>';
            $error = true;
        }
    }

    return $error;
}

$SQL = "SELECT * FROM user WHERE id='".$_SESSION['user_id']."' LIMIT 1;";
$rows = mysql_query($SQL);
if (!$rows) {
    die('Invalid query: ' . mysql_error());
}

$row = mysql_fetch_assoc($rows);
//var_dump($row);
if (!$row) {
    header('Location: index.php');
}

if(isset($_POST['wyslij'])) {
    $form_array = array('imie' => sanitize_string($_POST['imie']), 'nazwisko' => sanitize_string($_POST['nazwisko']),
        'haslo' => sanitize_string($_POST['haslo']), 'login' => sanitize_string($_POST['login']),
        'powt_haslo' => sanitize_string($_POST['powt_haslo'])
    );

    $error = check_if_exists($elements);

    if($form_array['haslo'] != $form_array['powt_haslo']) {
        $error_string = $error_string . 'Podane hasła się nie zgadzają <br>';
        $error = true;
    }
    if(strlen($form_array['login']) < 6) {
        $error_string = $error_string . 'Login jest za krótki, wymagane min. 6 znaków<br>';
        $error = true;
        $_POST['login'] = "";
    }
    if(strlen($form_array['haslo']) > 0 and strlen($form_array['haslo']) < 6) {
        $error_string = $error_string . 'Hasło jest za krótkie, wymagane min. 6 znaków<br>';
        $error = true;
        $_POST['haslo'] = "";
        $_POST['powt_haslo'] = "";
    }

    //check if login is unique
    $SQL = "SELECT * FROM user WHERE login='".$form_array['login']."';";

    $wynik1 = mysql_query($SQL);
    if (!$wynik1) {
        die('Invalid query: ' . mysql_error());
    }
    $num1 = mysql_num_rows($wynik1);
    $result = mysql_fetch_assoc($wynik1);

    if($num1 and $_SESSION['user_id'] != $result['id']) {
        $error_string = $error_string . 'Login zajęty<br>';
        $error = true;
    }

} else {
    $error = true;
}

if($error){
    ?>
    <form action="" method="post">
        <table>
            <tr>
                <td><label for="imie">Imię:</label></td>
                <td>
                    <input id="imie" type="text" name="imie" value="<?php if(isset($_POST['imie'])){ echo sanitize_string($_POST['imie']);}
                    else { echo $row['imie']; } ?>"/>
                </td>
            </tr>
            <tr>
                <td><label for="nazwisko">Nazwisko:</label></td>
                <td>
                    <input id="nazwisko" type="text" name="nazwisko" value="<?php if(isset($_POST['nazwisko'])){ echo sanitize_string($_POST['nazwisko']);}
                    else { echo $row['nazwisko']; }?>"/>
                </td>
            </tr>
            <tr>
                <td><label for="login">Login:</label></td>
                <td>
                    <input id="login" type="text" name="login" value="<?php if(isset($_POST['login'])){ echo sanitize_string($_POST['login']);}
                    else { echo $row['login']; } ?>" />
                </td>
            </tr>
            <tr>
                <td><label for="haslo">Hasło:</label></td>
                <td>
                    <input id="haslo" type="password" name="haslo" value="<?php if(isset($_POST['haslo'])){ echo sanitize_string($_POST['haslo']);} ?>" />
                </td>
            </tr>
            <tr>
                <td><label for="powt_haslo">Powtórz hasło:</label></td>
                <td>
                    <input id="powt_haslo" type="password" name="powt_haslo" value="<?php if(isset($_POST['powt_haslo'])){ echo sanitize_string($_POST['powt_haslo']);} ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input name="wyslij" type="submit" value="Potwierdź zmiany" />
                    <button type="button"><a href="index.php?site=5">Odrzuć zmiany</a></button>
                </td>
            </tr>
        </table>
    </form>
    <?php
    echo $error_string;
}
else {
    $form_array = array('imie' => sanitize_string($_POST['imie']), 'nazwisko' => sanitize_string($_POST['nazwisko']),
        'haslo' => sanitize_string($_POST['haslo']), 'login' => sanitize_string($_POST['login'])
    );

    $sql = "UPDATE user SET imie='".$form_array["imie"]."', nazwisko='".$form_array["nazwisko"]."',";
    if(sizeof($form_array['haslo'])){
        $sql = $sql . "haslo='".md5($form_array['haslo'])."',";
    }
    $sql = $sql . "login='".$form_array["login"]."' WHERE id=".$_SESSION['user_id'].";";
    //echo $sql;
    $result = mysql_query($sql);
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }
    echo 'Zaktualizowano użytkownika '.$form_array['imie'].' '.$form_array['nazwisko'];
}