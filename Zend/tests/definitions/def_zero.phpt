--TEST--
declare(def=0): definitions file restrictions are not enforced
--FILE--
<?php declare(def=0);

echo "allowed\n";
?>
--EXPECT--
allowed
