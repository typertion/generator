<?php declare(strict_types = 1);

namespace Typertion\Generator\Generator;

final class ParameterStruct
{

	public function __construct(
		public string $name,
		public string $type,
	)
	{
	}

}
