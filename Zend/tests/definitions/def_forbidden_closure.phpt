--TEST--
declare(def=1): closures are forbidden in the file global scope
--FILE--
<?php declare(def=1);

function () {
    return 1;
};
?>
--EXPECTF--
Fatal error: Closures are not allowed in definitions file global scope in %s on line %d
