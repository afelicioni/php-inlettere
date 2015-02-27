<?php
require 'src/InLettere/Cifra.php';

use \InLettere\Cifra;

$aImportiDaCodificare = array(
	'1',
	'999999900',
	'2199999900',
	'3106806100',
	'174862185100',
	'3104843109800'
);

foreach ($aImportiDaCodificare as $v) {
	printf("traduzione, in cents<br>importo: <code>%s €c</code><br>in lettere: <code>%s €</code><br><br>", $v, Cifra::inLettere($v));
}
?>