<?php
	$debug = false;
	if ($_SERVER['SERVER_NAME'] == 'localhost' || strpos($_SERVER['SERVER_NAME'], "devcpc") !== false) { // development
		$debug = true;
	}

	// loops through params and debugs
	function debug(...$params) {
		foreach ($params as $p) {
			echo "<pre>";
			print_r($p);
			echo "</pre>";
		}
	}

	// auto links non-links inside of a string
	function linkify($text) {
		$links = array();

		$text = preg_replace(
		   '/(?<!=\")(?<!\")(?<!\">)((https?|ftp)+(s)?:\/\/[^<>\s]+)/i',
		   '<a href="$1">$1</a>',
		   $text
		);
		
		return $text;
	}

	// does the opposite of sanitize_title
	function desanitize_title($input) {
		return ucwords(str_replace(array("-","_"), array(" "," "), $input));
	}

	// pulls id out of youtube url
	function getYoutubeID($link) {
		$matches = array();
		
		preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu‌​\.be\/|youtube\.com\‌​/(?:(?:watch)?\?(?:.‌​*&)?v(?:i)?=|(?:embe‌​d|v|vi|user)\/))([^\‌​?#&\"'>]+)/", $url, $matches);
		
		return $matches[1];
	}

	// pulls id out of vimeo url
	function getVimeoID($link) {
		return substr(parse_url($link, PHP_URL_PATH), 1);
	}
?>