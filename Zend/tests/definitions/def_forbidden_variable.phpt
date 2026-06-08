--TEST--
declare(def=1): variables are forbidden in the file global scope
--FILE--
<?php declare(def=1);

$x = 1;
?>
--EXPECTF--
Fatal error: Assignments are not allowed in definitions file global scope in %s on line %d
