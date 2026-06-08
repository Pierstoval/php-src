--TEST--
declare(def=1): a closing tag '?>' is forbidden
--FILE--
<?php declare(def=1);

const DEF_X = 1;
?>
--EXPECTF--
Fatal error: Closing tag "?>" is not allowed in definitions files in %s on line %d
