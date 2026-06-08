--TEST--
declare(def=1): global declarations are forbidden in the file global scope
--FILE--
<?php declare(def=1);

global $x;
?>
--EXPECTF--
Fatal error: global declarations are not allowed in definitions file global scope in %s on line %d
