<?
$block_name = "atlas_rows";
$block_title = "Row";
$description = "Wrap content in rows with column layouts";
$category = "formatting";
$keywords = array($block_name, $block_title);
$icon = 'admin-comments';



// RENDER CALLBACK
$fn_name = $block_name."_callback";
$fn_name = function($block, $content = '', $is_preview = false ) { 
	
	?>
		<div class="block_outer <?= $block_name; ?>">
			<div class="container">
			</div>
		</div>
	<?
};



// BLOCK REGISTRAION
acf_register_block(array(
	'name' => $block_name,
	'title' => $block_title,
	'description' => $description,
	'render_callback' => $block_name."_callback",
	'category' => $category,
	'icon' => $icon,
	'keywords' => $keywords,
));

// FIELDS REGISTRAION



?>