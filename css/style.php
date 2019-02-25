<?php
	header('Content-Type: text/css');

	$out_file = "dist/style.min.css";

	$sheets = array();
	$sheets[] = "../atlas_core/css/_functions.scss";
	$sheets[] = "_variables.scss";
	$sheets[] = "../atlas_core/css/_reset.scss";
	$sheets[] = "../atlas_core/css/_colors.scss";
	$sheets[] = "../atlas_core/css/_buttons.scss";
	$sheets[] = "../atlas_core/css/_typography.scss";
	$sheets[] = "../atlas_core/css/_helpers.scss";
	$sheets[] = "../atlas_core/css/_forms.scss";
	$sheets[] = "../atlas_core/css/_ui.scss";
	$sheets[] = "../atlas_core/css/_grid.scss";
	$sheets[] = "style.scss";

	require_once("_style_compile.php");
?>