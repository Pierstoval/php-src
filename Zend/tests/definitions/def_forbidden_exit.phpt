--TEST--
declare(def=1): exit is forbidden in the file global scope
--FILE--
<?php declare(def=1);

exit(1);
?>
--EXPECTF--
Fatal error: Call statements are not allowed in definitions file global scope in %s on line %d
