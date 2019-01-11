<?
	// ini_set("display_errors", 1);
	// error_reporting(E_ALL);
	define( 'SMTP_HOST', 'mi3-sr9.supercp.com' );  // A2 Hosting server name. For example, "server.a2hosting.com"
	define( 'SMTP_AUTH', true );
	define( 'SMTP_PORT', '465' );
	define( 'SMTP_SECURE', 'ssl' );
	define( 'SMTP_USERNAME', 'user@example.com' );  // Username for SMTP authentication
	define( 'SMTP_PASSWORD', 'password' );          // Password for SMTP authentication
	define( 'SMTP_FROM',     'user@example.com' );  // SMTP From address
	define( 'SMTP_FROMNAME', 'Name Here' );         // SMTP From name

	// alert developer if we still need to define these values, otherwise integrate into wordpress
	$needs_configuration = false;
	// if (SMTP_USERNAME == "user@example.com") {
	// 	$needs_configuration = true;
	// }
	// define( 'SMTP_NEEDS_CONFIG', $needs_configuration );

	// if (SMTP_NEEDS_CONFIG == false) {
	// 	add_action( 'phpmailer_init', 'send_smtp_email' );
	// 	function send_smtp_email( $phpmailer ) {
	// 		$phpmailer->isSMTP();
	// 		$phpmailer->Host       = SMTP_HOST;
	// 		$phpmailer->SMTPAuth   = SMTP_AUTH;
	// 		$phpmailer->Port       = SMTP_PORT;
	// 		$phpmailer->SMTPSecure = SMTP_SECURE;
	// 		$phpmailer->Username   = SMTP_USERNAME;
	// 		$phpmailer->Password   = SMTP_PASSWORD;
	// 		$phpmailer->From       = SMTP_FROM;
	// 		$phpmailer->FromName   = SMTP_FROMNAME;
	// 	}
	// } else {
	// 	function smtp_configuration_needed_notice() { ?>
	// 		<div class="notice notice-warning is-dismissible">
	// 			<p><?php echo '<strong>Developer Notice:</strong> SMTP still needs to be configured for this website, without it emails may be marked as spam.'; ?></p>
	// 		</div>
	// 	<?php }
	// 	add_action( 'admin_notices', 'smtp_configuration_needed_notice' );
	// }
?>