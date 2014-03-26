<?php
/*
Plugin Name: Manage organization staff
Plugin URI: https://github.com/venturit/wp-staff
Description: Wordpress Plugin to manage organization staff Members
Version: 1.0
Author: Venturit
Author URI: http://www.venturit.com
License:GPL2
*/

function do_theme_redirect($url) {
	global $post, $wp_query;
	if (have_posts()) {
		include($url);
		die();
	} else {
		$wp_query->is_404 = true;
	}
}

function staff_func( $atts ) {
	// a = SELECT 	* From wp_posts WHERE post_type = 'vt_vtstaff' and wp_posts.post_status = 'publish'
	$i = 0;

	global $wpdb, $paged, $max_num_pages;
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$post_per_page = 20; //6
	$offset = ($paged - 1)*$post_per_page;
	
	$query_president = "
	SELECT * From wp_posts WHERE wp_posts.post_type = 'vt_vtstaff' and wp_posts.post_status = 'publish' and wp_posts.post_title like 'President%';";
	$president = $query_president;
	$president_result = $wpdb->get_results( $president, OBJECT);
	if ($president_result){
		$i = 1;
		// var_dump($president_result);
		$president_profile_id = $president_result[0]->ID;

		$output .= "<div class='row'>";
		$output .= "<div class='small-6 columns'>
			<div class='row'>
				<div class='small-4 columns'>
					<figure>
						<a href='". post_permalink( $president_profile_id ) ."' rel='bookmark'><span class='staff_thumbnail'>". get_the_post_thumbnail($president_profile_id, array(9999, 220)) ."</span></a>
					</figure>
				</div>
				<div class='small-8 columns'>
					<span><a href='". post_permalink( $president_profile_id ) ."' rel='bookmark'><h4><span class='st_title'>" . get_post_meta( $president_profile_id, 'vt_fname', true )." " .get_post_meta( $president_profile_id, 'vt_lname', true ). "</span></h4></a><p class='st_designation'>". $president_result[0]->post_title ."</p></span>
				<br/ >
				<ul>
					<li class='st-post-meta'><i class='fi-telephone small'><span class='post-meta-span-deta'>". get_post_meta( $president_profile_id, 'vt_phone', true ) ."</spa></i></li>
					<li class='st-post-meta'><i class='fi-mail small'><span class='post-meta-span-deta'><a href='mailto:". get_post_meta( $president_profile_id, 'vt_email', true ) ."'>". get_post_meta( $president_profile_id, 'vt_email', true ) ."</a></span></i></li>
				</ul>
				</div>
			</div>
			<div class='row'>
				<div class='large-12 columns'><p class='staff_vision'>". get_post_meta( $president_profile_id, 'vt_vision', true ) ."</p></div>
			</div>
			<div class='row'>
				<div class='large-12 columns'>
					<span class='vt-toggle-title'><i class='fi-folder small'><span class='post-meta-span-deta'>About Me</span></i></span><br /><br />
					<p class='vt-toggle-pane'>".$president_result[0]->post_content."</p>
				</div>
			</div>
		</div>";
	}

		
	$query_spicy = "
		SELECT * From wp_posts INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id WHERE wp_posts.post_type = 'vt_vtstaff' and wp_posts.post_status = 'publish' and wp_postmeta.meta_key = 'vt_lname' ORDER BY wp_postmeta.meta_value;";

	$spicy = $query_spicy;
	$spicy_results = $wpdb->get_results( $spicy, OBJECT);

if ($spicy_results):
	global $post;
	foreach ($spicy_results as $portfolios_post) :
		if ((int)$portfolios_post->ID != (int)$president_profile_id) {
			$i += 1;
			if($i ==1 ){
				$output .= "<div class='row'>";
				$output .= "<div class='small-6 columns'>
					<div class='row'>
						<div class='small-4 columns'>
							<figure>
								<a href='". post_permalink( $portfolios_post->ID ) ."' rel='bookmark'><span class='staff_thumbnail'>". get_the_post_thumbnail($portfolios_post->ID, array(9999, 220)) ."</span></a>
							</figure>
						</div>
						<div class='small-8 columns'>
							<span><a href='". post_permalink( $portfolios_post->ID ) ."' rel='bookmark'><h4><span class='st_title'>" . get_post_meta( $portfolios_post->ID, 'vt_fname', true )." " .get_post_meta( $portfolios_post->ID, 'vt_lname', true ). "</span></h4></a><p class='st_designation'>". $portfolios_post->post_title ."</p></span>
						<br/ >
						<ul>
							<li class='st-post-meta'><i class='fi-telephone small'><span class='post-meta-span-deta'>". get_post_meta( $portfolios_post->ID, 'vt_phone', true ) ."</spa></i></li>
							<li class='st-post-meta'><i class='fi-mail small'><span class='post-meta-span-deta'><a href='mailto:". get_post_meta( $portfolios_post->ID, 'vt_email', true ) ."'>". get_post_meta( $portfolios_post->ID, 'vt_email', true ) ."</a></span></i></li>
						</ul>
						</div>
					</div>
					<div class='row'>
						<div class='large-12 columns'><p class='staff_vision'>". get_post_meta( $portfolios_post->ID, 'vt_vision', true ) ."</p></div>
					</div>
					<div class='row'>
						<div class='large-12 columns'>
							<span class='vt-toggle-title'><i class='fi-folder small'><span class='post-meta-span-deta'>About Me</span></i></span><br /><br />
							<p class='vt-toggle-pane'>".$portfolios_post->post_content."</p>
						</div>
					</div>
				</div>";
			}else{
				$output .= "<div class='small-6 columns'>
					<div class='row'>
						<div class='small-4 columns'>
							<figure>
								<a href='". post_permalink( $portfolios_post->ID ) ."' rel='bookmark'><span class='staff_thumbnail'>". get_the_post_thumbnail($portfolios_post->ID, array(9999, 220)) ."</span></a>
							</figure>
						</div>
						<div class='small-8 columns'>
							<span><a href='". post_permalink( $portfolios_post->ID ) ."' rel='bookmark'><h4><span class='st_title'>" . get_post_meta( $portfolios_post->ID, 'vt_fname', true )." " .get_post_meta( $portfolios_post->ID, 'vt_lname', true ). "</span></h4></a><p class='st_designation'>". $portfolios_post->post_title ."</p></span>
							<br/ >
							<ul>
								<li class='st-post-meta'><i class='fi-telephone small'><span class='post-meta-span-deta'>". get_post_meta( $portfolios_post->ID, 'vt_phone', true ) ."</spa></i></li>
								<li class='st-post-meta'><i class='fi-mail small'><span class='post-meta-span-deta'><a href='mailto:". get_post_meta( $portfolios_post->ID, 'vt_email', true ) ."'>". get_post_meta( $portfolios_post->ID, 'vt_email', true ) ."</a></span></i></li>
							</ul>
						</div>
					</div>
					<div class='row'>
						<div class='large-12 columns'><p class='staff_vision'>". get_post_meta( $portfolios_post->ID, 'vt_vision', true ) ."</p></div>
					</div>
					<div class='row'>
						<div class='large-12 columns'>
							<span class='vt-toggle-title'><i class='fi-folder small'><span class='post-meta-span-deta'>About Me</span></i></span><br /><br />
							<p class='vt-toggle-pane'>".$portfolios_post->post_content."</p>
						</div>
					</div>
					<div>
				</div>";
				$output .= "</div></div>";
			}
			if($i ==2){
				$output .= "<hr class='staff_hr'>";
				$i = 0;
			}
			setup_postdata($portfolios_post);
		}
	endforeach;
endif;

	return $output;
}
add_shortcode( 'staff', 'staff_func' );

