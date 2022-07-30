<?php declare(strict_types = 1);

namespace Typertion\Generator\Signature;

final class Type
{

	/** @var array{string, int}[] */
	private array $validators = [];

	/** @var string[] */
	private array $returnType = [];

	/** @var string[] */
	private array $conflict = [];

	/** @var Parameter[] */
	private array $parameters = [];

	/** @var string[] */
	private array $comments = [];

	/** @var string[] */
	private array $returnTypeComment = [];

	/** @var string[] */
	private array $expectedType = [];

	public function __construct(
		public readonly string $name,
	)
	{
	}

	/**
	 * @param string|string[] $type
	 */
	public function setReturnType(string|array $type): self
	{
		$this->returnType = (array) $type;

		return $this;
	}

	/**
	 * @param string|string[] $type
	 */
	public function setExpectedType(string|array $type): self
	{
		$this->expectedType = (array) $type;

		return $this;
	}

	public function addValidator(string $expression, int $performance = 1): self
	{
		$this->validators[] = [$expression, $performance];

		return $this;
	}

	public function addParameter(string $name, string $type, ?string $commentType = null): self
	{
		$this->parameters[] = new Parameter($name, $type, $commentType);

		return $this;
	}

	public function addComment(string $comment): self
	{
		$this->comments[] = $comment;

		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getComments(): array
	{
		return $this->comments;
	}

	/**
	 * @return Parameter[]
	 */
	public function getParameters(): array
	{
		return $this->parameters;
	}

	/**
	 * @return string[]
	 */
	public function getReturnType(): array
	{
		return $this->returnType;
	}

	/**
	 * @return string[]
	 */
	public function getExpectedType(): array
	{
		return $this->expectedType ?: $this->returnType;
	}

	/**
	 * @return string[]
	 */
	public function getReturnTypeComments(): array
	{
		return $this->returnTypeComment ?: $this->returnType;
	}

	/**
	 * @return array{string, int}[]
	 */
	public function getValidators(): array
	{
		return $this->validators;
	}

	/**
	 * @param string|string[] $type
	 */
	public function conflict(string|array $type): self
	{
		$this->conflict = (array) $type;

		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getConflict(): array
	{
		return $this->conflict;
	}

	/**
	 * @param string|string[] $comment
	 */
	public function setReturnTypeComment(string|array $comment): self
	{
		$this->returnTypeComment = (array) $comment;

		return $this;
	}

}
