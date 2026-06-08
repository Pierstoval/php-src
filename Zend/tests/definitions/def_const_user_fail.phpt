--TEST--
declare(def=1): a const may not reference a user-defined constant
--FILE--
<?php
define('USER_DEFINED_CONST', 123);

$file = __DIR__ . '/def_const_user_fail.php';
file_put_contents($file, <<<'PHP'
<?php declare(def=1);

const DEF_DERIVED = USER_DEFINED_CONST;
PHP);

require $file;

echo "not reached\n";
--CLEAN--
<?php
@unlink(__DIR__ . '/def_const_user_fail.php');
?>
--EXPECTF--
Fatal error: User-defined constant "USER_DEFINED_CONST" is not allowed in definitions file global scope in %s on line %d
