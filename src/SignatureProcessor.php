<?php declare(strict_types = 1);

namespace Typertion\Generator;

use Exception;
use Typertion\Generator\Generator\GenerateType;
use Typertion\Generator\Signature\Signature;
use Typertion\Generator\Signature\Type;

final class SignatureProcessor
{

	public function __construct(
		private Signature $signature,
	)
	{
	}

	public function process(string ... $arguments)
	{
		$processed = [];

		foreach ($arguments as $argument) {
			$types = array_map(
				fn (string $type) => $this->signature->getType($type),
				explode('|', $argument),
			);

			// validate
			foreach ($types as $type) {
				$replaces = $type->getConflict();

				if (!$replaces) {
					continue;
				}

				foreach ($types as $compare) {
					if ($type === $compare) {
						continue;
					}

					if (in_array($compare->name, $replaces, true)) {
						throw new Exception(sprintf('Collision with types %s and %s.', $type->name, $compare->name));
					}
				}
			}



			$processed[] = new GenerateType(
				lcfirst(implode('Or', array_map(fn (Type $type) => ucfirst($type->name), $types))),
				$this->mergeUniqueArray(...array_map(fn (Type $type) => $type->getReturnType(), $types)),
				$this->mergeUniqueArray(...array_map(fn (Type $type) => $type->getReturnTypeComments(), $types)),
				$this->mergeUniqueArray(...array_map(fn (Type $type) => $type->getExpectedType(), $types)),
				array_values(array_unique($this->sortValidators(array_merge(...array_map(fn (Type $type) => $type->getValidators(), $types))))),
				$this->mergeUniqueArray(...array_map(fn (Type $type) => $type->getComments(), $types)),
				$this->mergeUniqueArray(...array_map(fn (Type $type) => $type->getParameters(), $types)),
			);
		}

		return $processed;
	}

	/**
	 * @template T
	 * @param T[] ...$array
	 * @return T[]
	 */
	private function mergeUniqueArray(array ... $array): array
	{
		return array_values(array_unique(array_merge(...$array)));
	}

	/**
	 * @param array{string, int}[] $validators
	 * @return string[]
	 */
	private function sortValidators(array $validators): array
	{
		usort($validators, fn (array $a, array $b) => $a[1] <=> $b[1]);

		return array_column($validators, 0);
	}

}
