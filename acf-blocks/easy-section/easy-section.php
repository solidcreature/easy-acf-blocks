<?php
/*
Block Type: gutenberg
Block Title: Секция
Block Name: easy-section
Description:
Category: formatting
Icon:
Keywords:
Post Types:
Mode: preview
Align: wide
Align Text:
Align Content:
Block Assets: 
Supports Align: full, wide
Supports Align Text: false
Supports Align Content: true
Supports Mode: true
Supports Multiple: true
Supports JSX: true
Author:
Source:
*/
?>

<?php
	//Section ID
	$section_id = $block['id'];
	if ( get_field('section_id') ) $section_id = get_field('section_id');

	//Content Width and vAlign
	$content_maxwidth = get_field('content_width');
	$content_width = $block['align'];
	$content_valign = $block['align_content'];
	
	//Section Height
	$section_height = get_field('section_height');

	//Background Overlay
	$has_overlay = '';
	if ( get_field('overlay_color') ) $has_overlay = " has--overlay";

	//Section Classes
	$section_classes ="height--" . $section_height . " width--" . $content_width . " valign--" . $content_valign . $has_overlay; 

	//Section Style
	$section_style = '';
	
	//Section Color
	if ( get_field('section_color') ) $section_style .= 'color: ' . get_field('section_color') . '; ';
	
	//Section background
	if ( get_field('background_image') ) $section_style .= 'background-image: url(' . get_field('background_image') . '); ';
	if ( get_field('background_size') ) $section_style .= 'background-size: ' . get_field('background_size') . '; ';
	if ( get_field('background_position') ) $section_style .= 'background-position: ' . get_field('background_position') . '; ';
	if ( get_field('background_size') ) $section_style .= 'background-size: ' . get_field('background_size') . '; ';
	if ( get_field('background_repeat') ) $section_style .= 'background-repeat: ' . get_field('background_repeat') . '; ';
	if ( get_field('background_color') ) $section_style .= 'background-color: ' . get_field('background_color') . '; ';
	if ( get_field('background_fix') ) $section_style .= 'background-attachment: fixed; ';
	
	//section width
	if ( get_field('content_width') ) $section_style .= '--content-width: ' . $content_maxwidth . 'px; ';
	
	//section height
	if ( get_field('section_height') != 'auto' ) {
		$section_style .= 'display: flex; ';
		$section_style .= 'box-sizing: border-box; ';
	}	
	if ( get_field('section_height') == 'fullscreen' ) $section_style .= 'min-height: 100vh; ';
	if ( get_field('section_height') == 'proportions' ) $section_style .= 'min-height: ' . get_field('section_vw') . 'vw; ';
	if ( get_field('section_height') == 'fixed' ) $section_style .= 'min-height: ' . get_field('section_px') . 'px; ';	
	
	if ( get_field('section_valign') == 'center' ) $section_style .= 'align-items: center; ';
	if ( get_field('section_valign') == 'bottom' ) $section_style .= 'align-items: flex-end; ';
	
	//section paddings
	if ( get_field('padding_top_px') ) $section_style .= 'padding-top: ' . get_field('padding_top_px') . 'px; ';
	if ( get_field('padding_bottom_px') ) $section_style .= 'padding-bottom: ' . get_field('padding_bottom_px') . 'px; ';

	//section style
	$section_style .= get_field('section_style');
?>

<?php if ( get_field('overlay_color') ): ?>
	<style>
		#<?php echo $section_id; ?>.has--overlay:before {
	
			<?php if ( get_field('overlay_color_2') ): 
				//Color 1
				$color1 = get_field('overlay_color');
				$opacity1 = get_field('overlay_opacity'); 
				
				$hex_color = str_replace('#','',$color1);
				$split_hex_color = str_split( $hex_color, 2 ); 	
				$red = hexdec( $split_hex_color[0] ); 	
				$green = hexdec( $split_hex_color[1] ); 	
				$blue = hexdec( $split_hex_color[2] ); 
	
				$gradient_from = 'rgba(' . $red . ', ' . $green . ', ' . $blue . ', ' . $opacity1 . ')';

				//Color 2
				$color2 = get_field('overlay_color_2'); 
				$opacity2 = get_field('overlay_opacity_2'); 
				
				$hex_color = str_replace('#','',$color2);
				$split_hex_color = str_split( $hex_color, 2 ); 	
				$red = hexdec( $split_hex_color[0] ); 	
				$green = hexdec( $split_hex_color[1] ); 	
				$blue = hexdec( $split_hex_color[2] );
				
				$gradient_to = 'rgba(' . $red . ', ' . $green . ', ' . $blue . ', ' . $opacity2 . ')';
				
				$overlay_angle = get_field('overlay_angle'); 
				if (!$overlay_angle) $overlay_angle = 180; 
				
				echo 'background: linear-gradient(' . $overlay_angle . 'deg, ' . $gradient_from . ' 0%,' . $gradient_to . '100%); ';
				echo 'opacity: 1;'
			?>
			<?php else: ?>
				background-color: <?php the_field('overlay_color'); ?>;
				opacity: <?php the_field('overlay_opacity'); ?>;
			<?php endif; ?>
			
			background-blend-mode: <?php the_field('overlay_mode'); ?>;
		} 
	</style>
<?php endif; ?>

<section id="<?php echo $section_id; ?>" class="easy-section <?php echo $section_classes; ?>" style="<?php echo $section_style; ?>">
	<div class="easy-section__inner">
		<InnerBlocks />	
	</div>
</section>	