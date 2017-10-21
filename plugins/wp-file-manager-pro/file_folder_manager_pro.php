<?php 
/**
  Plugin Name: WP File Manager - PRO
  Plugin URI: http://www.webdesi9.com/product/file-manager/
  Description: Manage your WP files.
  Author: mndpsingh287
  Version: 2.5
  Author URI: https://profiles.wordpress.org/mndpsingh287
  License: GPLv2
**/
if(!class_exists('mk_file_folder_manager')):	
	class mk_file_folder_manager
	{
		const FILE_MANAGER_VERSION = '2.5';
		/* Auto Load Hooks */
		public function __construct()
		{
			if(!function_exists('wp_get_current_user')) {
               include(ABSPATH . "wp-includes/pluggable.php"); 
             }
			 include('controller/fm_controller.php');
			 $fm_controller = new mk_fm_controller;
			 $folder = basename( dirname( __FILE__ ) );
			 $file   = basename( __FILE__ );
			 add_action( 'init', array(&$this,'check_fm_updates'));
			 add_action('admin_menu', array(&$this, 'ffm_menu_page'));
			 add_action('admin_enqueue_scripts', array(&$this,'ffm_admin_things'));
			 add_action('wp_ajax_mk_file_folder_manager', array(&$this, 'mk_file_folder_manager_action_callback'));
			 add_action('wp_ajax_nopriv_mk_file_folder_manager', array(&$this, 'mk_file_folder_manager_action_callback'));
		     add_action('wp_ajax_mk_file_folder_manager_shortcode', array(&$this, 'mk_file_folder_manager_action_callback_shortcode'));
			 add_action('wp_ajax_nopriv_mk_file_folder_manager_shortcode', array(&$this, 'mk_file_folder_manager_action_callback_shortcode'));
			 add_shortcode('wp_file_manager', array(&$this, 'wp_file_manager_front_view'));
			 add_shortcode('wp_file_manager_admin', array(&$this, 'wp_file_manager_front_view_admin_control'));
			 do_action('load_filemanager_extensions');
			 add_action('plugins_loaded', array(&$this, 'filemanager_pro_load_text_domain'));
		}
		/* File Manager */
		public function filemanager_pro_load_text_domain() {
			$domain = dirname( plugin_basename( __FILE__ ));
			$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
			load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . 'plugins' . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
		}
		/* Menu Page */
		public function ffm_menu_page()
		{
			$permissions = $this->permissions();
			 add_menu_page(
			__( 'WP File Manager', 'wp-file-manager-pro' ),
			__( 'WP File Manager', 'wp-file-manager-pro' ),
			$permissions,
			'wp_file_manager',
			array(&$this, 'ffm_settings_callback'),
			plugins_url( 'images/wp_file_manager.png', __FILE__ )
			);
			/* Only for admin */
			add_submenu_page( 'wp_file_manager', __( 'Settings', 'wp-file-manager-pro' ), __( 'Settings', 'wp-file-manager-pro' ), 'manage_options', 'wp_file_manager_settings', array(&$this, 'wp_file_manager_settings'));
			/* Only for admin */
			add_submenu_page( 'wp_file_manager', __( 'Shortcode', 'wp-file-manager-pro' ), __( 'Shortcode', 'wp-file-manager-pro' ), 'manage_options', 'wp_file_manager_shortcode_doc', array(&$this, 'wp_file_manager_shortcode_doc'));
			/* Only for admin */
			add_submenu_page( 'wp_file_manager', __( 'Extensions', 'wp-file-manager-pro' ), __( 'Extensions', 'wp-file-manager-pro' ), 'manage_options', 'wp_file_manager_extension', array(&$this, 'wp_file_manager_extension'));
		}
		/* Main Role */
		public function ffm_settings_callback()
		{ 
			$this->render('lib','wpfilemanager',true);
		}
		/*Settings */
		public function wp_file_manager_settings()
		{
			$this->render('inc','settings', true);
		}
		/* Shortcode Doc */
		public function wp_file_manager_shortcode_doc()
		{
			$this->render('inc','shortcode_docs', true);
		}
		/* Extesions - Show */
		public function wp_file_manager_extension()
		{
		   $this->render('inc','extensions', true);
		}
		/* Admin  Things */
		public function ffm_admin_things()
		{
			    $opt = get_option('wp_filemanager_options'); 
				$getPage = isset($_GET['page']) ? $_GET['page'] : '';
				$allowedPages = array(
									  'wp_file_manager',
									  'wp_file_manager_settings',
									  );
					if(!empty($getPage) && in_array($getPage, $allowedPages)):
						wp_enqueue_style( 'jquery-ui', plugins_url('css/jquery-ui.css', __FILE__));
						wp_enqueue_style( 'elfinder.min', plugins_url('lib/css/elfinder.min.css', __FILE__)); 
						wp_enqueue_style( 'theme', plugins_url('lib/css/theme.css', __FILE__));
						wp_enqueue_script( 'jquery_min', plugins_url('js/jquery-ui.min.js', __FILE__));	
						wp_enqueue_script( 'elfinder_min', plugins_url('lib/js/elfinder.full.js',  __FILE__ ));	
						wp_enqueue_style( 'wp_file_manager', plugins_url('css/wp_file_manager_pro.css', __FILE__));
						if(isset($opt['lang']) && !empty($opt['lang'])):
						 if($opt['lang'] != 'en') {
						    wp_enqueue_script( 'fm_lang', plugins_url('lib/js/i18n/elfinder.'.$opt['lang'].'.js',  __FILE__ ));	
						 }
						endif;
					endif;				
		}
		/*
		* Ajax request handler
		* Run File Manager
		*/
		public function mk_file_folder_manager_action_callback()
		{
		    require 'lib/php/autoload.php';
			elFinder::$netDrivers['ftp'] = 'FTP';
			$opt = get_option('wp_filemanager_options');
			$current_user = wp_get_current_user();
			$userLogin = $current_user->user_login;
			$userID = $current_user->ID; 
			$user = new WP_User( $userID );
			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
				foreach ( $user->roles as $role ):
					$role;
				endforeach;	
			}
			$accessfolder = '';
			if(!empty($opt['private_folder_access'])):
			$accessfolder = $opt['private_folder_access'];
			endif;
			$folderRestricted = array();
			$fileRestricted = array();
			/* According To Username */
			if(in_array($userLogin, $opt['select_users'])):
					$key = array_search($userLogin, $opt['select_users']);
					/* Seperate Folder access */
					if(!empty($opt['user_seprate_folder'][$key])):
			          $accessfolder = $opt['user_seprate_folder'][$key];
			        endif;
					/* File Operations */
					$file_operations = $opt['users_fileoperations_'.$key];
					/* Folder Restrictions */
					$restrictedFolders = explode('|', $opt['restrict_user_folders'][$key]);
					if(!empty($restrictedFolders[0]) && is_array($restrictedFolders)):
					  foreach($restrictedFolders as $restrictedFolder):
						$folderRestricted[] = array( 'pattern' => '!^/'.$restrictedFolder.'!','hidden' => true );
					  endforeach;
					else:
					   $folderRestricted[] = array('hidden' => 'false'); 	  			
					endif;
					/* File Restrictions */
					$restrictedfiles = explode('|', $opt['restrict_user_files'][$key]);
					if(!empty($restrictedfiles[0]) && is_array($restrictedfiles)):
					  foreach($restrictedfiles as $restrictedFile):
					   $pattern = '/'.$restrictedFile.'$/';
					   $fileRestricted[] = array( 'pattern' => $pattern,'write' => false, 'locked' => true );
					  endforeach;
					else:
					   $fileRestricted[] = array( 'pattern' => '', 'locked' => false );			
					endif;			
			/* According to userroles */	
			elseif(in_array($role, $opt['select_user_roles'])):
				    $key = array_search($role, $opt['select_user_roles']);
					/* Seperate Folder access */
					if(!empty($opt['seprate_folder'][$key])):
			          $accessfolder = $opt['seprate_folder'][$key];
			        endif;
					/* File Operations */
					$file_operations = $opt['userrole_fileoperations_'.$key];				
					/* Folder Restrictions */
					$restrictedFolders = explode('|', $opt['restrict_folders'][$key]);
					if(!empty($restrictedFolders[0]) && is_array($restrictedFolders)):
					  foreach($restrictedFolders as $restrictedFolder):
						$folderRestricted[] = array( 'pattern' => '!^/'.$restrictedFolder.'!','hidden' => true );
					  endforeach;
					else:
						$folderRestricted[] = array('hidden' => 'false');			
					endif;
					/* File Restrictions */
					$restrictedfiles = explode('|', $opt['restrict_files'][$key]);
					if(!empty($restrictedfiles[0]) && is_array($restrictedfiles)):
					  foreach($restrictedfiles as $restrictedFile):
					   $pattern = '/'.$restrictedFile.'$/';
					   $fileRestricted[] = array( 'pattern' => $pattern,'write' => false, 'locked' => true );
					  endforeach;
					else:
					   $fileRestricted[] = array( 'pattern' => '', 'locked' => false );			
					endif;		
			else:	
					$folderRestricted[] = array('hidden' => 'false');
					$fileRestricted[] = array( 'pattern' => '', 'locked' => false );			     	
			endif;
			        $mime_allowed = array('text', 'image', 'application','audio/mpeg');
				    $mime_denied = array('');
			 /* Path View */		
			 $siteUrl = site_url();
			 if(!empty($accessfolder)) {
				$siteUrl .= '/'.$accessfolder;  
			 }
			 $mk_restrictions = array();
			 /* Limit To 100 */
			 for($mu=0; $mu<=100; $mu++) {
				$mk_restrictions[$mu] = $fileRestricted[$mu]; 
				$mk_restrictions[$mu] = $folderRestricted[$mu];
			 }
			/* End According To User */
					$opts = array(
				   'debug' => true,
				   'roots' => array(
					array(
						'driver'        => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
						'path'          => ABSPATH.$accessfolder, // path to files (REQUIRED)
						'URL'           => $siteUrl, // URL to files (REQUIRED)
				     	'uploadDeny'    => $mime_denied, // All Mimetypes not allowed to upload
					    'uploadAllow'   => $mime_allowed, 
						'uploadOrder'   => array('deny', 'allow'), 
						'accessControl' => 'access', // disable and hide dot starting files (OPTIONAL)
						'acceptedName' => 'validName',
						'uploadMaxSize' => !empty($opt['fm_max_upload_size']) ? $opt['fm_max_upload_size'].'M' : '2'.'M', 
						'disabled'      => $file_operations,
				        'attributes' => $mk_restrictions
					)
				)
			);
			$connector = new elFinderConnector(new elFinder($opts));
			$connector->run();
			die;	
		}
		/*
		Access permissions
		*/
		public function permissions()
		{
			$opt = get_option('wp_filemanager_options');
			$allowedroles = isset($opt['fm_user_roles']) ? $opt['fm_user_roles'] : '';
			if(empty($allowedroles)){
				$allowedroles = array();
			}
            $current_user = wp_get_current_user();
			$userLogin = $current_user->user_login;
			$userID = $current_user->ID; 
			$user = new WP_User( $userID );
			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
				foreach ( $user->roles as $role ):
					$role;
				endforeach;	
			}
			$permissions = 'manage_options';
			if($role == 'administrator'):
			 $permissions = 'manage_options';
			elseif(in_array($role, $allowedroles)):
			 $permissions = 'read';
			endif;
			return $permissions;
		}
		/*
		render
		*/
		public function render($folder, $page, $restrictions)
		{
		  if($restrictions) {	
			if(is_admin()):
				$opt = get_option('wp_file_manager_pro');
				if(empty($opt['ispro']) && empty($opt['serialkey'])){
					include('inc/verify.php');
				}
				else{
					include($folder.'/'.$page.'.php');	
				}
			endif;
		  } else {
			  include($folder.'/'.$page.'.php');	  
		  }
		}
		/*
		* Ajax - Shortcode Requests
		*/
		public function mk_file_folder_manager_action_callback_shortcode()
		{
		    require 'lib/php/autoload.php';
		    $current_user = wp_get_current_user();
			$userLogin = $current_user->user_login;
			$userID = $current_user->ID; 
			$user = new WP_User( $userID );
			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
				foreach ( $user->roles as $role ):
					$role;
				endforeach;	
			}
			$opt = get_option('wp_filemanager_options');
			$file_operations = array( 'mkdir', 'mkfile', 'rename', 'duplicate', 'paste', 'ban', 'archive', 'extract', 'copy', 'cut', 'edit','rm','download', 'upload', 'search', 'info', 'help' );
			/*
	         Ajax Data start
			*/
			$allowed_file_operations = array();
			//$accessfolder = (isset($_REQUEST['access_folder']) && $role !== 'administrator') ? $_REQUEST['access_folder'] : '';
			$accessfolder = (isset($_REQUEST['access_folder'])) ? $_REQUEST['access_folder'] : '';
			$allowedOperations = isset($_REQUEST['allowed_operations']) ? $_REQUEST['allowed_operations'] : '';
			$read = isset($_REQUEST['readd']) ? $_REQUEST['readd'] : 'true';
			$write = isset($_REQUEST['writte']) ? $_REQUEST['writte'] : 'false';
			if(!empty($allowedOperations)){
				if($allowedOperations == '*') {
				 $file_operations = array();	
				}
				else {
				  $allowedOperations =  explode(',',$allowedOperations);				
				  $file_operations = array_diff($file_operations, $allowedOperations); 
				}
			}
			else {
			   $file_operations = array();	
			}
			/* Folder Restriction */
			$folderRestricted = array();
			$fileRestricted = array();
			$restrictedFoldersdata = !empty($_REQUEST['hide_files']) ? $_REQUEST['hide_files'] : '';
			$restrictedFolders = explode(',', $restrictedFoldersdata);
					if(!empty($restrictedFolders[0]) && is_array($restrictedFolders) && $role !== 'administrator'):
					  foreach($restrictedFolders as $restrictedFolder):
						$folderRestricted[] = array( 'pattern' => '!^/'.$restrictedFolder.'!','hidden' => true );
					  endforeach;
					else:
						$folderRestricted[] = array('hidden' => false, 'read' => $read, 'write' => $write);			
					endif;
					//die;
			/* File restriction means lock */
			$restrictedFilesdata = !empty($_REQUEST['lock_extensions']) ? $_REQUEST['lock_extensions'] : '';	
			$restrictedfiles = explode('|', $restrictedFilesdata);
					if(!empty($restrictedfiles[0]) && is_array($restrictedfiles) && $role !== 'administrator'):
					  foreach($restrictedfiles as $restrictedFile):
					   $pattern = '/'.$restrictedFile.'$/';
					   $fileRestricted[] = array( 'pattern' => $pattern, 'write' => false, 'locked' => true );
					  endforeach;
					else:
					   $fileRestricted[] = array( 'pattern' => '', 'locked' => false, 'read' => $read, 'write' => $write );			
					endif;
				    $mime_allowed = array('text', 'image', 'application','audio/mpeg');
					$mime_denied = array('');	
					 /* Path View */		
					 $siteUrl = site_url();
					 if(!empty($accessfolder)) {
						$siteUrl .= '/'.$accessfolder;  
					 }
					 $mk_restrictions = array();
					 /* Limit To 100 */
					 for($mu=0; $mu<=100; $mu++) {
						$mk_restrictions[$mu] = $fileRestricted[$mu]; 
						$mk_restrictions[$mu] = $folderRestricted[$mu];
					 }	
					 
		    	/*
			      Ajax Data end
			    */
				$opts = array(
				   'debug' => true,
				   'roots' => array(
					array(
						'driver'        => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
						'path'          => ABSPATH.$accessfolder, // path to files (REQUIRED)
						'URL'           => $siteUrl, // URL to files (REQUIRED)
				     	'uploadDeny'    => $mime_denied, // All Mimetypes not allowed to upload
					    'uploadAllow'   => $mime_allowed, 
						'uploadOrder'   => array('deny', 'allow'), 
						'accessControl' => 'access', //disable and hide dot starting files(OPTIONAL)
						'uploadMaxSize' => !empty($opt['fm_max_upload_size']) ? $opt['fm_max_upload_size'].'M' : '2M', 
						'disabled'      => $file_operations,
				        'attributes' => $mk_restrictions
					)
				)
			);
			$connector = new elFinderConnector(new elFinder($opts));
			$connector->run();
			die;				
		}
		/* Shortcode admin control Usage: [wp_file_manager_admin] */		
		public function wp_file_manager_front_view_admin_control()
		{
		  $filemanagerReturn = '';	
		   include('inc/shortcode_admin_control.php');
		  return $filemanagerReturn;
		}
		/*
		* Shortcode Thing
		* usage: [wp_file_manager allowed_roles="editor,author" access_folder="wp-content/plugins" write = "true" read = "false" hide_files = "kumar,abc.php" lock_extensions=".php,.css" allowed_operations="upload,download" ban_user_ids="2,3"]
		*/
		public function wp_file_manager_front_view($atts)
		{ 
		  $filemanagerReturn = '';
		   include('inc/shortcode.php');
		  return $filemanagerReturn;
		}
		/*
		* Redirection
		*/
		static function redirect($url)
		{
			echo '<script>window.location.href="'.$url.'"</script>';
			die;
		}
		/*
		* File Manager Code editor themes
		*/
		static function getFfmThemes()
	    {
			$dir = dirname( __FILE__ ).'/lib/codemirror/theme/';
			$theme_files = glob($dir."/*.css");
			$mapthemes = array();
			foreach($theme_files as $theme_file){
				$mapthemes[basename($theme_file,".css")]=basename($theme_file,".css");
			}
			return $mapthemes;
	    }
		/* Verify */
		static function verify($oid, $lk, $red)
	    {
			$orderID = $oid;
			$licenceKey = $lk; 
			$wp_file_manager_pro = array();		
			if(fm_curl_exists()) {
				$API = 'http://www.webdesi9.com/pluginsapi.php';	
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $API);
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // save to returning 1
				curl_setopt($curl, CURLOPT_POSTFIELDS, "orderid=".$orderID."&licencekey=".$licenceKey."&nonce=ungt56ghsdewj87h");
				$result = curl_exec ($curl); 
				$data = json_decode($result,true);
				curl_close ($curl);
			} else {
			   $API = "http://www.webdesi9.com/pluginsapi.php?orderid=".$orderID."&licencekey=".$licenceKey."&nonce=ungt56ghsdewj87h";
               $result = file_get_contents($API);
               $data = json_decode($result,true);	
			}
			if($data['error'] == '0') {
			   self::success('Congratulations. Verified Successfully.');
			   $wp_file_manager_pro['ispro'] = 'yes';	
			   $wp_file_manager_pro['serialkey'] = $data['serialkey'];
			   $wp_file_manager_pro['orderid'] = $data['orderid'];
			   if(is_multisite()) { //Multisite Fix
				   $sites = get_sites();
				    foreach( $sites as $site ) {
					switch_to_blog( $site->blog_id );
					delete_option('wp_file_manager_pro');
			        $updated = update_option('wp_file_manager_pro', $wp_file_manager_pro );
					restore_current_blog();
					}                  
			   } else {
				 delete_option('wp_file_manager_pro');  
			     $updated = update_option('wp_file_manager_pro', $wp_file_manager_pro );
			   }
			   if($updated):
			    self::redirect('admin.php?page='.$red);
			   endif;
			}
			else {
				self::error($data['error']);
			}
	   }
	   /* File Manager Update Checking */
	   public function check_fm_updates()
	   {
		    $path = $_SERVER['REQUEST_URI'];
			$file = basename($path, ".php");
			$file_name = explode('?', $file);
		    $orderDetails = get_option('wp_file_manager_pro');
		    require_once ( 'fm_update_checker/fm_update_checker.php');
			$plugin_current_version = self::FILE_MANAGER_VERSION;
			$plugin_remote_path = 'http://www.webdesi9.com/plugin_server/wp_file_manager/update.php';
			$plugin_slug = plugin_basename( __FILE__ );
			$license_order = $orderDetails['orderid'];
			$license_key = $orderDetails['serialkey'];
			if(($file_name[0] == 'plugins.php') || ($file_name[0] == 'plugins')) {
		      new FM_AutoUpdate( $plugin_current_version, $plugin_remote_path, $plugin_slug, $license_order, $license_key );
			}
	   }
	   /* API URL */	
	   static function api($path)
	   {
		   return 'http://www.webdesi9.com/'.$path;
	   }
	   /* Error Msg */	
	  static function error($msg)
	  {
		  _e('<div id="setting-error-settings_updated" class="error settings-error notice"><p><strong>'.$msg.'</strong></p></div>','wp-file-manager-pro');
	  }
	  /* Success Msg */
	  static function success($msg)
	  {
		  _e('<div id="setting-error-settings_updated" class="updated settings-error notice"><p><strong>'.$msg.'</strong></p></div>','wp-file-manager-pro'); 
	  }
	  /* Order Details */
	  public function orderdetails()
	  {
		if(is_admin()) {
			$orderDetails = get_option('wp_file_manager_pro'); add_thickbox(); ?>
			<a href="#TB_inline?width=300&height=150&inlineId=fm_order_details" class="thickbox order_details_link button" title="Your File Manager PRO Order Details"> <?php _e('Order Details','wp-file-manager-pro');?></a>
			<div id="fm_order_details" style="display:none;">
				 <p><strong><?php _e('Order ID: ','wp-file-manager-pro');?></strong> <code><?php echo $orderDetails['orderid']; ?></code></p>
				 <p><strong><?php _e('License Key: ','wp-file-manager-pro');?></strong><code><?php echo $orderDetails['serialkey']; ?></code></p>
                 <p class="notice notice-error"><strong> <?php _e('&nbsp; Warning: Please don\'t share these details with anyone.','wp-file-manager-pro')?></strong></p>
			</div>
			<?php } 
	  }
	  /* Languages */
	  public function fm_languages() {
		  $langs =  array('English'=>'en', 
		                  'Arabic'=>'ar', 
						  'Bulgarian' => 'bg',
						  'Catalan' => 'ca', 
						  'Czech' => 'cs', 
						  'Danish' => 'da',
						  'German' => 'de',
						  'Greek' => 'el',
						  'Español' => 'es',
						  'Persian-Farsi' => 'fa',
						  'Faroese translation' => 'fo',
						  'French' => 'fr',
						  'Hebrew (עברית)' => 'he',
						  'hr' => 'hr',
						  'magyar' => 'hu',
						  'Indonesian' => 'id',
						  'Italiano' => 'it',
						  'Japanese' => 'jp',
						  'Korean' => 'ko',
						  'Dutch' => 'nl',
						  'Norwegian' => 'no',
						  'Polski' => 'pl',
						  'Português' => 'pt_BR',
						  'Română' => 'ro',
						  'Russian (Русский)' => 'ru',
						  'Slovak' => 'sk',
						  'Slovenian' => 'sl',
						  'Serbian' => 'sr',
						  'Swedish' => 'sv',
						  'Türkçe' => 'tr',
						  'Uyghur' => 'ug_CN',
						  'Ukrainian' => 'uk',
						  'Vietnamese' => 'vi',
						  'Simplified Chinese (简体中文)' => 'zh_CN',
						  'Traditional Chinese' => 'zh_TW',
						  );
		  return $langs;
	  }
	}
	$filemanager = new mk_file_folder_manager;	
	global $filemanager;
	/* end class */	
		function fm_curl_exists(){
         return function_exists('curl_version');
       }
endif;	