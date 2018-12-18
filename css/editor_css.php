<?php
	header('Content-Type: text/css');

	$sheets = array();
	$sheets[] = "_variables.scss";
	$sheets[] = "editor_css.scss";

	$out = "edtitor.min.css";

	// cached updating
	$update = false;
	$cache_mod = filemtime($out);
	$this_mod = filemtime(__FILE__);
	foreach ($sheets as $sheet) {
		if (filemtime($sheet) > $cache_mod || $this_mod > $cache_mod) {
			$update = true;
			break;
		}
	}

	use Leafo\ScssPhp\Compiler;
	if ($update) {
		require_once 'scssphp/scss.inc.php';

		error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

		$scss = new Compiler();
		$scss->setSourceMap(Compiler::SOURCE_MAP_INLINE);
		$scss->setImportPaths('');

		// 1 minified
		$scss->setFormatter('Leafo\ScssPhp\Formatter\Compressed');
		$data = $scss->compile("@import \"".ltrim(implode("\";\n@import \"",$sheets),"\";\n")."\";");
		file_put_contents($out, $data);
	}

	include($out);
?>