<?php declare(strict_types = 1);

namespace Typertion\Generator\Manifest;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;

final class JsonManifest
{

	private string $json;

	/**
	 * @param string[] $types
	 */
	public function __construct(array $types)
	{
		$this->json = Json::encode(array_map(
			fn (string $type) => [
				'name' => $type,
				'types' => explode('|', $type),
				'method' => lcfirst(implode('Or', array_map(ucfirst(...), explode('|', $type)))),
			],
			$types,
		), Json::PRETTY);
	}

	/**
	 * @return array{name: string, types: string[], method: string}[]
	 */
	public static function load(string $file): array
	{
		return Json::decode(FileSystem::read($file), Json::FORCE_ARRAY);
	}

	public function save(string $file): void
	{
		FileSystem::createDir(dirname($file));
		FileSystem::write($file, $this->toString());
	}

	public function toString(): string
	{
		return $this->json;
	}

}
