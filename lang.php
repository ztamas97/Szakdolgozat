<?php
/* en.php - english language file */
$messages['hello'] = 'Hello';
$messages['signup'] = 'Sign up for free';
?>
<?php
/* de.php - german language file */
$messages['hello'] = 'Hallo';
$messages['signup'] = 'Kostenlos registrieren';
?>
<?php
    require('de.php');
    echo($messages['hello']);
    echo($messages['signup']);
?>