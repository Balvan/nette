<?php

/**
 * Test: Nette\String::split()
 *
 * @author     David Grudl
 * @package    Nette
 * @subpackage UnitTests
 */

use Nette\String;



require __DIR__ . '/../bootstrap.php';



Assert::same( array(
	'a',
	',',
	'b',
	',',
	'c',
), String::split('a, b, c', '#(,)\s*#') );

Assert::same( array(
	'a',
	',',
	'b',
	',',
	'c',
), String::split('a, b, c', '#(,)\s*#', PREG_SPLIT_NO_EMPTY) );
