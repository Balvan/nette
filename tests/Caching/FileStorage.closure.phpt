<?php

/**
 * Test: Nette\Caching\FileStorage & Nette\Callback & Closure.
 *
 * @author     David Grudl
 * @package    Nette\Caching
 * @subpackage UnitTests
 * @phpversion 5.3
 */

use Nette\Caching\Cache,
	Nette\Environment;



require __DIR__ . '/../bootstrap.php';



// key and data with special chars
$key = '../' . implode('', range("\x00", "\x1F"));
$value = range("\x00", "\xFF");

// temporary directory
define('TEMP_DIR', __DIR__ . '/tmp');
TestHelpers::purge(TEMP_DIR);



$cache = new Cache(new Nette\Caching\FileStorage(TEMP_DIR));

Assert::false( isset($cache[$key]), 'Is cached?' );


// Writing cache using Closure...
$res = $cache->save($key, function() use ($value) {
	return $value;
});
$cache->release();

Assert::true( $res === $value, 'Is result ok?' );

Assert::true( $cache[$key] === $value, 'Is cache ok?' );


// Removing from cache using unset()...
unset($cache[$key]);
$cache->release();

// Writing cache using Nette\Callback...
$res = $cache->save($key, callback(function() use ($value) {
	return $value;
}));
$cache->release();

Assert::true( $res === $value, 'Is result ok?' );

Assert::true( $cache[$key] === $value, 'Is cache ok?' );


// Removing from cache using NULL callback...
$cache->save($key, function() {
	return NULL;
});
$cache->release();

Assert::false( isset($cache[$key]), 'Is cached?' );
