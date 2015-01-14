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
use controllers\JihSchedularController;
use Twig\WpTwigViewHelper;

define('JIH_PATH',plugin_dir_path( __FILE__ ));
define('JIH_CONTROLLER_ACTION_PARAM','Action');

include(ABSPATH . "wp-includes/pluggable.php");

//AUTOLOADING CLASSES
spl_autoload_register( 'AutoLoadJihSchedularFiles' );
function AutoLoadJihSchedularFiles( $class ) {
    $sanitizedClass =  str_replace('\\',DIRECTORY_SEPARATOR,$class);
//    if(strpos($sanitizedClass,'WpConnection')!==false){
//        die('Dide class load: Tried to load file: '.JIH_PATH . $sanitizedClass . '.php and it exists?:'.file_exists ( JIH_PATH . $sanitizedClass . '.php' ));
//    }
    if ( file_exists ( JIH_PATH . $sanitizedClass . '.php' ) ){
        include( JIH_PATH . $sanitizedClass . '.php' );
    }
}

//INSTALL SCRIPT
add_action( 'plugins_loaded', 'InstallPlugin' );

global $jih_version;
$jih_version = '1.5';
function InstallPlugin() {
    global $jih_version;
    if ( get_site_option( 'jih_schedular_version' ) != $jih_version ) {
        JihInstaller::Install();
//        JihInstaller::InstallTestDate();
    }
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
        $controller = new JihSchedularController();
        $controller->route(Input::Param(JIH_CONTROLLER_ACTION_PARAM));
    }


} else { //If in admin zone
    //ADMIN STUFF
    add_action( 'admin_menu', 'register_admin_menu');
    function register_admin_menu(){
        //Links to AdminController->[item]Action();
        add_menu_page( 'Jih Schedular', 'Schedular', 'manage_options', 'jih-calendars', 'adminAction','dashicons-calendar' );
        addSubMenu('Events');
        addSubMenu('CalendarForm');
        addSubMenu('EventForm','Event');

    }

    AdminController::DoImports();

}

function adminAction(){
    $post = ucfirst(substr(Input::Get('page'),4))  ;
    $controller = new AdminController();
    $controller->route($post);
    echo WpTwigViewHelper::getInstance()->TryRender();
}

function addSubMenu($title,$parent= 'jih-calendars',$action = 'adminAction',$pre='jih-'){
    $titleName = preg_replace('/(?<=\\w)(?=[A-Z])/'," $1", $title);
    add_submenu_page($parent, $titleName, $titleName, 'manage_options', $pre.$title, $action);
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
