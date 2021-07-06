<?php

//Returns array with Blocks information, based on specific sub-folders and file data 
function sbl_get_blocks($blocks_dir_path, $blocks_dir_url) {

	if (!is_dir($blocks_dir_path . SBL_BLOCKS_DIR)) return false;

	//Getting Blocks by checking all sub-folders in blocks directory
	$dir = new DirectoryIterator( $blocks_dir_path . SBL_BLOCKS_DIR );
	
	$block_names = array();
	
	foreach ($dir as $fileinfo) {
	    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
	        $block_names[] = $fileinfo->getFilename();
	    }
	}

	$default_path = $blocks_dir_path . SBL_BLOCKS_DIR;
	$default_url = $blocks_dir_url . SBL_BLOCKS_DIR;
	
	$acf_blocks = array();

	//Getting Blocks params from file data
	foreach ($block_names as $block_name) {
		
		$block_full_path = $default_path . '/' . $block_name . '/' . $block_name . '.php';
		$block_path = $default_path . '/' . $block_name;
		$block_url = $default_url . '/' . $block_name;
		
		$block_params = get_file_data( 
			$block_full_path, 
			array(
				'type' => 'Block Type',
				'title' => 'Block Title',
				'name' => 'Block Name',
				'description' => 'Description',
				'category' => 'Category',
				'icon' => 'Icon',
				'keywords' => 'Keywords',
				'post_types' => 'Post Types',
				'mode' => 'Mode',
				'align' => 'Align',
				'align_text' => 'Align Text',
				'align_content' => 'Align Content',
				'assets' => 'Block Assets',
			)	
		);
		
		//Adding URL and Path params to blocks Array
		$block_params['path'] = $block_path;
		$block_params['url'] = $block_url;
		
		//Updating params, that should be transformed to arrays if has more then 1 value
		$string_to_array_params = array('keywords', 'post_types');
		
		foreach($string_to_array_params as $param) {
			$string = $block_params[$param];
			
			//small exeption for Keywords, because spaces are not crucial there
			if ($param != 'keywords') $string = str_replace(' ','', $string);
			
			if ($string) $block_params[$param] = explode(',',$string);
		}
		
		$block_supports_raw = get_file_data( 
			$block_full_path, 
			array(
				'supports_align' => 'Supports Align',
				'supports_align_text' => 'Supports Align Text',
				'supports_align_content' => 'Supports Align Content',
				'supports_mode' => 'Supports Mode',
				'supports_multiple' => 'Supports Multiple',
				'supports_jsx' => 'Supports JSX',
			)	
		);	

		$align = $block_supports_raw['supports_align'];
		if ($align == 'false') { $align = false; } else { 
			if (!empty($align)) {
				$align = str_replace(' ', '', $align); 
				$align = explode(',',$align); 
			} 
		}
		
		$align_text = trim($block_supports_raw['supports_align_text']);
		if ($align_text == 'false') { $align_text = false; } else { $align_text = 35; } 
		
		$align_content = $block_supports_raw['supports_align_content'];
		if ($align_content == 'false') { $align_content = false; } else { $align_content = true; } 
		
		$mode = $block_supports_raw['supports_mode'];
		if ($mode == 'false') { $mode = false; } else { $mode = true; }
		
		$multiple = $block_supports_raw['supports_multiple'];
		if ($multiple == 'false') { $multiple = false; } else { $multiple = true; }
		
		$jsx = $block_supports_raw['supports_jsx'];
		if ($jsx == 'false') { $jsx = false; } else { $jsx = true; }
		
		$block_supports = array(
			'align' => $align,
			'align_text' => $align_text,
			'align_content' => $align_content,
			'mode' => $mode,
			'multiple' => $multiple,
			'jsx' => $jsx
		);

		$block_params['supports'] = $block_supports;
		
			
		
		if ($block_params['name'] and $block_params['title'] and $block_params['category']) {
			$acf_blocks[] = $block_params;
		}
	}

	
	
	return $acf_blocks;
}



