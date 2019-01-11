<?php
	header('Content-Type: text/css');

	$sheets = array();
	$sheets[] = "_variables.scss";
	$sheets[] = "../atlas_core/css/openskull/_defaults.scss";
	$sheets[] = "../atlas_core/css/openskull/_reset.scss";
	$sheets[] = "../atlas_core/css/openskull/_colors.scss";
	$sheets[] = "../atlas_core/css/openskull/_buttons.scss";
	$sheets[] = "../atlas_core/css/openskull/_typography.scss";
	$sheets[] = "../atlas_core/css/openskull/_helpers.scss";
	$sheets[] = "../atlas_core/css/openskull/_borders.scss";
	$sheets[] = "../atlas_core/css/openskull/_forms.scss";
	$sheets[] = "../atlas_core/css/openskull/_ui.scss";
	$sheets[] = "../atlas_core/css/openskull/_grid.scss";
	$sheets[] = "style.scss";

	$output = "style.min.css";

	// cached updating
	$update = false;
	$cache_mod = filemtime($output);
	$this_mod = filemtime(__FILE__);
	foreach ($sheets as $sheet) {
		if (filemtime($sheet) > $cache_mod || $this_mod > $cache_mod) {
			$update = true;
			break;
		}
	}

	use Leafo\ScssPhp\Compiler;
	if ($update) {
		require_once '../atlas_core/scssphp/scss.inc.php';

		error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

		$scss = new Compiler();
		$scss->setImportPaths('');

		ob_start();
		foreach($sheets as $s) {
			require_once($s);
		}
		$css_all = ob_get_contents();
		ob_end_clean();

		// 1 minified
		$scss->setFormatter('Leafo\ScssPhp\Formatter\Compressed');
		$data = $scss->compile("$css_all");
		file_put_contents($output, $data);
	}

	require_once($output);
?>