global $prefix;
$prefix = "vt_";

add_action('init', 'vt_wp_staff_product');

function vt_wp_staff_product() {
	global $prefix;
	register_post_type( $prefix.'vtstaff',
		array(
			'labels' => array(
			'name' => _('Manage Staff Members'),
			'singular_name' => _('Manage Staff Members'),
			'add_new' => _('Add Staff Member'),
			'search_items' => _('Search Staff Member'),
			'all_items' => _('All Staff Members'),
			'edit_item' => _('Edit Staff Member'),
			'update_item' => _('Update Staff Member'),
			'add_new_item' => _('Add Staff Member'),
			'new_item_name' => _('New Staff Member'),
			'not_found' => _('No Staff Member(s) found'),
			'not_found_in_trash' => _('No Staff Member(s) found in Trash'),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'vtstaff'),
		'taxonomies'=> array('post_tag','vtstaff'),
		'supports'=>array('title','editor','author','thumbnail','revisions'),
		'register_meta_box_cb' => 'vt_vtstaff_meta_boxes', 
	)
	);
}
// register meta box
$meta_box = array(
	'id'=> 'vtstaff-meta-box',
	'title' => 'Other Details',
	'callback' => 'vt_vtstaff_show_box',
	'page' => $prefix.'vtstaff',
	'context' => 'normal',
	'priority' => 'high',
	'fields' =>  array( array(
		'name' => 'First Name',
		'desc' => '',
		'id' => $prefix . 'fname',
		'type' => 'text',
		'std' => '' //
		)	,
		array(
			'name' => 'Last Name',
			'desc' => '',
			'id' => $prefix . 'lname',
			'type' => 'text',
			'std' => '' //
			),
		array(
			'name' => 'Personal Life Vision',
			'desc' => '',
			'id' => $prefix . 'vision',
			'type' => 'textarea',
			'std' => '' //
			),
		array(
			'name' => 'Phone Number',
			'desc' => '',
			'id' => $prefix . 'phone',
			'type' => 'text',
			'std' => '' //
			),
			array(
				'name' => 'E-mail',
				'desc' => '',
				'id' => $prefix . 'email',
				'type' => 'text',
				'std' => '' //
				)
				// ,
					// array(
					// 					'name' => 'Profile Order Number',
					// 					'desc' => '',
					// 					'id' => $prefix . 'order',
					// 					'type' => 'select',
					// 					'options' => range(1,40),
					// 					'std' => '' //
					// 				)
	)
);


