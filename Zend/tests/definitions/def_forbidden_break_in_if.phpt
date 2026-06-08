--TEST--
declare(def=1): break is forbidden inside an if statement
--FILE--
<?php declare(def=1);

if (true) {
    break;
}
?>
--EXPECTF--
Fatal error: break is not allowed in definitions file global scope in %s on line %d
