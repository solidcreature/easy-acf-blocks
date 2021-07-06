<?php
/*
Block Type: gutenberg
Block Title: Easy Access
Block Name: easy-access
Description:
Category: formatting
Icon:
Keywords:
Post Types:
Mode: preview
Align: 
Align Content:
CSS Assets:
JS Assets:
Supports Align: false
Supports Align Text: false
Supports Align Content: false
Supports Mode: true
Supports Multiple: true
Supports JSX: false
*/
?>

<?php
	$key = get_field('key');
	$value = get_field('value');

	if ( !isset($_GET[$key]) ) $access = false;
	if ( $_GET[$key] != $value ) $access = false;
	if ( ($_GET[$key] == $value) and !empty($value) ) $access = true;
?>

<?php if ($access or current_user_can('manage_options')): ?>	

	<section class="easy-access__wrapper">	
		<div class="easy-access__inner">

			<?php the_field('easy_content'); ?>
			
			<?php if (get_field('easy_download')): ?>
				<a class="easy-access__download" rel="download" href="<?php the_field('easy_download'); ?>"><?php the_field('easy_label'); ?></a>
			<?php endif; ?>	
			
		</div>
	</section>	
	
<?php endif; ?>	