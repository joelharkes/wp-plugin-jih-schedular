<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 12:08
 */

class JihViewHelper extends Singleton {

    public $filePath = null;
    public $viewData = null;
    private $jsPaths = array();
    private $cssPaths = array();
    /**
     * Loads in a new page
     * @param string $view name of the file (without trailing .php)
     * @param mixed $viewData data which can be used by the view
     * @throws Exception when file can not be found
     */
    public function LoadView($view,$viewData=null){
        $file = $view.'.php';
        $wpTemplatePath = TEMPLATEPATH.'/'.$file;
        $viewPath = JIH_PATH.'/views/'.$file;
        $filePath=null;

        if(file_exists($wpTemplatePath))
            $filePath = $wpTemplatePath;
        if($filePath==null && file_exists($viewPath))
            $filePath = $viewPath;

        if($filePath){
            $this->filePath = $filePath;
            $this->viewData = $viewData;
            add_filter( 'template_include', array( __CLASS__, 'GetView' ));
        }
        else
            throw new Exception("File: $file not found in: $wpTemplatePath and $viewPath");
    }

    /**
     * @param string $fileName filename to be found (exclude .js!)
     * @param array $dependencies to other js files
     * @param string $overwriteFileName
     * @throws Exception if file not found
     */
    public function AddJs($fileName,$dependencies = array('jquery'),$overwriteFileName=null){
        $path = plugins_url('/js/'.$fileName.'.js',__FILE__);
        $this->jsPaths[] = array($overwriteFileName ?: $fileName,$path,$dependencies);
        if(count($this->jsPaths)<=1){
            add_action( 'wp_enqueue_scripts',  array( __CLASS__, 'GetJS' ) );
        }
        if(!file_exists($path = JIH_PATH.'js/'.$fileName.'.js')){
            throw new Exception("File: $path does not exist!");
        }
    }

    /**
     * @param string $fileName filename to be found (exclude .js!)
     * @param array $dependencies to other js files
     * @param string $overwriteFileName
     * @throws Exception if file not found
     */
    public function AddCss($fileName,$dependencies = array(),$overwriteFileName=null){
        $path = plugins_url('/css/'.$fileName.'.css',__FILE__);
        $this->cssPaths[] = array($overwriteFileName ?: $fileName,$path,$dependencies);
        if(count($this->cssPaths)<=1){
            add_action( 'wp_enqueue_scripts',  array( __CLASS__, 'GetCSS' ) );
        }
        if(!file_exists($path = JIH_PATH.'css/'.$fileName.'.css')){
            throw new Exception("File: $path does not exist!");
        }
    }

    /**
     * @return string File location
     */
    public static function GetView(){
        return self::getInstance()->filePath;
    }

    /**
     *  Enqueues javascript files to head
     */
    public static function GetJS(){
        foreach(self::getInstance()->jsPaths as $jsData){
            wp_enqueue_script($jsData[0], $jsData[1], $jsData[2]);
        }
    }

    public static function GetCSS(){
        foreach(self::getInstance()->cssPaths as $cssData){
            wp_enqueue_style($cssData[0], $cssData[1], $cssData[2]);
        }
    }


}

