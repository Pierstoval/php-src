--TEST--
declare(def=1): try/catch is forbidden in the file global scope
--FILE--
<?php declare(def=1);

try {
    function def_try_fn() {}
} catch (Throwable $e) {
}
?>
--EXPECTF--
Fatal error: try/catch/finally is not allowed in definitions file global scope in %s on line %d
