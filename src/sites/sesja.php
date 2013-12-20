<?php

if (count($_SESSION['users'])) {
    foreach ($_SESSION['users'] as $form_array) {
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
                    if (!$form_array['plec']) {
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
        <hr>
    <?php
    }
} else {
    echo 'Nie dodano żadnego użytkownika';
}