function vt_vtstaff_meta_boxes() {

global $meta_box;
global $prefix;
	$meta_boxes = array($meta_box);
	foreach ($meta_boxes as $mb) {
			add_meta_box($mb['id'], $mb['title'], $mb['callback'], $mb['page'], $mb['context'], $mb['priority']);	
	}
}


// Callback function to show fields in meta box
function vt_vtstaff_show_box() {
  
	global $meta_box, $post, $prefix;

	// Use nonce for verification
	echo '<input type="hidden" name="'.$prefix.'vtstaff_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	

	foreach ($meta_box['fields'] as $field) {

		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		
		switch ($field['type']) {
			case 'text':
				echo "<br /><div> <span>".$field['name']."</span><br />";
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
					'<br />', $field['desc'];
				break;
			case 'textarea':
				echo "<br /><div> <span>".$field['name']."</span><br />";
				echo '<textarea name="', $field['id'], '" id="', $field['id'], '" class="theEditor" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
					'<br />';
				break;
			case 'select':
				echo "<br /><div> <span>".$field['name']."</span><br />";
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as $option) {
					echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				echo '</select>';
				break;
			case 'radio':
				echo "<br /><div> <span>".$field['name']."</span><br />";
				foreach ($field['options'] as $option) {
					echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
				}
				break;
			case 'checkbox':
				echo "<br /><div> <span>".$field['name']."</span><br />";
				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
				break;
			
			case 'hidden':
					echo "<br /><div>";
					echo '<input type="hidden" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" />';
					break;
		}
		echo "</div><br />";
	}
}

add_action('save_post', 'vt_vtstaff_save_meta_data');

