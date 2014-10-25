<?php
/*
Plugin Name: Jih Schedular
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.1
Author: Joel
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/


define('JIH_PATH',plugin_dir_path( __FILE__ ));
define('JIH_CONTROLLER_ACTION_PARAM','Action');
define('AJAX_URL',WP_CONTENT_URL.'/plugins/jih-schedular/ajax.php');

//INSTALL SCRIPT
global $jih_version;
$jih_version = '1.4';
function InstallPlugin() {
    global $jih_version;
    if ( get_site_option( 'jih_schedular_version' ) != $jih_version ) {
        JihInstaller::Install();
//        JihInstaller::InstallTestDate();
    }
}
add_action( 'plugins_loaded', 'InstallPlugin' );

//AUTOLOADING CLASSES
spl_autoload_register( 'AutoLoadJihSchedularFiles' );
function AutoLoadJihSchedularFiles( $class ) {
    if ( file_exists ( JIH_PATH . $class . '.php' ) ){
        include( JIH_PATH . $class . '.php' );
    }
}

//$twigHelper = Twig\WpTwigViewHelper::getInstance();
//$twigHelper->loadTemplate();
//$twigHelper->addTemplateData('yolo','it aint working!');
//
//$twig = $twigHelper->twig;


//CONTROLLER LOGIC
$controller = new JihSchedularController();
if(Input::Param(JIH_CONTROLLER_ACTION_PARAM)){
    $controller->route(Input::Param(JIH_CONTROLLER_ACTION_PARAM));
}



//EXAMPLES!!


//add_filter( 'body_class',function($data){ return array('test');});

//function switchTemplate(){
//    return JIH_PATH.'/views/default-template.php';
//}
//
//if(isset($_GET['jih'])){
//    add_filter( 'template_include', 'switchTemplate' );
//}




