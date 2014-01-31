<?php
include_once("inc/common.php");

$is_permitted = check_permission(2);

if(!$is_permitted) {
    die('Permission denited');
}

$error = false;
$error_string = "";

$elements = array('imie' => 'Imię', 'nazwisko' => 'Nazwisko', 'nazw_panienskie' => 'Nazwisko panieńskie',
    'email' => 'Email', 'kod_pocztowy' => 'Kod pocztowy');

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
    $error = check_if_exists($elements);
//    var_dump($_POST);

    if(!preg_match('/^[a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\.\-_]+\.[a-z]{2,4}$/D', $_POST['email'])) {
        $error_string = $error_string . 'Email jest nieprawidłowy!<br>';
        $error = true;
        $_POST['email'] = "";
    }
    if(!preg_match('/^[0-9]{2}+\-[0-9]{3}$/D', $_POST["kod_pocztowy"])) {
        $error_string = $error_string . 'Kod pocztowy jest nieprawidłowy!<br>';
        $error = true;
        $_POST['kod_pocztowy'] = "";
    }
} else {
    $error = true;
}

$idpracownika= (int) $_GET['id'];

$SQL = "SELECT * FROM formularz WHERE id='".$idpracownika."' LIMIT 1;";
$rows = mysql_query($SQL);
if (!$rows) {
    die('Invalid query: ' . mysql_error());
}

$row = mysql_fetch_assoc($rows);
//var_dump($row);
if (!$row) {
    header('Location: index.php?site=5');
}

if($error){
    ?>
    <form action="" method="post">
        <input name="id" id="id" type="hidden" value="<?php if(isset($_POST['id'])){ echo sanitize_string($_POST['id']);}
        else { echo $row['id']; } ?>">
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
                    <input id="nazwisko" type="text" name="nazwisko" value="<?php if(isset($_POST['nazwisko'])){ echo sanitize_string($_POST['nazwisko']); }
                    else { echo $row['nazwisko']; } ?>" />
                </td>
            </tr>
            <tr>
                <td><label for="plec">Płeć:</label></td>
                <td>
                    <input id="plec" type="radio" name="plec" value="0" <?php if(isset($_POST['plec'])) { if(!$_POST['plec']) echo 'checked'; }
                                                                              elseif (!$row['plec']) { echo 'checked'; } ?>>
                    Mężczyzna
                    </input>
                    <input id="plec" type="radio" name="plec" value="1" <?php if(isset($_POST['plec'])) { if($_POST['plec']) echo 'checked'; }
                                                                              elseif ($row['plec']) { echo 'checked'; } ?>>
                    Kobieta
                    </input>
                </td>
            </tr>
            <tr>
                <td><label for="nazw_panienskie">Nazwisko panieńskie:</label></td>
                <td>
                    <input id="nazw_panienskie" type="text" name="nazw_panienskie" value="<?php if(isset($_POST['nazw_panienskie'])){ echo sanitize_string($_POST['nazw_panienskie']); }
                    else { echo $row['nazw_panienskie']; }?>"/>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td>
                    <input id="email" type="text" name="email" value="<?php if(isset($_POST['email'])){ echo sanitize_string($_POST['email']); }
                    else { echo $row['email']; }?>"/>
                </td>
            </tr>
            <tr>
                <td><label for="kod_pocztowy">Kod pocztowy:</label></td>
                <td>
                    <input id="kod_pocztowy" type="text" name="kod_pocztowy" value="<?php if(isset($_POST['kod_pocztowy'])){ echo sanitize_string($_POST['kod_pocztowy']); }
                    else { echo $row['kod_pocztowy']; }?>"/>
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
//    var_dump($_POST);
    $form_array = array('imie' => sanitize_string($_POST['imie']), 'nazwisko' => sanitize_string($_POST['nazwisko']),
        'plec' => sanitize_string($_POST['plec']), 'nazw_panienskie' => sanitize_string($_POST['nazw_panienskie']),
        'email' => sanitize_string($_POST['email']), 'kod_pocztowy' => sanitize_string($_POST['kod_pocztowy']),
        'id' => sanitize_string($_POST['id']));

    if ($form_array["plec"]) {
        $plec = 1;
    } else {
        $plec = 0;
    }

    $sql = "UPDATE formularz SET imie='".$form_array["imie"]."', nazwisko='".$form_array["nazwisko"]."',
    plec='".$plec."', nazw_panienskie='".$form_array['nazw_panienskie']."', email='".$form_array["email"]."',
    kod_pocztowy='".$form_array["kod_pocztowy"]."' WHERE ID='".$form_array['id']."';";
    //echo $sql;
    $result = mysql_query($sql);
    if (!$result || $result != 1) {
        die('Invalid query: ' . mysql_error());
    }
//    array_push($_SESSION['users'], $form_array);
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