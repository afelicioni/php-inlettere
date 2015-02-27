<?php
/**
 * This file is part of php-inlettere
 *
 * Copyright (c) 2012-2015 Alessio Felicioni
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace InLettere;

interface Exception {
}

class InvalidArgumentException extends \Exception implements Exception {
}

class Cifra {
	private static $_cross = array(
		'unita'		=> array(
				1	=>	'uno',
						'due',
						'tre',
						'quattro',
						'cinque',
						'sei',
						'sette',
						'otto',
						'nove'
			),
		'decunita'	=> array(
				10	=>	'dieci',
						'undici',
						'dodici',
						'tredici',
						'quattordici',
						'quindici',
						'sedici',
						'diciassette',
						'diciotto',
						'diciannove'
			),
		'decine'	=> array(
				2	=>	'venti',
						'trenta',
						'quaranta',
						'cinquanta',
						'sessanta',
						'settanta',
						'ottanta',
						'novanta'
			),
		'suffissi'	=> array(
				0	=>	'',
				3	=>	'mila',
				6	=>	'milioni',
				9	=>	'miliardi'
			)
		);

	public static function inLettere($nUnita = '0', $sSeparatore = '/') {
		if ( !(is_string($nUnita) && ctype_digit($nUnita)) ) {
			throw new InvalidArgumentException('Richiesto un parametro numerico per unità, nella forma più elementare. Esempio: per 1,23 EUR utilizzare 123 classificando le unità in centesimi');
		}
		$_cents = str_pad(substr($nUnita, -2), 2, '0', STR_PAD_LEFT);
		$_unita_inesame = '0';
		$_letterale = 'zero';
		if (strlen($nUnita)>2) {
			$_unita_inesame = substr($nUnita, 0, -2);
			$_letterale = '';
			$_esponente = 0;
			$_migliaio_inesame = substr($_unita_inesame, -3);
			do {
				$_letterale = static::_rendicarino(static::_sottomille($_migliaio_inesame) . static::$_cross['suffissi'][$_esponente]) . $_letterale;
				$_unita_inesame = substr($_unita_inesame, 0, -3);
				$_esponente +=3;
				$_migliaio_inesame = substr($_unita_inesame, -3);
			} while ($_migliaio_inesame != '');
		}
		return $_letterale . $sSeparatore . $_cents;
	}
	private static function _sottomille($_n) {
		$_r = '';
		$_nC = (int)($_n/100);
		$_nDU = ($_n%100);
		$_nD = (int)($_nDU/10);
		$_nU = ($_n%10);
		$_rC = '';
		if ($_nC>1) {
			$_rC = static::$_cross['unita'][$_nC].'cento';
		} else if ($_nC==1) {
			$_rC = 'cento';
		}
		$_rDU = '';
		if ($_nDU>=1&&$_nDU<10) {
			$_rDU = static::$_cross['unita'][$_nU];
		} else if ($_nDU>=10&&$_nDU<20) {
			$_rDU = static::$_cross['decunita'][$_nDU];
		} else if ($_nDU>20) {
			$_rDU = static::$_cross['decine'][$_nD] . static::$_cross['unita'][$_nU];
		}
		$_r = $_rC . $_rDU;
		return $_r;
	}
	private static function _rendicarino($_brutto) {
		$_trova_regex = array('`([ae])nt([ai])(uno|otto)`', '`^unomila`', '`^unomilioni`', '`^unomiliardi`');
		$_sostituiscicon = array('\1nt\3', 'mille', 'unmilione', 'unmiliardo');
		$_brutto = preg_replace($_trova_regex, $_sostituiscicon, $_brutto);
		$_brutto = str_replace('unomili', 'unmili', $_brutto);
		return $_brutto;
	}
}
?>