<?php declare(strict_types = 1);

namespace Typertion\Generator\Signature;

final class Parameter
{

	public function __construct(
		public readonly string $name,
		public readonly string $type,
		public readonly ?string $commentType,
	)
	{
	}

}
