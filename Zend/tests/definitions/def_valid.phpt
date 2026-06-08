--TEST--
declare(def=1): valid definitions files compile and run
--FILE--
<?php

file_put_contents(__DIR__ . '/def_include_target.php', <<<'PHP'
<?php
// Included file
function def_included_fn(): string {
    return 'included';
}
PHP);

file_put_contents(__DIR__ . '/def_all.php', <<<'PHP'
<?php declare(def=1);

namespace DefNamespace
{
    use function strlen;

    const DEF_CONST_IN_NS = 7;

    function def_ns_fn(): int {
        return DEF_CONST_IN_NS;
    }

    function def_use_fn(): int {
        return strlen('ok');
    }
}

namespace
{
	const DEF_ANSWER = 42;
	const DEF_VERSION = PHP_VERSION_ID;
	const DEF_DIR = __DIR__;

	class DefClassBody {
		public function run(): int {
			echo "class body\n";
			$obj = new stdClass();
			return strlen('xyz');
		}
	}

	interface DefinitionInterface {
		public function value(): int;
	}

	trait DefinitionTrait {
		public function fromTrait(): int {
			return 5;
		}
	}

	class DefinitionImplementation implements DefinitionInterface {
		use DefinitionTrait;

		public function value(): int {
			return $this->fromTrait();
		}
	}

	enum DefinitionEnum: string {
		case Alpha = 'alpha';
		case Beta = 'beta';
	}

	function def_basic_fn(): int {
		return DEF_ANSWER;
	}

	class DefBasic {
		public function value(): int {
			return def_basic_fn();
		}
	}

	function def_enum_fn(): string {
		return DefinitionEnum::Alpha->value;
	}

	if (PHP_VERSION_ID >= 80000) {
		function def_conditional_fn(): string {
			return 'new';
		}
	} else {
		function def_conditional_fn(): string {
			return 'old';
		}
	}

	switch (PHP_VERSION_ID >= 80000) {
		case true:
			class DefSwitchClass {
				public function label(): string {
					return 'new';
				}
			}
			break;
		default:
			class DefSwitchClass {
				public function label(): string {
					return 'old';
				}
			}
	}

	const DEF_CUSTOM_CONSTANT_OK = 'ok';

	switch (true) {
		case true:
			break 1;
		default:
			break;
	}

	require __DIR__ . '/def_include_target.php';

	function def_include_wrapper(): string {
		return def_included_fn();
	}
}
PHP);

require __DIR__ . '/def_all.php';

echo DEF_ANSWER, "\n";
echo def_basic_fn(), "\n";
echo (new DefBasic())->value(), "\n";
var_dump(DEF_VERSION === PHP_VERSION_ID);
var_dump(DEF_DIR === __DIR__);
echo (new DefClassBody())->run(), "\n";
echo (new DefinitionImplementation())->value(), "\n";
echo def_enum_fn(), "\n";
echo def_conditional_fn(), "\n";
echo (new DefSwitchClass())->label(), "\n";
echo DEF_CUSTOM_CONSTANT_OK, "\n";
echo def_include_wrapper(), "\n";
echo def_included_fn(), "\n";
echo \DefNamespace\DEF_CONST_IN_NS, "\n";
echo \DefNamespace\def_ns_fn(), "\n";
echo \DefNamespace\def_use_fn(), "\n";
?>
--CLEAN--
<?php
@unlink(__DIR__ . '/def_all.php');
@unlink(__DIR__ . '/def_include_target.php');
?>
--EXPECT--
42
42
42
bool(true)
bool(true)
class body
3
5
alpha
new
new
ok
included
included
7
7
2
