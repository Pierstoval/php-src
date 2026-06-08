--TEST--
declare(def=1): an if may not be guarded by a user-defined constant
--FILE--
<?php

const USER_DEFINED_CONST = true;

$file = __DIR__ . '/def_conditional_undefined_constant.php';
file_put_contents($file, <<<'PHP'
<?php declare(def=1);

if (USER_DEFINED_CONST === true) {
    function def_conditional_fn(): string {
        return "defined";
    }
} else {
    function def_conditional_fn(): string {
        return "undefined";
    }
}
PHP);

require $file;

echo def_conditional_fn(), "\n";
?>
--CLEAN--
<?php
@unlink(__DIR__ . '/def_conditional_undefined_constant.php');
?>
--EXPECTF--
Fatal error: User-defined constant "USER_DEFINED_CONST" is not allowed in definitions file global scope in %s on line %d
