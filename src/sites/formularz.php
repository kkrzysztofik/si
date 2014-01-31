<?php
include_once("inc/common.php");

$is_permitted = check_permission(1);

if(!$is_permitted) {
    die('Permission denited');
}

$error = false;
$error_string = "";

$elements = array('imie' => 'Imię', 'nazwisko' => 'Nazwisko', 'plec' => 'Płeć', 'nazw_panienskie' => 'Nazwisko panieńskie',
                  'email' => 'Email', 'kod_pocztowy' => 'Kod pocztowy');

function check_if_exists($elements_array) {
    global $error_string;
    $error = false;

    foreach($elements_array as $key => $value){
        if(empty($_POST[$key]) && !isset($_POST[$key])){
            $error_string = $error_string . $value . ' nie jest podany <br>';
            $error = true;
        }
    }

    return $error;
}

if(isset($_POST['wyslij'])) {
    $error = check_if_exists($elements);
    if(!preg_match('/^[a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\.\-_]+\.[a-z]{2,4}$/D', $_POST['email'])) {
        $error_string = $error_string . 'Email jest nieprawidłowy!<br>';
        $error = true;
    }
    if(!preg_match('/^[0-9]{2}+\-[0-9]{3}$/D', $_POST["kod_pocztowy"])) {
        $error_string = $error_string . 'Kod pocztowy jest nieprawidłowy!<br>';
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
                    <input id="nazwisko" type="text" name="nazwisko" value="<?php if(isset($_POST['nazwisko'])){ echo sanitize_string($_POST['nazwisko']); } ?>" />
                </td>
            </tr>
            <tr>
                <td><label for="plec">Płeć:</label></td>
                <td>
                    <input id="plec" type="radio" name="plec" value="0" <?php if(isset($_POST['plec']) && !$_POST['plec']) { echo 'checked'; } ?>>
                        Mężczyzna
                    </input>
                    <input id="plec" type="radio" name="plec" value="1" <?php if(isset($_POST['plec']) && $_POST['plec']) { echo 'checked'; } ?>>
                        Kobieta
                    </input>
                </td>
            </tr>
            <tr>
                <td><label for="nazw_panienskie">Nazwisko panieńskie:</label></td>
                <td>
                    <input id="nazw_panienskie" type="text" name="nazw_panienskie" value="<?php if(isset($_POST['nazw_panienskie'])){ echo sanitize_string($_POST['nazw_panienskie']); } ?>"/>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td>
                    <input id="email" type="text" name="email" value="<?php if(isset($_POST['email'])){ echo sanitize_string($_POST['email']); } ?>"/>
                </td>
            </tr>
            <tr>
                <td><label for="kod_pocztowy">Kod pocztowy:</label></td>
                <td>
                    <input id="kod_pocztowy" type="text" name="kod_pocztowy" value="<?php if(isset($_POST['kod_pocztowy'])){ echo sanitize_string($_POST['kod_pocztowy']); } ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input name="wyslij" type="submit" value="Wyślij" />
                </td>
            </tr>
        </table>
    </form>
<?php
    echo $error_string;
}
else {
    $form_array = array('imie' => sanitize_string($_POST['imie']), 'nazwisko' => sanitize_string($_POST['nazwisko']),
        'plec' => sanitize_string($_POST['plec']), 'nazw_panienskie' => sanitize_string($_POST['nazw_panienskie']),
        'email' => sanitize_string($_POST['email']), 'kod_pocztowy' => sanitize_string($_POST['kod_pocztowy']));

    if ($form_array["plec"]) {
        $plec = 1;
    } else {
        $plec = 0;
    }

    $sql = "INSERT INTO formularz (imie, nazwisko, plec, nazw_panienskie, email, kod_pocztowy) VALUES ('".$form_array["imie"]."', '".$form_array["nazwisko"]."','"
        .$plec."', '".$form_array['nazw_panienskie']."', '".$form_array["email"]."', '".$form_array["kod_pocztowy"]."');";
    //echo $sql;
    $result = mysql_query($sql);
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }
    array_push($_SESSION['users'], $form_array);
    ?>
    <table>
        <tr>
            <td>Imię:</td>
            <td><?php echo $form_array['imie'] ?></td>
        </tr>
        <tr>
            <td><label for="nazwisko">Nazwisko:</label></td>
            <td><?php echo $form_array['nazwisko'] ?></td>
        </tr>
        <tr>
            <td><label for="plec">Płeć:</label></td>
            <td>
                <?php
                    if(!$form_array['plec']) {
                        echo 'Mężczyzna';
                    } else {
                        echo 'Kobieta';
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>Nazwisko panieńskie:</td>
            <td><?php echo $form_array['nazw_panienskie'] ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo $form_array['email'] ?></td>
        </tr>
        <tr>
            <td>Kod pocztowy:</td>
            <td><?php echo $form_array['kod_pocztowy'] ?></td>
        </tr>
    </table>
<?php
}