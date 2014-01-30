<?php
require_once('inc/config.php');

session_start();
if(!isset($_SESSION['users'])) {
    $_SESSION['users'] = array();
}

$bd = mysql_connect($db_host, $db_user, $db_password);
if (!$bd) {
    exit('<p>Nie można połączyć się ' .
        'w tej chwili z bazą danych.</p>');
}

if (!mysql_select_db($db)) {
    exit('<p>Nie można wybrać ' .
        'w tej chwili bazy danych.</p>');
}
?>

<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>test</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="container">
		<div id="header">HEAD</div>
		<div id="content">
			<div id="left">
                <ul>
                    <li>
                        <a href="index.php?site=0">Strona główna</a>
                    </li>
                    <li>
                        <a href="index.php?site=1">Formularz</a>
                    </li>
                    <li>
                        <a href="index.php?site=2">Zawartość sesji</a>
                    </li>
                    <li>
                        <a href="index.php?site=3">Baza pracowników</a>
                    </li>
                    <li>
                        <a href="index.php?site=5">Edycja</a>
                    </li>
                    <li>
                        <a href="index.php?site=6">Usuwanie</a>
                    </li>
                </ul>
			</div>
            <div id="right">
                <form action="index.php?site=4" method="post">
                    <input type="text" maxlength="30" name="zapytanie"/>
                    <input type="submit" value="szukaj" name="szukaj"/>
                </form>
            </div>
			<div id="center">
                <?php
                    if(!isset($_GET['site'])) {
                        $site = 0;
                    } else {
                        $site = (int)$_GET['site'];
                    }
                    switch ($site) {
                        case 0:
                            include_once('sites/glowna.php');
                            break;
                        case 1:
                            include_once('sites/formularz.php');
                            break;
                        case 2:
                            include_once('sites/sesja.php');
                            break;
                        case 3:
                            include_once('sites/baza.php');
                            break;
                        case 4:
                            include_once('sites/szukaj.php');
                            break;
                        case 5:
                            include_once('sites/edycja.php');
                            break;
                        case 6:
                            include_once('sites/usuwanie.php');
                            break;
                        case 7:
                            include_once('sites/formularz_edycja.php');
                            break;
                        case 8:
                            include_once('sites/formularz_usun.php');
                            break;
                    }
                ?>
			</div>
		</div>
		<div id="footer"><?php
            echo "W tej sesji dodano " . count($_SESSION['users']) . " użytkowników";
            ?>&nbsp;</div>
	</div>
</body>
</html>
<?php
    mysql_close($bd);
?>