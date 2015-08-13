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


use controllers\AdminController;
use controllers\AjaxController;
use controllers\ScheduleController;
use helpers\Input;
use Twig\WpTwigViewHelper;

define('JIH_PATH',substr(plugin_dir_path( __FILE__ ),0,-1));
define('JIH_URL',plugins_url('', __FILE__ ));
define('JIH_CONTROLLER_ACTION_PARAM','Action');

include(ABSPATH . "wp-includes/pluggable.php");

//AUTOLOADING CLASSES
spl_autoload_register( 'AutoLoadJihSchedularFiles' );
function AutoLoadJihSchedularFiles( $class ) {
    $sanitizedClass =  str_replace('\\',DIRECTORY_SEPARATOR,$class);
    $filePath = JIH_PATH .DIRECTORY_SEPARATOR. $sanitizedClass . '.php';
    if ( file_exists ( $filePath ) ){
        include( $filePath);
    }
}

add_action('plugins_loaded', 'loadTranslations');
function loadTranslations() {
    load_plugin_textdomain( 'jih-schedular', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
}

//INSTALL SCRIPT
//TODO REPLACE: SAFE CREATE TABLE AND
add_action( 'plugins_loaded', 'InstallPlugin' );

$jih_version = 1;
function InstallPlugin() {
    global $jih_version;
    if ( get_option( 'jih_schedular_version' ) != $jih_version ) {
        $installer = new \controllers\InstallController();
        $installer->InstallAction();
        update_option( 'jih_schedular_version', $jih_version );
    }

}

//TODO add translations: http://premium.wpmudev.org/blog/translating-wordpress-plugins/

$JihHeadIncludes = new JihHeadIncludes();

$controller = new ScheduleController();
//Register pages used by plugin
$jihPageContainer = new \helpers\PageContainer();
$jihPageContainer->add(new \helpers\Page("Calendars",array($controller,'WeekAction')));
$jihPageContainer->add(new \helpers\Page("Calendar request",array($controller,'NewCalendarAction'),'Uw aanvraag is verstuurd naar de website administrator.'));
//Register hooks needed for the pages
register_activation_hook( __FILE__,array($jihPageContainer,'registerPages') );
register_deactivation_hook( __FILE__,array($jihPageContainer,'unregisterPages') );


//Register API CALLS
if(Input::Param('Install',false)){
    $controller = new \controllers\InstallController();
    $controller->route(Input::Param('Install'));
}


//CONTROLLER LOGIC
if(Input::Post('dataType')=='json'){
    $controller = new AjaxController();// Save and Edit function Get Array as input
    if(startsWith(Input::Param('action'),'Save') || startsWith(Input::Param('action'),'Edit')){
        $controller->{Input::Param('action')}(Input::Param('input'));
    } else { //Rest gets called as User func array (array is split up as input parameters)
        call_user_func_array(array($controller,Input::Param('action')),Input::Param('input'));
    }
}
if(!is_admin()){

    if(Input::Param(JIH_CONTROLLER_ACTION_PARAM)){
        $controller = new ScheduleController();
        $controller->route(Input::Param(JIH_CONTROLLER_ACTION_PARAM));
    }


} else {
        //If in admin zone
    //ADMIN STUFF

    $adminMenu = new \helpers\AdminMenu('Calendars');
    $adminMenu->AddSubMenu(new \helpers\AdminSubMenu('Settings'));
    $adminMenu->AddSubMenu(new \helpers\AdminSubMenu('Events'));
    $adminMenu->AddSubMenu(new \helpers\AdminSubMenu('Add Calendar',null,'CalendarForm'));
    $adminMenu->AddSubMenu(new \helpers\AdminSubMenu('Add Event',null,'EventForm'));
}

function isAdministrator(){
    return current_user_can( 'manage_options' );
}

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}


//EXAMPLES!!


//$twigHelper = Twig\WpTwigViewHelper::getInstance();
//$twigHelper->loadTemplate();
//$twigHelper->addTemplateData('yolo','it aint working!');
//
//$twig = $twigHelper->twig;

//add_filter( 'body_class',function($data){ return array('test');});

//function switchTemplate(){
//    return JIH_PATH.'/views/default-template.php';
//}
//
//if(isset($_GET['jih'])){
//    add_filter( 'template_include', 'switchTemplate' );
//}

//add_action( 'wp_ajax_my_action', 'myAction' );
//
//function myAction(){
//    echo json_encode('yoloooh');
//    die();
//}