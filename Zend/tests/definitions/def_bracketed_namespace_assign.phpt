--TEST--
declare(def=1): namespace blocks may not contain non-definitions code
--FILE--
<?php
$file = __DIR__ . '/def_bracketed_namespace_valid.php';
file_put_contents($file, <<<'PHP'
<?php declare(def=1);

namespace DefBracketed {
    $variable = 1;
}
PHP);

require $file;

?>
--CLEAN--
<?php
@unlink(__DIR__ . '/def_bracketed_namespace_valid.php');
?>
--EXPECTF--
Fatal error: Assignments are not allowed in definitions file global scope in %s
