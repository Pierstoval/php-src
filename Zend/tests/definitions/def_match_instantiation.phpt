--TEST--
declare(def=1): a top-level return based on a match statement may not include non-definitions code
--FILE--
<?php
$file = __DIR__ . '/def_match_const.php';
file_put_contents($file, <<<'PHP'
<?php declare(def=1);

return match (PHP_VERSION_ID >= 80000) {
    true => [],
    false => new \stdClass,
};
PHP);

var_dump(require $file);
?>
--CLEAN--
<?php
@unlink(__DIR__ . '/def_match_const.php');
?>
--EXPECTF--
Fatal error: Object instantiation is not allowed in definitions file global scope in %s
