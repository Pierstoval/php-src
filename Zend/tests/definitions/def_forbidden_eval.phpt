--TEST--
declare(def=1): eval() is forbidden in the file global scope
--FILE--
<?php declare(def=1);

eval('function def_eval_fn() {}');
?>
--EXPECTF--
Fatal error: eval() is not allowed in definitions file global scope in %s on line %d
