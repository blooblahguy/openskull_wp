<?php
	header('Content-Type: text/css');

	$out_file = "style.min.css";

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

	require_once("_style_compile.php");
?>