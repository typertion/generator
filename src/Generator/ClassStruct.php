<?php declare(strict_types = 1);

namespace Typertion\Generator\Generator;

final class ClassStruct
{

	/** @var MethodStruct[] */
	public array $methods;

	public array $metadata = [];

	public function __construct(
		public string $name,
	)
	{
	}

	public function addMethod(string $name): MethodStruct
	{
		return $this->methods[$name] = new MethodStruct($name);
	}

}
