<?php
echo("Wynik wyszukiwania");
echo("<br/>");
echo("dla: ");
$bd = @mysql_connect('phpmyadmin6.lh.pl', 'mzwiech', 'informatyka');

if (!$bd) {
    exit('<p>Nie można skontaktować się ' .
        'w tej chwili z baza danych.</p>');
}

if (!mysql_select_db('mzwiech_mczenczak')) {
    exit('<p>Nie można zlokalizować ' .
        'w tej chwili bazy danych.</p>');
}

$tmp =$_SESSION['zapytanie'];
echo($tmp);

$zapytanieSQL="SELECT * FROM osoba WHERE nazwisko LIKE '%$tmp%' ORDER BY id ASC";
$wynik = mysql_query ($zapytanieSQL);
$num=mysql_numrows($wynik);
mysql_close ($bd);
?>
<table border="4">
    <tr>
        <td align="left"> id </td>
        <td> Imie</td>
        <td> Nazwisko</td>
        <td> Plec</td>
        <td> Naz. Pan.</td>
        <td> Email</td>
        <td> Kod pocztowy</td>
    </tr>
    <?php
    $i=0;
    while ($i < $num) {
        $id=mysql_result($wynik,$i,"id");
        $imie=mysql_result($wynik,$i,"imie");
        $nazwisko=mysql_result($wynik,$i,"nazwisko");
        $plec=mysql_result($wynik,$i,"plec");
        $nazwisko_p=mysql_result($wynik,$i,"nazwisko_p");
        $email=mysql_result($wynik,$i,"email");
        $kod=mysql_result($wynik,$i,"kod");
        ?>
        <tr>
            <td align="left"> <?php echo $id; ?> </td>
            <td> <?php echo $imie; ?></td>
            <td> <?php echo $nazwisko; ?></td>
            <td> <?php echo $plec; ?></td>
            <td> <?php echo $nazwisko_p; ?></td>
            <td> <?php echo $email; ?></td>
            <td> <?php echo $kod; ?></td>
        </tr>
        <?php
        $i++;
    }
    ?>
</table>
