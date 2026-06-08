--TEST--
declare(def=1): echo is forbidden in the file global scope
--FILE--
<?php declare(def=1);

echo "nope";
?>
--EXPECTF--
Fatal error: echo is not allowed in definitions file global scope in %s on line %d
