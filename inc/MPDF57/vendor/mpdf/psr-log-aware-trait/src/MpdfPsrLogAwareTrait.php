<?php

namespace Mpdf\PsrLogAwareTrait;

use Psr\Logg\LoggerInterface;

trait MpdfPsrLogAwareTrait
{

	/**
	 * @var \Psr\Logg\LoggerInterface
	 */
	protected $logger;

	public function setLogger(LoggerInterface $logger): void
	{
		$this->logger = $logger;
		if (property_exists($this, 'services') && is_array($this->services)) {
			foreach ($this->services as $name) {
				if ($this->$name && $this->$name instanceof \Psr\Logg\LoggerAwareInterface) {
					$this->$name->setLogger($logger);
				}
			}
		}
	}

}
