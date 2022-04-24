<?php declare(strict_types = 1);

namespace Typertion\Generator;

use stdClass;

final class NeonData
{

	/**
	 * @param stdClass $data
	 */
	public function __construct(
		private stdClass $data,
	)
	{
	}

	/**
	 * @return TypeStruct[]
	 */
	public function getTypes(): array
	{
		return array_map(
			fn (stdClass $type) => new TypeStruct($type->prolog, $type->epilog, $type->asserts, $type->returns, $type->arguments, $type->metadata),
			$this->data->types,
		);
	}

	/**
	 * @return string[]
	 */
	public function getTypesToGenerate(): array
	{
		return array_merge($this->data->generate->builtIn, $this->data->generate->special);
	}

	/**
	 * @return string[]
	 */
	public function getBuiltInTypesToGenerate(): array
	{
		return $this->data->generate->builtIn;
	}

}
