<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 13:04
 */
class JihWidget extends WP_Widget
{

    function __construct()
    {
        $widget_options = array(
            'classname' => 'jih_social',
            'description' => __('display social data')
        );
        parent::__construct('JihWidget','JIH Social',$widget_options);
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

function JihWidget_init()
{
    register_widget('JihWidget');
}

add_action('widgets_init','JihWidget_init');