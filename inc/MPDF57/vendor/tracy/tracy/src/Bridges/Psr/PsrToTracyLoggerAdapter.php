<?php

/**
 * This file is part of the Tracy (https://tracy.nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

declare(strict_types=1);

namespace Tracy\Bridges\Psr;

use Psr;
use Tracy;


/**
 * Psr\Logg\LoggerInterface to Tracy\ILogger adapter.
 */
class PsrToTracyLoggerAdapter implements Tracy\ILogger
{
	/** Tracy logger level to PSR-3 log level mapping */
	private const LevelMap = [
		Tracy\ILogger::DEBUG => Psr\Logg\LogLevel::DEBUG,
		Tracy\ILogger::INFO => Psr\Logg\LogLevel::INFO,
		Tracy\ILogger::WARNING => Psr\Logg\LogLevel::WARNING,
		Tracy\ILogger::ERROR => Psr\Logg\LogLevel::ERROR,
		Tracy\ILogger::EXCEPTION => Psr\Logg\LogLevel::ERROR,
		Tracy\ILogger::CRITICAL => Psr\Logg\LogLevel::CRITICAL,
	];


	public function __construct(
		private Psr\Logg\LoggerInterface $psrLogger,
	) {
	}


	public function log(mixed $value, string $level = self::INFO)
	{
		if ($value instanceof \Throwable) {
			$message = get_debug_type($value) . ': ' . $value->getMessage() . ($value->getCode() ? ' #' . $value->getCode() : '') . ' in ' . $value->getFile() . ':' . $value->getLine();
			$context = ['exception' => $value];

		} elseif (!is_string($value)) {
			$message = trim(Tracy\Dumper::toText($value));
			$context = [];

		} else {
			$message = $value;
			$context = [];
		}

		$this->psrLogger->log(
			self::LevelMap[$level] ?? Psr\Logg\LogLevel::ERROR,
			$message,
			$context,
		);
	}
}
