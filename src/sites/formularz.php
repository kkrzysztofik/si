<?php

$form = '<form action="" method="post">
    <table>
        <tr>
            <td><label for="imie">Imię:</label></td>
            <td>
                <input id="imie" type="text" name="imie" />
            </td>
        </tr>
        <tr>
            <td><label for="nazwisko">Nazwisko:</label></td>
            <td>
                <input id="nazwisko" type="text" name="nazwisko" />
            </td>
        </tr>
        <tr>
            <td><label for="plec">Płeć:</label></td>
            <td>
                <input id="plec" type="radio" name="plec" value="1">Mężczyzna</input>
                <input id="plec" type="radio" name="plec" value="0">Kobieta</input>
            </td>
        </tr>
        <tr>
            <td><label for="nazw_panienskie">Nazwisko panieńskie:</label></td>
            <td>
                <input id="nazw_panienskie" type="text" name="nazw_panienskie" />
            </td>
        </tr>
        <tr>
            <td><label for="email">Email:</label></td>
            <td>
                <input id="email" type="text" name="email" />
            </td>
        </tr>
        <tr>
            <td><label for="kod_pocztowy">Kod pocztowy:</label></td>
            <td>
                <input id="kod_pocztowy" type="text" name="kod_pocztowy" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Wyślij" />
            </td>
        </tr>
    </table>
</form>';
$error = false;

$elements = array('imie', 'nazwisko', 'plec', 'nazw_panienskie', 'email', 'kod_pocztowy');

function check_if_exists($elements_array) {
    foreach($elements_array as $element){
        if(!isset($_POST[$element]) or !sizeof($_POST[$element])){
            echo($element . ' nie jest podany');
            $error = true;
        }
    }
}

if(sizeof($_POST)) {
    var_dump($_POST);

} else {
    echo $form;
}