// Save data from meta boxes
function vt_vtstaff_save_meta_data($post_id) {
global $meta_box, $prefix;

// verify nonce
if (!wp_verify_nonce($_POST[$prefix.'vtstaff_meta_box_nonce'], basename(__FILE__))) {
	return $post_id;
}

// check autosave
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	return $post_id;
}

// check permissions
if ('page' == $_POST['post_type']) {
	if (!current_user_can('edit_page', $post_id)) {
		return $post_id;
	}
} elseif (!current_user_can('edit_post', $post_id)) {
	return $post_id;
}

foreach ($meta_box['fields'] as $field) {
	$old = get_post_meta($post_id, $field['id'], true);
	$new = $_POST[$field['id']];

	if ($new && $new != $old) {
		update_post_meta($post_id, $field['id'], $new);
	} elseif ('' == $new && $old) {
		delete_post_meta($post_id, $field['id'], $old);
	}
}

if (wp_is_post_revision($post_id)) {
	return;
}

}

function vt_admin_head() {
	echo '<link rel="stylesheet" type="text/css" href="' .plugins_url('wp-admin.css', __FILE__). '">';
}
add_action('admin_head', 'vt_admin_head');

function get_vt_vtstaff_post_type_template($single_template) {
	global $post;

	if ($post->post_type == 'vt_vtstaff') {
		$single_template = dirname( __FILE__ ) . '/page-templates/single-vtstaff.php';
	}
	return $single_template;
}

// add_filter( 'page_template', 'wpa3396_page_template' );
// function wpa3396_page_template( $page_template )
// {
//     if ( is_page( 'my-custom-page-slug' ) ) {
//         $page_template = dirname( __FILE__ ) . '/page-templates/wp-staff_page.php';
//     }
//     return $page_template;
// }

function get_rendom_member() {

	global $wpdb, $paged, $max_num_pages;

	$query_spicy = "
		SELECT 	* From wp_posts WHERE post_type = 'vt_vtstaff' and wp_posts.post_status = 'publish' ORDER BY RAND() LIMIT 0,1";

	$spicy = $query_spicy;
	$spicy_results = $wpdb->get_results( $spicy, OBJECT);

	if ($spicy_results):
		global $post;
		$output .= "<div class='row'>";
		foreach ($spicy_results as $portfolios_post) :
			setup_postdata($portfolios_post);
			$output .= "<div class='small-12 columns'>
				<div>
					<a href='". post_permalink( $portfolios_post->ID ) ."' rel='bookmark'><h4>" . $portfolios_post->post_title . "</h4></a>
				</div>
				<div>
				<figure><a href='". post_permalink( $portfolios_post->ID ) ."' rel='bookmark'>". get_the_post_thumbnail($portfolios_post->ID, array(9999, 320)) ."</a></figure>
				<i>". get_post_meta( $portfolios_post->ID, 'vt_designation', true ) ."</i>
				</div>
			</div>";
			endforeach;
	endif;
		$output .= "</div>";

		return $output;
}
add_filter( "single_template", "get_vt_vtstaff_post_type_template" ) ;

	function staff_widget_display($args) {
		extract($args);
		echo $before_widget;
		echo $before_title . 'Staff Member' . $after_title;
		echo get_rendom_member();
		echo $after_widget;
	}

	wp_register_sidebar_widget(
	'staff_widget_1',
	'Staff Member Widget',
	'staff_widget_display',
	array( 
		'description' => 'This widget display randomly selected staff member details'
			)
	);
	
	wp_register_script( 'jquery_js',  plugins_url( 'assets/jquery.js', __FILE__ ));
	wp_enqueue_script('jquery_js');

	wp_register_style( 'vtstaffcss',  plugins_url( 'assets/staff.css', __FILE__ ));
	wp_enqueue_style('vtstaffcss');

	wp_register_style( 'foundation_min', plugins_url( 'assets/foundation-icons.css', __FILE__ ));
	wp_enqueue_style('foundation_min');
	

	wp_register_script( 'vtstaffjs',  plugins_url( 'assets/staff.js', __FILE__ ));
	wp_enqueue_script('vtstaffjs');
	
?>
