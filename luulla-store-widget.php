<?php
/**
 * Plugin Name: Luulla Store Widget
 * Plugin URI: http://www.luulla.com/
 * Description: Luulla Store Widget to display store items.
 * Version: 0.1
 * Author: Luulla Dev
 * Author URI: http://www.luulla.com
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'luulla_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function luulla_load_widgets() {
	register_widget( 'Luulla_Widget' );
}

function luulla_shortcode( $attr, $contents) {
	$luulla_shortcode = '<script type="text/javascript" src="https://www.google.com/jsapi"></script>';
	$luulla_shortcode.= '<script type="text/javascript">google.load("jquery","1.7.1");</script>';
	$luulla_shortcode.= '<iframe id="luulla-body-iframe" src="http://www.luulla.com/app/widget/store/'.$contents.'/widget" frameborder=0 width="100%" height="420" vspace="0" hspace="0" marginwidth="0" marginheight="0" scrolling="no" noresize></iframe>';
	$luulla_shortcode.= '<script type="text/javascript">';
	$luulla_shortcode.= 'width=$("#luulla-body-iframe").parent().width();';
	$luulla_shortcode.= 'src="http://www.luulla.com/app/widget/store/'.$contents.'/widget";';
	$luulla_shortcode.= 'src=src+"?width="+width;';
	$luulla_shortcode.= 'src=src+"&row=4";';
	$luulla_shortcode.= 'src=src+"&gallery=false";';
	$luulla_shortcode.= '$("#luulla-body-iframe").attr("src",src);';
	$luulla_shortcode.= '</script>';
	return $luulla_shortcode;
}
add_shortcode( 'luulla', 'luulla_shortcode' );

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Luulla_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Luulla_Widget() {
		/* Widget settings. */
		$widget_ops = array( 
			'classname' => 'luulla',
			'description' => __('Luulla Store Widget to displays a store\'s products.', 'luulla') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'luulla-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'luulla-widget', __('Luulla Widget', 'luulla'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$store = isset($instance['store'])? $instance['store'] : false ;
		$row = isset($instance['row'])? $instance['row'] : 2;
		$show_gallery = isset( $instance['show_gallery'] ) ? $instance['show_gallery'] : true;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $store ) {
			print '<div id="luulla-store-widget">';
			print '<script type="text/javascript" src="https://www.google.com/jsapi"></script>';
			print '<script type="text/javascript">google.load("jquery","1.7.1");</script>';
			print '<iframe id="luulla-store-iframe" src="#" frameborder=0 width="100%" height="420" vspace="0" hspace="0" marginwidth="0" marginheight="0" scrolling="no" noresize></iframe>';
			print '<script type="text/javascript">';
			print 'width=$("#luulla-store-widget").parent().width();';
			print 'src="http://www.luulla.com/app/widget/store/'.$store.'/widget";';
			print 'src=src+"?width="+width;';
			print 'src=src+"&row='.$row.'";';
			if(!$show_gallery) { 
				print 'src=src+"&gallery=false";';
			}
			print 'if(width>=100 && width<140) {';
			print 'img_size=50;';
			print '} else if(width>=140 && width<165) {';
			print 'img_size=65;';
			print '} else if(width>=165 && width<180) {';
			print 'img_size=50;';
			print '} else if(width>=180 && width<210) {';
			print 'img_size=80;';
			print '} else if(width>=210 && width<240) {';
			print 'img_size=65;';
			print '} else if(width>=240 && width<270) {';
			print 'img_size=50;';
			print '} else if(width>=270 && width<300) {';
			print 'img_size=80;';
			print '} else if(width>=300 && width<340) {';
			print 'img_size=65;';
			print '} else if(width>=340 && width<380) {';
			print 'img_size=80;';
			print '} else if(width>=380 && width<430) {';
			print 'img_size=65;';
			print '} else if(width>=430 && width<480) {';
			print 'img_size=80;';
			print '} else if(width>=480 && width<540) {';
			print 'img_size=65;';
			print '} else if(width>=540 && width<600) {';
			print 'img_size=80;';
			print '} else if(width>=600 && width<640) {';
			print 'img_size=65;';
			print '} else if(width>=640) {';
			print 'img_size=80;';
			print '}';
			print 'height=65+(img_size+11)*'.$row.';';
			if($show_gallery) {
			print 'if (width<200) { height=height+(width-20)/180*140 + 40; } else { height = height + 140 + 30 }';
			}
			print '$("#luulla-store-iframe").attr("src",src);';
			print '$("#luulla-store-iframe").css("height",height);';
			print '</script>';
			print '</div>';
		} else {
		printf( '<p>' . __('Luulla Store Widget has not yet been configured, please configure it via the widget panel', 'luulla') . '</p>');
		}
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['store'] = strip_tags( $new_instance['store'] );
		$instance['row'] = strip_tags( $new_instance['row'] );
		/* No need to strip tags for sex and show_sex. */
		$instance['show_gallery'] = $new_instance['show_gallery'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'title' => __('Luulla Store Widget', 'luulla'), 
			'store' => '', 
			'row' => 2, 
			'show_gallery' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Your Name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'store' ); ?>"><?php _e('Your Store subdomain:', 'luulla'); ?></label>
			<input id="<?php echo $this->get_field_id( 'store' ); ?>" name="<?php echo $this->get_field_name( 'store' ); ?>" value="<?php echo $instance['store']; ?>" style="width:100%;" />
		</p>

		<!-- Your Row: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'row' ); ?>"><?php _e('Number of rows of items:', 'luulla'); ?></label>
			<input id="<?php echo $this->get_field_id( 'row' ); ?>" name="<?php echo $this->get_field_name( 'row' ); ?>" value="<?php echo $instance['row']; ?>" style="width:100%;" />
		</p>

		<!-- Show Gallery? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php if($instance['show_gallery']==true) {print "checked";} ?> id="<?php echo $this->get_field_id( 'show_gallery' ); ?>" name="<?php echo $this->get_field_name( 'show_gallery' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_gallery' ); ?>"><?php _e('Show Gallery?', 'luulla'); ?></label>
		</p>

	<?php
	}
}

?>