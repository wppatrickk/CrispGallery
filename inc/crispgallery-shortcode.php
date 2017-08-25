<?php
/*
 * @author    Crisp Themes
 * @copyright Copyright (c) 2017, Crisp Themes, https://www.crispthemes.com
 * @license   http://en.wikipedia.org/wiki/MIT_License The MIT License
*/

function crispgallery_shortcode($atts) {  
	ob_start();
	
	extract( shortcode_atts( array(
        'p' => '',
    ), $atts ) );

	$postid = $atts['id'];

	$crispgallery_cols = get_post_meta($postid, 'crispgallery_cols', true);
	$crispgallery_caption_font = get_post_meta($postid, 'crispgallery_caption_font', true);
	
	if (!$crispgallery_cols) {
		$crispgallery_cols = 4;
	}

	if ($crispgallery_caption_font == 'droid-sans') {
		wp_enqueue_style( 'crispgallery-droid', 'https://fonts.googleapis.com/css?family=Droid+Sans:400,700' );
		$crispgallery_caption_font = 'Droid Sans, sans-serif';
	} elseif ($crispgallery_caption_font == 'open-sans') {
		wp_enqueue_style( 'crispgallery-open', 'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i' );
		$crispgallery_caption_font = 'Open Sans, sans-serif';
	} elseif ($crispgallery_caption_font == 'lato') {
		wp_enqueue_style( 'crispgallery-lato', 'https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i' );
		$crispgallery_caption_font = 'Lato, sans-serif';
	} elseif ($crispgallery_caption_font == 'raleway') {
		wp_enqueue_style( 'crispgallery-raleway', 'https://fonts.googleapis.com/css?family=Raleway:300,300i,400,400i,700,700i' );
		$crispgallery_caption_font = 'Raleway, sans-serif';
	} elseif ($crispgallery_caption_font == 'roboto') {
		wp_enqueue_style( 'crispgallery-raleway', 'https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i' );
		$crispgallery_caption_font = 'Roboto, sans-serif';
	} elseif ($crispgallery_caption_font == 'ubuntu') {
		wp_enqueue_style( 'crispgallery-ubuntu', 'https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,700,700i' );
		$crispgallery_caption_font = 'Ubuntu, sans-serif';
	} elseif (!$crispgallery_caption_font) {
		wp_enqueue_style( 'crispgallery-open', 'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i' );
	}

	wp_enqueue_style( 'crispgallery-lightbox' );
	wp_enqueue_style( 'crispgallery-style' );
	wp_enqueue_script( 'crispgallery-lightbox' );
	wp_enqueue_script( 'crispgallery-script' );

	$args = array('post_type' => 'crispgallery', 'p' => $postid, 'posts_per_page' => -1);
	$gallery_posts = new WP_Query($args);

   	if($gallery_posts->have_posts()) :
   		while($gallery_posts->have_posts()) : 
	   		$gallery_posts->the_post();
	   		$ids = get_post_meta($postid, 'vdw_gallery_id', true);
	   		$crispgallery_display = get_post_meta(get_the_ID(), 'crispgallery_display', true);
			if (!$crispgallery_display) {
				$crispgallery_display = 'square';
			} ?>
			<div id="crispgallery-<?php echo $postid; ?>" class="crispgallery <?php echo $crispgallery_display; ?>">
				<?php
				$crispgallery_border = get_post_meta(get_the_ID(), 'crispgallery_border', true);
				$crispgallery_border_color = get_post_meta(get_the_ID(), 'crispgallery_border_color', true);
				$crispgallery_caption_fsize = get_post_meta(get_the_ID(), 'crispgallery_caption_font_size', true);
				$crispgallery_caption_fontw = get_post_meta(get_the_ID(), 'crispgallery_caption_font_weight', true);
				$crispgallery_caption_fst = get_post_meta(get_the_ID(), 'crispgallery_caption_font_style', true);
				$crispgallery_caption_fc = get_post_meta(get_the_ID(), 'crispgallery_caption_font_color', true); ?>
				<style type="text/css">
					body #crispgallery-<?php echo $postid; ?> ul li p, body #crispgallery-<?php echo $postid; ?> ul li p:last-child {
						font-family: <?php echo $crispgallery_caption_font; ?>;
						font-size: <?php echo $crispgallery_caption_fsize; ?>;
						font-style: <?php echo $crispgallery_caption_fst; ?>;
						font-weight: <?php echo $crispgallery_caption_fontw; ?>;
						color: <?php echo $crispgallery_caption_fc; ?>;
					}

					<?php if ($crispgallery_border_color) { ?>
					body #crispgallery-<?php echo $postid; ?> .crispgallery-border a {
						border-color: <?php echo $crispgallery_border_color; ?>;
					}
					<?php } ?>
				</style>
				<ul class="crispgallery-cols-<?php echo $crispgallery_cols; ?> <?php if ($crispgallery_border) { echo 'crispgallery-border'; } ?>">
					<?php if ($ids) :
						foreach ($ids as $key => $value) :
							$image = wp_get_attachment_image_src($value, 'full');
							$thumb = wp_get_attachment_image_src($value, 'large'); ?>
							<li>
								<?php $caption = get_post_field('post_excerpt', $value); ?>
								<a data-lightbox="gallery-<?php echo get_the_ID(); ?>" href="<?php echo $image[0]; ?>" title="<?php echo $caption; ?>">
									<span class="crispgallery-image" style="background-image: url(<?php echo $thumb[0]; ?>);">
									</span>
									<?php if ($caption) { ?>
										<p><?php echo $caption; ?></p>
									<?php } ?>
								</a>
							</li>
						<?php endforeach;
					endif; ?>
				</ul>
			</div>
		<?php endwhile;
	endif;
	wp_reset_query();
	$crispgallery = ob_get_clean();
	return $crispgallery;
}  

add_shortcode('crispgallery', 'crispgallery_shortcode');
?>