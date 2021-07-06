<?php
/*
Block Type: gutenberg
Block Title: Круговая диаграмма
Block Name: easy-piechart
Description:
Category: formatting
Icon:
Keywords:
Post Types:
Mode: preview
Align: 
Align Text:
Align Content:
Block Assets: morrisjs
Supports Align: false
Supports Align Text: false
Supports Align Content: false
Supports Mode: true
Supports Multiple: true
Supports JSX: false
Author:
Source:
*/
?>
<section class="morris-piechart__wrapper">
	<div class="morris-piechart__inner">
		<div class="morris-piechart__ratio">
			<div id="<?php echo $block['id'] ?>" class="morris-piechart__item"></div>			
		</div>
	</div>
</section>	


<?php
	$presets_colors = array(
		array('#F2C2C2', '#C4B9D1', '#A0BED9', '#F3DEDB', '#E8AAB3' ),
		array('#F27999', '#6A378C', '#AB8EBF', '#F2D479', '#F2F2F2' ),
		array('#E1D6A7', '#B1B297', '#91918E', '#3C4A60', '#A3A4B5' ),
		array('#F7D3B5', '#FCAD56', '#DF8402', '#AB4E04', '#753802' ),
		array('#CD6437', '#E67341', '#3C559B', '#324678', '#28375F' ),
	);

	$color_scheme = get_field('color_scheme'); 
	
	if ($color_scheme == 'custom') {
		$pie_colors = array();
		while (have_rows('piechart')): the_row();
			$pie_colors[] = get_sub_field('color');
		endwhile;
	} 
	
	else {
		$pie_colors = $presets_colors[$color_scheme];	
	}
?>

<script>
jQuery(document).ready(function() {
	
	function some_format(y, data) {
		return y + '%';
	}
	
	new Morris.Donut({
	  element: '<?php echo $block['id'] ?>',
	  data: [
	  	<?php while ( have_rows('piechart') ): the_row(); ?>
	    	{label: "<?php the_sub_field('label'); ?>", value: <?php the_sub_field('value'); ?>},
		<?php endwhile; ?>
	  ],
	  colors: [
	  	<?php foreach ($pie_colors as $color): ?>
	  		'<?php echo $color ?>',
	  	<?php endforeach; ?>
	  ],
	  formatter: some_format,
	  resize: true,
	});
});
</script>