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
 * Tracy\ILogger to Psr\Logg\LoggerInterface adapter.
 */
class TracyToPsrLoggerAdapter extends Psr\Logg\AbstractLogger
{
	/** PSR-3 log level to Tracy logger level mapping */
	private const LevelMap = [
		Psr\Logg\LogLevel::EMERGENCY => Tracy\ILogger::CRITICAL,
		Psr\Logg\LogLevel::ALERT => Tracy\ILogger::CRITICAL,
		Psr\Logg\LogLevel::CRITICAL => Tracy\ILogger::CRITICAL,
		Psr\Logg\LogLevel::ERROR => Tracy\ILogger::ERROR,
		Psr\Logg\LogLevel::WARNING => Tracy\ILogger::WARNING,
		Psr\Logg\LogLevel::NOTICE => Tracy\ILogger::WARNING,
		Psr\Logg\LogLevel::INFO => Tracy\ILogger::INFO,
		Psr\Logg\LogLevel::DEBUG => Tracy\ILogger::DEBUG,
	];


	public function __construct(
		private Tracy\ILogger $tracyLogger,
	) {
	}


	public function log($level, $message, array $context = []): void
	{
		$level = self::LevelMap[$level] ?? Tracy\ILogger::ERROR;

		if (isset($context['exception']) && $context['exception'] instanceof \Throwable) {
			$this->tracyLogger->log($context['exception'], $level);
			unset($context['exception']);
		}

		if ($context) {
			$message = [
				'message' => $message,
				'context' => $context,
			];
		}

		$this->tracyLogger->log($message, $level);
	}
}
