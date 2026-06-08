--TEST--
declare(def=1): top-level return are allowed
--FILE--
<?php
$dir = __DIR__;

file_put_contents($dir . '/def_return_bare.php', <<<'PHP'
<?php declare(def=1);

return;
PHP);

file_put_contents($dir . '/def_return_literal.php', <<<'PHP'
<?php declare(def=1);

return 1 + 2;
PHP);

file_put_contents($dir . '/def_return_match.php', <<<'PHP'
<?php declare(def=1);

return match (PHP_VERSION_ID >= 80000) {
    true => 1,
    false => 0,
};
PHP);

var_dump(require $dir . '/def_return_bare.php');
var_dump(require $dir . '/def_return_literal.php');
var_dump(require $dir . '/def_return_match.php');
?>
--CLEAN--
<?php
@unlink(__DIR__ . '/def_return_bare.php');
@unlink(__DIR__ . '/def_return_literal.php');
@unlink(__DIR__ . '/def_return_match.php');
?>
--EXPECT--
NULL
int(3)
int(1)
