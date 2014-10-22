<?php
/**
 * Created by PhpStorm.
 * User: Joel Harkes
 * Date: 14-Oct-14
 * Time: 12:04
 */

namespace Twig;

use JihViewHelper;
use Singleton;
use Twig_Autoloader;
use Twig_Environment;
use Twig_Loader_Filesystem;


class WpTwigViewHelper extends Singleton {

    public $twig;

    // @var $template Twig_TemplateInterface
    public $template;
    public $templateData = array();

    protected function __construct($viewLocation = null, $debug = true){
        require_once JIH_PATH.'Twig/Twig/Autoloader.php';
        Twig_Autoloader::register();

        $loader = new Twig_Loader_Filesystem($viewLocation ?: JIH_PATH.'views');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => JIH_PATH.'viewscache',
            'debug' => $debug
        ));
        $this->addFunction('get_sidebar');
        $this->addFunction('get_header');
        $this->addFunction('get_footer');
        $this->addFunction('get_template_part');
        $this->addFunction('get_search_form');
    }


    private function addFunction($string){
        $func = new FunctionWrapper($string);
        $func->add_to_twig($this->twig);
    }


    public function addTemplateData($key,$data){
        $this->templateData[$key] = $data;
    }

    public function TryRender(){
        return $this->template->render($this->templateData);
    }

    public function loadTemplate($template = 'test.twig'){
        $this->template = $this->twig->loadTemplate($template);
        JihViewHelper::getInstance()->LoadView('default-template');
    }

    public static function LoadView($template = 'test.twig',array $templateData = array(),$overwrite = false){
        $i = static::getInstance();
        $i->mergeTemplateData($templateData,$overwrite);
        $i->loadTemplate($template);
    }

    public function mergeTemplateData(array $data,$overwrite = false){
        $this->templateData = $overwrite ? $data : array_merge($this->templateData,$data);
    }


}



