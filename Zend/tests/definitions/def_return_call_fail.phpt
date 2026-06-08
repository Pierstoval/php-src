--TEST--
declare(def=1): a top-level return may not call a function
--FILE--
<?php declare(def=1);

return strlen("nope");
--EXPECTF--
Fatal error: Function calls are not allowed in definitions file global scope in %s on line %d
