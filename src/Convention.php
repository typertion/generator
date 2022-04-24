<?php declare(strict_types = 1);

namespace Typertion\Generator;

use LogicException;
use Nette\Utils\Type;

final class Convention
{

	public static function expandType(Type $type): string
	{
		$types = [];
		foreach ($type->getTypes() as $type) {
			$types[] = $type->getSingleName();
		}

		return implode('|', $types);
	}

	public static function getMethodName(Type|string $types): string
	{
		if (is_string($types)) {
			$types = explode('|', $types);
		} else {
			$types = $types->getNames();
		}

		$methodName = '';
		foreach ($types as $name) {
			$methodName .= ucfirst($name) . 'Or';
		}

		return lcfirst(substr($methodName, 0, -2));
	}

	/**
	 * @param TypeStruct[] $types
	 */
	public static function getReturnType(array $types, Type $type, bool $shortcut = true): string
	{
		$returnType = '';
		foreach ($type->getTypes() as $type) {
			$struct = $types[$type->getSingleName()] ?? throw new LogicException(
					sprintf('Return type for type "%s" does not exist.', $type->getSingleName())
				);

			foreach ($struct->returns as $item) {
				$returnType .= $item . '|';
			}
		}

		$returnType = substr($returnType, 0, -1);

		return $shortcut ? (string) Type::fromString($returnType) : $returnType;
	}

}
