<?php 
/*
Plugin Name: Easy ACF Blocks for Gutenberg
Plugin URI: 
Version: 0.1
Description: This is a «starter plugin» use it for creation of new gutenberg blocks and then use blocks on any of your WordPress websites. Advanced Custom Fields PRO plugin needs to be installed.
Author: Nikolay Mironov
Author URI: https://wpfolio.ru
*/

define("SBL_PATH", plugin_dir_path( __FILE__ ));
define("SBL_URL", plugin_dir_url( __FILE__ ));
define("SBL_ASSETS_PATH", SBL_PATH . 'assets/');
define("SBL_ASSETS_URL", SBL_URL . 'assets/');
define("SBL_BLOCKS_DIR", "acf-blocks");
define("SBL_BLOCK_DEFAULTS", "defaults.json");
define("SBL_GROUP_NAME", "acf-group.json");

include_once SBL_PATH . '/inc/get-blocks.php';
include_once SBL_PATH . '/inc/assets.php';


add_action('acf/init', 'sbl_blocks_init');
add_action('acf/init', 'sbl_apply_groups_to_blocks');

function sbl_blocks_init() {
	//Die early if no ACF
	if( !function_exists('acf_register_block_type') ) return false;

	//Regestering PLUGIN'S blocks
	$acf_plugin_blocks = sbl_get_blocks(SBL_PATH, SBL_URL);
	if (is_array($acf_plugin_blocks)) {
		foreach ($acf_plugin_blocks as $block_params) {
			$block_params = sbl_prepare_block_params($block_params);	
			acf_register_block_type($block_params);	
		}
	}
}


function sbl_prepare_block_params($block_params) {
		$block_params['render_template']   = $block_params['path'] . '/' . $block_params['name'] . '.php';		

		//Enqueuing Scripts and styles for a block. According to exiting files and js/css dependencies
		$blocks_css_file_path = $block_params['path'] . '/' . $block_params['name'] . '.css';
		$blocks_css_file = $block_params['url'] . '/' . $block_params['name'] . '.css';
		$blocks_css_file_exists = file_exists($blocks_css_file_path);
		
		$blocks_js_file_path = $block_params['path'] . '/' . $block_params['name'] . '.js';	
		$blocks_js_file = $block_params['url'] . '/' . $block_params['name'] . '.js';	
		$blocks_js_file_exists = file_exists($blocks_js_file_path);
		
		//If no dependencies -> just enqueuing CSS & JS files	
		if ( $blocks_css_file_exists ) {
			$block_params['enqueue_style'] = $blocks_css_file;	
		}			
		
		if ( $blocks_js_file_exists ) {
			$block_params['enqueue_script'] = $blocks_js_file;	
		}
		
		if (!empty($block_params['assets'])) {
			$block_params['enqueue_assets'] = 'SBL_enqueue_assets_' . $block_params['assets'];
		}
		
		$block_params['example'] = array(
		    'attributes' => array(
		        'mode' => 'preview',
		        'data' => array(
		          'path' => $block_params['path'],
		          'url' => $block_params['url']
		        )
		    )
		);
		
		return $block_params;
}


function sbl_apply_groups_to_blocks() {
	$plugin_blocks = sbl_get_blocks(SBL_PATH, SBL_URL);
	if (!is_array($plugin_blocks)) $plugin_blocks = array();

	if (!is_array($plugin_blocks)) return false;
	
	foreach ($plugin_blocks as $block):
		$group_json = $block['path'] . '/' . SBL_GROUP_NAME;
		
		if ( file_exists($group_json) ) {
			$group_data = json_decode(file_get_contents($group_json),true);
			
			if ( $block['type'] == 'gutenberg' ) {
				//Creating new ACF fields group based on json file
				acf_add_local_field_group(array(
				'key' => 'group_' . $block['name'] . '_block',
				'title' => $block['title'],
				'fields' => $group_data[0]['fields'],
				'location' => array(
					array(
						array(
							'param' => 'block',
							'operator' => '==',
							'value' => 'acf/' . $block['name'],
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
				));
				
			} else {
				//Creating new ACF fields group with a repeater field as a wrapper for blocks fields			
				acf_add_local_field_group(array(
				'key' => 'group_' . $block['name'] . '_block',
				'title' => $block['title'],
				'fields' => array(
					array(
						'key' => 'field_' . $block['name'],
						'label' => '',
						'name' => $block['name'],
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 1,
						'max' => 1,
						'layout' => 'block',
						'button_label' => '',
						'sub_fields' => $group_data[0]['fields'],
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'block',
							'operator' => '==',
							'value' => 'acf/' . $block['name'],
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));
			}
			
		}
	 
	endforeach;
}








