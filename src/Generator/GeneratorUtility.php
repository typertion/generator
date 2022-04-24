<?php declare(strict_types = 1);

namespace Typertion\Generator\Generator;

final class GeneratorUtility
{

	public static function returnTypeToComment(MethodStruct $struct, string $format): void
	{
		if (!$struct->returnType) {
			return;
		}

		$struct->addComment(strtr($format, [
			'%type' => $struct->returnType,
		]));
	}

	public static function parametersToComment(MethodStruct $struct, string $format): void
	{
		foreach ($struct->parameters as $parameter) {
			$struct->addComment(strtr($format, [
				'%type' => $parameter->type,
				'%name' => $parameter->name,
			]));
		}
	}

}
