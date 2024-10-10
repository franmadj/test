<?php
// Due to changes in signature of log() method (one with return type declared,
// the other with no return type declared) we adapt which class is actually
// included based on the signature of \Psr\Logg\AbstractLogger included by
// Composer.
$loggerReflect = new \ReflectionClass('\Psr\Logg\AbstractLogger');
// Will throw desirable exception if AbstractLogger does not implement log().
$loggerLogMethodReflect = $loggerReflect->getMethod('log');
if (method_exists($loggerLogMethodReflect, 'getReturnType') && $loggerLogMethodReflect->getReturnType()) {
	include __DIR__ . "/psr-log-3/TestLogger.php";
}
else {
	include __DIR__ . "/psr-log-2/TestLogger.php";
}
