<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 14-Oct-14
 * Time: 12:04
 */

//get_header()
//get_footer()
//get_sidebar()
//get_template_part()
//get_search_form()

class JihTwig extends Singleton {

    public $twig;

    // @var $template Twig_TemplateInterface
    public $template;
    public $templateData = array();

    protected function __construct($viewLocation = null, $debug = true){
        require_once JIH_PATH.'Twig/Autoloader.php';
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



class FunctionWrapper
{

    private $_function;
    private $_args;
    private $_use_ob;

    public function __toString() {
        return $this->call();
    }

    /**
     * @param callable $function
     * @param array $args
     * @param bool $return_output_buffer
     */
    public function __construct($function, $args = array(), $return_output_buffer = false) {
        $this->_function = $function;
        $this->_args = $args;
        $this->_use_ob = $return_output_buffer;

        add_filter('get_twig', array(&$this, 'add_to_twig'));
    }

    /**
     * @param Twig_Environment $twig
     * @return Twig_Environment
     */
    public function add_to_twig($twig) {
        $wrapper = $this;

        $twig->addFunction(new Twig_SimpleFunction($this->_function, function () use ($wrapper) {
            return call_user_func_array(array($wrapper, 'call'), func_get_args());
        }));

        return $twig;
    }

    /**
     * @return string
     */
    public function call() {
        $args = $this->_parse_args(func_get_args(), $this->_args);

        if ($this->_use_ob) {
            return TimberHelper::ob_function($this->_function, $args);
        } else {
            return (string)call_user_func_array($this->_function, $args);
        }
    }

    /**
     * @param array $args
     * @param array $defaults
     * @return array
     */
    private function _parse_args($args, $defaults) {
        $_arg = reset($defaults);

        foreach ($args as $index => $arg) {
            $defaults[$index] = is_null($arg) ? $_arg : $arg;
            $_arg = next($defaults);
        }

        return $defaults;
    }

}