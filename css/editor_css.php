<?php
	header('Content-Type: text/css');

	$out_file = "dist/edtitor.min.css";

	$sheets = array();
	$sheets[] = "_variables.scss";
	$sheets[] = "editor_css.scss";

	require_once("_style_compile.php");
?>