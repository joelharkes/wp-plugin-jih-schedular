<?php
/*
Plugin Name: Jih Schedular
Plugin URI: https://wordpress.org/plugins/jih-schedular/
Description: A plugin that adds a page where you can show timetables, and people can schedule themselves in these tables.
Version: 1.2
Author: joelharkes
Author URI: http://URI_Of_The_Plugin_Author
License: GPL2
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
include("helpers/setting.php");

$program = new Program();
$program->start();

class Program {

    public $prefix;
    public $path;
    public $url;
    public $version;

    public $settings;

    public function  __construct(){
        $this->registerAutoload();

        $this->prefix = 'jih-schedular';
        $this->version = 1;
        $this->path = substr(plugin_dir_path( __FILE__ ),0,-1);
        $this->url = plugins_url('', __FILE__ );

        $this->settings = new \helpers\Settings($this->prefix.'-');
    }

    public function start(){
        $this->registerInstall();
        $this->registerTranslations();

        $this->handleApiCalls();

        $this->registerPages();
        $this->registerAdminPages();

        $JihHeadIncludes = new JihHeadIncludes();
    }


    public function registerPages(){
        //Frontend:

        $controller = new ScheduleController();
        //Register pages used by plugin
        $jihPageContainer = new \helpers\PageContainer();
        $jihPageContainer->add(new \helpers\Page($this->tr("Calendars"),array($controller,'WeekAction')));
        $jihPageContainer->add(new \helpers\Page($this->tr("Calendar request"),array($controller,'NewCalendarAction'),'Uw aanvraag is verstuurd naar de website administrator.'));
        //Register hooks needed for the pages.
        register_activation_hook( __FILE__,array($jihPageContainer,'registerPages') );
        register_deactivation_hook( __FILE__,array($jihPageContainer,'unregisterPages') );
    }

    public function registerTranslations(){
        add_action('plugins_loaded', array($this,'loadTranslations'));
    }

    public function loadTranslations(){
        load_plugin_textdomain( $this->prefix, false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
    }
    
    public function registerInstall()
    {
        add_action( 'plugins_loaded', array($this,'install') );
    }

    public function install()
    {
        if ( $this->settings->get('plugin-version') != $this->version ) {
            $installer = new \controllers\InstallController();
            $installer->InstallAction();
            $this->settings->set('plugin-version', $this->version );
        }
    }


    public function registerAutoload(){
        spl_autoload_register( array($this,'autoload') );
    }

    public function autoload($class){
        $sanitizedClass =  str_replace('\\',DIRECTORY_SEPARATOR,$class);
        $filePath = $this->path .DIRECTORY_SEPARATOR. $sanitizedClass . '.php';
        if ( file_exists ( $filePath ) ){
            include( $filePath);
        }
    }


    public function handleApiCalls(){
        if(Input::Post('dataType')=='json'){
            $controller = new AjaxController();// Save and Edit function Get Array as input
            if(str::startsWith(Input::Param('action'),'Save') || str::startsWith(Input::Param('action'),'Edit')){
                $controller->{Input::Param('action')}(Input::Param('input'));
            } else { //Rest gets called as User func array (array is split up as input parameters)
                call_user_func_array(array($controller,Input::Param('action')),Input::Param('input'));
            }
        }
    }

    public  function registerAdminPages(){
        // TODO: now the menukey is used in the callback (AdminController->route([menuKey]Action) => Fill callbackAction or directly link to view
        $adminMenu = new \helpers\AdminMenu($this->tr('Calendars'),null,'dashicons-calendar','calendars');
        $adminMenu->AddSubMenu(new \helpers\AdminSubMenu('Settings'));
        $adminMenu->AddSubMenu(new \helpers\AdminSubMenu($this->tr('Events'),null,'Events'));
        $adminMenu->AddSubMenu(new \helpers\AdminSubMenu($this->tr('Add Calendar'),null,'CalendarForm'));
        $adminMenu->AddSubMenu(new \helpers\AdminSubMenu($this->tr('Add Event'),null,'EventForm'));
    }

    /**
     * Translate function which uses the wp __() translate function. gets the translation out of the file named like the prefix
     * @param $text
     * @return string
     */
    public function tr($text){
        return __($text,$this->prefix);
    }
}


//INSTALL SCRIPT
//TODO REPLACE: SAFE Install and update
//TODO add translations: http://premium.wpmudev.org/blog/translating-wordpress-plugins/



function isAdministrator(){
    return current_user_can( 'manage_options' );
}

class str {
    static function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }
}