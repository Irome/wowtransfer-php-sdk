<?php

if (version_compare(PHP_VERSION, '5.6.0', '<=')) {
    throw new Exception('The wowtransfer SDK requires PHP version 5.6 or higher.');
}
if (!extension_loaded('curl')) {
	throw new Exception('The wowtransfer SDK requires curl extension.');
}

spl_autoload_register(function($class) {
	$prefix = 'Wowtransfer\\';
	$baseDir = __DIR__;

	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
	$relativeClass = substr($class, $len);

	$filePath = rtrim($baseDir, '/') . '/' . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($filePath)) {
        require $filePath;
    }
});
