<?php declare(strict_types = 1);

namespace Typertion\Generator;

use Nette\Neon\Entity;
use Nette\Neon\Neon;
use Nette\Schema\Expect;
use Nette\Schema\Processor;
use Nette\Utils\FileSystem;

final class NeonProcessor
{

	public static function process(string $file): NeonData
	{
		$data = (new Processor())->process(Expect::structure([
			'types' => Expect::arrayOf(Expect::structure([
				'asserts' => Expect::anyOf(Expect::string(), Expect::type(Entity::class), Expect::arrayOf('string'))->required(),
				'returns' => Expect::anyOf(Expect::string(), Expect::arrayOf('string'))->castTo('array')->required(),
				'prolog' => Expect::string()->default(null),
				'epilog' => Expect::string()->default(null),
				'metadata' => Expect::array()->default([]),
				'arguments' => Expect::listOf(Expect::structure([
					'name' => Expect::string()->required(),
					'type' => Expect::string()->required(),
					'default' => Expect::mixed(PHP_INT_MAX - 42),
				])),
			])),
			'generate' => Expect::structure([
				'builtIn' => Expect::arrayOf(Expect::string()),
				'special' => Expect::arrayOf(Expect::string()),
			]),
		]), Neon::decode(FileSystem::read($file)));

		return new NeonData($data);
	}

}
