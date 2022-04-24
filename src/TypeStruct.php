<?php declare(strict_types = 1);

namespace Typertion\Generator;

use Nette\Neon\Entity;
use Nette\Utils\Type;

final class TypeStruct
{

	public static string $variable;

	/** @var callable(string): string */
	private static $validatorSubs = [];

	/** @var array<array-key, string|Entity> */
	private array $asserts;

	/**
	 * @param string[] $asserts
	 * @param string[] $returns
	 * @param mixed[] $arguments
	 * @param mixed[] $metadata
	 */
	public function __construct(
		public ?string $prolog,
		public ?string $epilog,
		array|string|Entity $asserts,
		public array $returns,
		public array $arguments,
		public array $metadata,
	)
	{
		if ($asserts instanceof Entity) {
			$this->asserts = [$asserts];
		} else {
			$this->asserts = (array) $asserts;
		}
	}

	public static function combine(TypeStruct ... $structs): self
	{
		$prolog = '';
		$epilog = '';
		$asserts = [];
		$returns = [];
		$arguments = [];
		$metadata = [];
		foreach ($structs as $struct) {
			$prolog .= $struct->prolog;
			if ($prolog) {
				$prolog .= "\n";
			}

			$epilog .= $struct->epilog;
			if ($epilog) {
				$epilog .= "\n";
			}

			$asserts = array_merge($asserts, $struct->asserts);
			$returns = array_merge($returns, $struct->returns);
			$arguments = array_merge($arguments, $struct->arguments);
			$metadata = array_merge_recursive($metadata, $struct->metadata);
		}

		$prolog = trim($prolog);
		$epilog = trim($epilog);

		return new self($prolog ?: null, $epilog ?: null, array_unique($asserts, SORT_REGULAR), array_unique($returns), $arguments, $metadata);
	}

	public function getAssertion(Type $type): string
	{
		$asserts = [];
		foreach ($this->asserts as $assert) {
			if ($assert instanceof Entity) {
				foreach ((array) call_user_func($assert->attributes, $type) as $asrt) {
					$asserts[] = $this->convertAssertToString($asrt);
				}

				continue;
			}

			$asserts[] = $this->convertAssertToString($assert);
		}

		return implode(' && ', $asserts);
	}

	private function convertAssertToString(string $assert): string
	{
		return $assert;
	}

	public static function addValidatorSub(string $method, string $sub): void
	{
		self::$validatorSubs[$method] = $sub;
	}

}
