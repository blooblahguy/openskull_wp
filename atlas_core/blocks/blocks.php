<?


	$atlas_blocks = array();
	$atlas_blocks['row'] = "rows.php";
	// $atlas_blocks['crop'] = "crop.php";
	// $atlas_blocks['tabs'] = "tabs.php";
	// $atlas_blocks['accordions'] = "accordions.php";

	add_action('acf/init', 'atlas_acf_blocks_init');
	function atlas_acf_blocks_init() {
		global $atlas_blocks;
		// var_dump(function_exists('acf_register_block'));
		if (! function_exists('acf_register_block') ) { return; }

		foreach ($atlas_blocks as $class => $file) {
			include($file);
			$block = $atlas_blocks[$class];
		}
	}
?>