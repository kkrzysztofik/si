<?php
include_once("inc/common.php");

$error = false;
$error_string = "";

$elements = array('imie' => 'Imię', 'nazwisko' => 'Nazwisko', 'login' => 'Login',
    'haslo' => 'Hasło', 'powt_haslo' => 'Powtórne hasło'
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
    }
    if(strlen($form_array['haslo']) < 6) {
        $error_string = $error_string . 'Hasło jest za krótkie, wymagane min. 6 znaków<br>';
        $error = true;
    }

    //check if login is unique
    $SQL = "SELECT * FROM user WHERE login='".$form_array['login']."';";

    $wynik1 = mysql_query($SQL);
    if (!$wynik1) {
        die('Invalid query: ' . mysql_error());
    }
    $num1 = mysql_num_rows($wynik1);

    if($num1) {
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
                    <input id="imie" type="text" name="imie" value="<?php if(isset($_POST['imie'])){ echo sanitize_string($_POST['imie']);} ?>"/>
                </td>
            </tr>
            <tr>
                <td><label for="nazwisko">Nazwisko:</label></td>
                <td>
                    <input id="nazwisko" type="text" name="nazwisko" value="<?php if(isset($_POST['nazwisko'])){ echo sanitize_string($_POST['nazwisko']);} ?>"/>
                </td>
            </tr>
            <tr>
                <td><label for="login">Login:</label></td>
                <td>
                    <input id="login" type="text" name="login" value="<?php if(isset($_POST['login'])){ echo sanitize_string($_POST['login']);} ?>" />
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
                    <input name="wyslij" type="submit" value="Zarejestruj" />
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

    $sql = "INSERT INTO user (imie, nazwisko, haslo, login) VALUES ('".$form_array["imie"]."', '".$form_array["nazwisko"]."','"
        .md5($form_array['haslo'])."', '".$form_array["login"]."');";
    //echo $sql;
    $result = mysql_query($sql);
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }
    echo 'Zarejestrowano użytkownika '.$form_array['imie'].' '.$form_array['nazwisko'];
}