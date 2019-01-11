<?


	$atlas_blocks = array();
	// $atlas_blocks['row'] = "row.php";
	// $atlas_blocks['tabs'] = "tabs.php";
	// $atlas_blocks['crop'] = "crop.php";
	// $atlas_blocks['accordions'] = "accordions.php";

	add_action('acf/init', 'atlas_acf_blocks_init');
	function atlas_acf_blocks_init() {
		if(!  function_exists('acf_register_block') ) { return; }

		foreach ($blocks as $class => $file) {
			include($file);
			$atlas_blocks[$class] = new $class();
			$block = $atlas_blocks[$class];

			// register block
			acf_register_block($block->block);
		}
	}
?>