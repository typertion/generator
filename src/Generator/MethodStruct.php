<?php declare(strict_types = 1);

namespace Typertion\Generator\Generator;

final class MethodStruct
{

	/** @var ParameterStruct[] */
	public array $parameters = [];

	/** @var string[] */
	public array $body = [];

	/** @var string[] */
	public array $comment = [];

	public string $returnType;

	public function __construct(
		public string $name,
	)
	{
	}

	public function addParameter(string $name, string $type): void
	{
		$this->parameters[$name] = new ParameterStruct($name, $type);
	}

	public function setReturnType(string $returnType): static
	{
		$this->returnType = $returnType;

		return $this;
	}

	public function addBody(string $body): void
	{
		$this->body[] = $body;
	}

	public function formatParameters(): string
	{
		if (!$this->parameters) {
			return '';
		}

		return implode(', ', array_keys($this->parameters));
	}

	/**
	 * @return string[]
	 */
	public function getBody(): array
	{
		return $this->body;
	}

	public function formatBody(int $spaces = 2): string
	{
		if (!$this->body) {
			return '';
		}

		$space = str_repeat("\t", $spaces);

		return implode("\n", array_map(fn (string $line) => $space . $line, $this->body));
	}

	public function addComment(string $comment): void
	{
		$this->comment[] = $comment;
	}

	public function formatComment(string $separator, ?string $startsWith, ?string $endsWith, int $spaces = 1): string
	{
		if (!$this->comment) {
			return '';
		}

		$space = str_repeat("\t", $spaces);

		$comment = '';
		if ($startsWith) {
			$comment .= "$space$startsWith\n";
		}

		$comment .= implode("\n", array_map(fn (string $line) => $space . $separator . $line, $this->comment));

		if ($endsWith) {
			$comment .= "\n$space$endsWith\n";
		}

		return $comment;
	}

}
