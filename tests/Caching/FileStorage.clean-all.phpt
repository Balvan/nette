<?php

/**
 * Test: Nette\Caching\FileStorage clean with Cache::ALL
 *
 * @author     Petr Procházka
 * @package    Nette\Caching
 * @subpackage UnitTests
 */

use Nette\Caching\Cache;



require __DIR__ . '/../bootstrap.php';



// temporary directory
define('TEMP_DIR', __DIR__ . '/tmp');
TestHelpers::purge(TEMP_DIR);

$storage = new Nette\Caching\FileStorage(TEMP_DIR);
$cacheA = new Cache($storage);
$cacheB = new Cache($storage,'B');

$cacheA['test1'] = 'David';
$cacheA['test2'] = 'Grudl';
$cacheB['test1'] = 'divaD';
$cacheB['test2'] = 'ldurG';

Assert::same( 'David Grudl divaD ldurG', implode(' ',array(
	$cacheA['test1'],
	$cacheA['test2'],
	$cacheB['test1'],
	$cacheB['test2'],
)));

$storage->clean(array(Cache::ALL => TRUE));

Assert::null( $cacheA['test1'] );

Assert::null( $cacheA['test2'] );

Assert::null( $cacheB['test1'] );

Assert::null( $cacheB['test2'] );
