--TEST--
declare(def=1): function calls are forbidden in the file global scope
--FILE--
<?php declare(def=1);

strlen("nope");
--EXPECTF--
Fatal error: Call statements are not allowed in definitions file global scope in %s on line %d
