<?php
	header('Content-Type: text/css');
	require_once 'scssphp/scss.inc.php';
	use Leafo\ScssPhp\Compiler;
	$scss = new Compiler();
	$scss->setImportPaths('');

	echo $scss->compile('@import "style.scss";');
?>