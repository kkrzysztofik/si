<?php
include_once("inc/common.php");

$error = false;
$error_string = "";

$elements = array('imie' => 'Imię', 'nazwisko' => 'Nazwisko', 'plec' => 'Płeć', 'nazw_panienskie' => 'Nazwisko panieńskie',
                  'email' => 'Email', 'kod_pocztowy' => 'Kod pocztowy');

function check_if_exists($elements_array) {
    global $error_string;
    $error = false;

    foreach($elements_array as $key => $value){
        if(empty($_POST[$key])){
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
                    <input id="imie" type="text" name="imie" value="<?php echo sanitize_string($_POST['imie']) ?>"/>
                </td>
            </tr>
            <tr>
                <td><label for="nazwisko">Nazwisko:</label></td>
                <td>
                    <input id="nazwisko" type="text" name="nazwisko" value="<?php echo sanitize_string($_POST['nazwisko']) ?>" />
                </td>
            </tr>
            <tr>
                <td><label for="plec">Płeć:</label></td>
                <td>
                    <input id="plec" type="radio" name="plec" value="0" <?php if(!$_POST['plec']) { echo 'checked'; } ?>>Mężczyzna</input>
                    <input id="plec" type="radio" name="plec" value="1" <?php if($_POST['plec']) { echo 'checked'; } ?>>Kobieta</input>
                </td>
            </tr>
            <tr>
                <td><label for="nazw_panienskie">Nazwisko panieńskie:</label></td>
                <td>
                    <input id="nazw_panienskie" type="text" name="nazw_panienskie" value="<?php echo sanitize_string($_POST['nazw_panienskie']) ?>"/>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td>
                    <input id="email" type="text" name="email" value="<?php echo sanitize_string($_POST['email']) ?>"/>
                </td>
            </tr>
            <tr>
                <td><label for="kod_pocztowy">Kod pocztowy:</label></td>
                <td>
                    <input id="kod_pocztowy" type="text" name="kod_pocztowy" value="<?php echo sanitize_string($_POST['kod_pocztowy']) ?>"/>
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
    ?>
    <table>
        <tr>
            <td>Imię:</td>
            <td><?php echo sanitize_string($_POST['imie']) ?></td>
        </tr>
        <tr>
            <td><label for="nazwisko">Nazwisko:</label></td>
            <td><?php echo sanitize_string($_POST['nazwisko']) ?></td>
        </tr>
        <tr>
            <td><label for="plec">Płeć:</label></td>
            <td>
                <?php
                    if($_POST['plec']) {
                        echo 'Mężczyzna';
                    } else {
                        echo 'Kobieta';
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>Nazwisko panieńskie:</td>
            <td><?php echo sanitize_string($_POST['nazw_panienskie']) ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo sanitize_string($_POST['email']) ?></td>
        </tr>
        <tr>
            <td>Kod pocztowy:</td>
            <td><?php echo sanitize_string($_POST['kod_pocztowy']) ?></td>
        </tr>
    </table>
<?php
}