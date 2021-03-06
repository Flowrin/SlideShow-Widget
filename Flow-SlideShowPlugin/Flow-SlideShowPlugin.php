<?php

/*
 * Plugin Name: Flow-SlideShowPlugin
 * Plugin URI: 
 * Description: This plugin is a school assignments.
 * Version: 1.0.0
 * Author: Florin
 * Author URI: http://www.flow.com
 * Text Domain: flow-plugin
 */

class fp_Widget extends WP_Widget
    {
        public function __construct()
        {

            parent::__construct('fp_Widget','Flow SlideShow', array('descrption'=>__('Flows SlideShow Widget','text_domain')));

        }

        public function form($instance)
        {

            if(isset($instance['title']))
            {
                $title=$instance['title'];

            }
            else
            {
                $title=__('Widget SlideShow','text_domain')  ;
            }

            ?>
            <p>

            <label for="<?php echo $this ->get_field_id('title');?>"><?php _e('Title:');?></label>
            <input class="widefat" id="<?php echo $this ->get_field_id('title');?>" name="
            <?php echo $this ->get_field_id('title');?>" type="text" value ="
            <?php echo esc_attr($title);?>"  />

            </p>
<?php
               }


        public function update($new_instance,$old_instance)
        {
            $instance=array();
            $instance['title']=$new_instance['title'];
            return $instance;
        }       

        public function widget ($args,$instance)
        {
        echo $args['before_widget'];
        if(!empty($instance['title']))
        {
        echo $args['before_title']
        . $instance['title']
        . $args['after_title'];
        }

            echo fp_function('fp_widget');
         

        }

    }

    function fp_register_scripts() 
    {
    if (!is_admin()) {
        wp_register_script('np_nivo-script', plugins_url('nivo-slider/jquery.nivo.slider.js', __FILE__));
        wp_register_script('np_script', plugins_url('script.js', __FILE__));
        wp_enqueue_script('jquery');
        wp_enqueue_script('np_nivo-script');
        wp_enqueue_script('np_script');
    }
}

    function fp_register_styles()
     {
      
    wp_register_style('fp_styles', plugins_url('nivo-slider/nivo-slider.css', __FILE__));
    wp_register_style('fp_styles_theme', plugins_url('nivo-slider/themes/default/default.css', __FILE__));

 

    wp_enqueue_style('fp_styles');
    wp_enqueue_style('fp_styles_theme');
}


    function fp_widgets_init()
    {
        register_widget('fp_Widget');

    }

    function fp_function ()
    {

        global $post,$type;
    $args = array('post_type' => 'np_images', 'posts_per_page' => 5);
    $result = '<div class="slider-wrapper theme-default">';
    $result .= '<div id="slider" class="nivoSlider">';
    
    $querry = new WP_Query($args);
    while ($querry->have_posts()) 
    {
        $querry->the_post();

        $img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $type);

        $result .='<img title="'.get_the_title().'" src="' . $img[0] . '" data-thumb="' . $img[0] . '" alt=""/>';
    }
    $result .= '</div>'.'</div>';

    return $result;
}

function fp_init()
 {
    add_shortcode('fp-shortcode', 'fp_function');
    
    add_image_size('fp_widget', 180, 100, true);
    add_image_size('fp_function', 600, 280, true);
    
    $args = array('public' => true, 
                    'label' => 'Flow CptImages', 
                    'supports' => array(
                                        'title',   
                                        'thumbnail'
                                        ));

    register_post_type('np_images', $args);
}


add_theme_support('post-thumbnails');
add_action('init', 'fp_init');
add_action('widgets_init', 'fp_widgets_init');
add_action('wp_print_scripts', 'fp_register_scripts');
add_action('wp_print_styles', 'fp_register_styles');
?>