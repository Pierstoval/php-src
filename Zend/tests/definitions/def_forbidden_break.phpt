--TEST--
declare(def=1): break is forbidden outside of a switch statement
--FILE--
<?php declare(def=1);

break;
?>
--EXPECTF--
Fatal error: break is not allowed in definitions file global scope in %s on line %d
