<?php declare(strict_types = 1);

namespace Typertion\Generator\Generator;

final class FileStruct
{

	/** @var ClassStruct[] */
	public array $classes = [];

	/** @var string[] */
	private array $prolog = [];

	/** @var string[] */
	private array $epilog = [];

	/** @var mixed[] */
	public array $metadata;

	public function __construct()
	{
	}

	public function addProlog(string $prolog): void
	{
		$this->prolog[] = $prolog;
	}

	public function addEpilog(string $epilog): void
	{
		$this->epilog[] = $epilog;
	}

	public function addClass(string $name): ClassStruct
	{
		return $this->classes[$name] = new ClassStruct($name);
	}

	public function render($templateFile): string
	{
		ob_start();

		$file = $this;
		require $templateFile;

		return ob_get_clean();
	}

	public function formatEpilog(): string
	{
		if (!$this->epilog) {
			return '';
		}

		return "\n" . implode("\n", $this->epilog);
	}

	public function formatProlog()
	{
		if (!$this->prolog) {
			return '';
		}

		return implode('', array_map(fn (string $line) => $line . "\n", $this->prolog));
	}

}
