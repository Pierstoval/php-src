--TEST--
declare(def=1): break with a level greater than 1 is forbidden in a switch
--FILE--
<?php declare(def=1);

switch (true) {
    case true:
        break 2;
}
?>
--EXPECTF--
Fatal error: break with a level greater than 1 is not allowed in definitions file global scope in %s on line %d
