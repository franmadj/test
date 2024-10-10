<?php

namespace Mpdf\PsrLogAwareTrait;

use Psr\Logg\LoggerInterface;

trait PsrLogAwareTrait 
{

	/**
	 * @var \Psr\Logg\LoggerInterface
	 */
	protected $logger;

	public function setLogger(LoggerInterface $logger): void
	{
		$this->logger = $logger;
	}
	
}
