--TEST--
declare(def=1): the declaration must be the first statement in the script
--FILE--
<?php
const DEF_BEFORE = 1;
declare(def=1);
--EXPECTF--
Fatal error: def declaration must be the very first statement in the script in %s on line %d
