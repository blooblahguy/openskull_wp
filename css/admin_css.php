<?php
	$out_file = "dist/admin.min.css";

	$sheets = array();
	$sheets[] = "_variables.scss";
	$sheets[] = "admin_css.scss";

	require_once("_style_compile.php");
?>