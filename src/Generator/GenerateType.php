<?php declare(strict_types = 1);

namespace Typertion\Generator\Generator;

use Typertion\Generator\Signature\Parameter;

final class GenerateType
{

	/**
	 * @param string[] $types
	 * @param string[] $returnTypesComment
	 * @param string[] $expectedTypes
	 * @param string[] $validators
	 * @param string[] $comments
	 * @param Parameter[] $parameters
	 */
	public function __construct(
		public readonly string $name,
		public readonly array $types,
		public readonly array $returnTypesComment,
		public readonly array $expectedTypes,
		public readonly array $validators,
		public readonly array $comments,
		public readonly array $parameters,
	)
	{
	}

	public function getValidationCondition(): string
	{
		return implode(' || ', $this->validators);
	}

	public function hasValidationCondition(): bool
	{
		return (bool) $this->validators;
	}

	public function typesToString(): string
	{
		return implode('|', $this->types);
	}

	public function hasReturnTypeComment(): bool
	{
		return $this->typesToString() !== $this->returnTypesCommentToString();
	}

	public function returnTypesCommentToString(): string
	{
		return implode('|', $this->returnTypesComment);
	}

	public function expectedTypesCommentToString(): string
	{
		return implode('|', $this->expectedTypes);
	}

}
