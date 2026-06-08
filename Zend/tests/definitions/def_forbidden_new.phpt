--TEST--
declare(def=1): object instantiation is forbidden in the file global scope
--FILE--
<?php declare(def=1);

new stdClass();
?>
--EXPECTF--
Fatal error: Object instantiation is not allowed in definitions file global scope in %s on line %d
