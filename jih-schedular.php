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

class Jih_Schedular extends WP_Widget
{

    function __construct()
    {
        $widget_options = array(
            'classname' => 'jih_social',
            'description' => __('display social data')
        );

//        $control_ops = array(
//            'width' => 250,
//            'height' => 250,
//            'id_base' => 'Jih_Schedular'
//        );

        parent::__construct('Jih_Schedular','JIH Social',$widget_options);//,$control_ops);
    }

    function widget($args, $instance)
    {
        extract($args,EXTR_SKIP);

        $title = ($instance['title']) ? $instance['title'] : 'JIH Title';
        $fb = ($instance['facebook']) ? $instance['facebook'] : 'joel.harkes';
        $icon = plugins_url('images/fb-logo.png',__FILE__);

        echo  $before_widget;
        echo  $before_title . $title . $after_title; ?>
<a href="http://facebook.com/<?php echo $fb ?>"><img src="<?php echo $icon ?>" alt="" height="50px" /></a>
<?php echo  $after_widget; ?>
<?php
    }

    function  update($new_instance,$old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['facebook'] = strip_tags($new_instance['facebook']);
        return $instance;
    }

    function form($instance)
    {
        $default = array(
            'title' => 'JIH Social' ,
            'facebook' => 'joel.harkes'
        );
        $instance = wp_parse_args($instance, $default);
        $title = $instance['title'];
        $fb = $instance['facebook'];
        ?>
        <p>Title: <input class="jih_social" name="<?php echo  $this->get_field_name('title'); ?>" type="text" value="<?php echo  esc_attr($title) ?>"></p>
        <p>Title: <input class="jih_social" name="<?php echo  $this->get_field_name('facebook'); ?>" type="text" value="<?php echo  esc_attr($fb) ?>"></p>
<?php
    }

}

function Jih_Schedular_init()
{
    register_widget('Jih_Schedular');
}

add_action('widgets_init','Jih_Schedular_init');

add_filter( 'body',function($data){ return '';});