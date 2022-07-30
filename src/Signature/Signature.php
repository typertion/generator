<?php declare(strict_types = 1);

namespace Typertion\Generator\Signature;

use OutOfBoundsException;

final class Signature
{

	/** @var Type[] */
	private array $types;

	public function addType(string $name): Type
	{
		return $this->types[$name] = new Type($name);
	}

	public function getType(string $name): Type
	{
		return $this->types[$name] ?? throw new OutOfBoundsException("Type $name does not exist.");
	}

	/**
	 * @return Type[]
	 */
	public function getTypes(): array
	{
		return $this->types;
	}

}
