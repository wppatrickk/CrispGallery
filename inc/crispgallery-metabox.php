<?php
/*
 * @author    Crisp Themes
 * @copyright Copyright (c) 2017, Crisp Themes, https://www.crispthemes.com
 * @license   http://en.wikipedia.org/wiki/MIT_License The MIT License
*/

add_action( 'add_meta_boxes', 'crispgallery_metabox' );

function crispgallery_metabox() {
    add_meta_box( 'crispgallery-shortcode', __( "Gallery Shortcode", 'crispgallery' ), 'crispgallery_cb', 'crispgallery', 'normal', 'high' );
    add_meta_box( 'crispgallery-settings', __( "Gallery Settings", 'crispgallery-grid' ), 'crispgallery_settings', 'crispgallery', 'normal', 'default' );
}

function crispgallery_cb($post) {
	$shortcode = get_post_meta($post->ID, 'crispgallery_shortcode', true);
	wp_nonce_field( 'crispgallery_nonce_set', 'crispgallery_nonce' ); ?>
    <input type="text" name="crispgallery_shortcode" id="crispgallery-shortcode" value="<?php echo htmlentities($shortcode);?>" style="width: 100%; max-width: 300px;" readonly /><br />
	<p>Use this shortcode wherever you want to display the gallery.</p>
    <?php    
}

function crispgallery_settings($post) {
	wp_nonce_field( 'crispgallery_nonce_set', 'crispgallery_nonce' );
	$crispgallery_cols = get_post_meta($post->ID, 'crispgallery_cols', true);
	$crispgallery_display = get_post_meta($post->ID, 'crispgallery_display', true);
	$crispgallery_border = get_post_meta($post->ID, 'crispgallery_border', true);
	$crispgallery_border_color = get_post_meta($post->ID, 'crispgallery_border_color', true);
	$crispgallery_font = get_post_meta($post->ID, 'crispgallery_caption_font', true);
	$crispgallery_fontsi = get_post_meta($post->ID, 'crispgallery_caption_font_size', true);
	$crispgallery_fontw = get_post_meta($post->ID, 'crispgallery_caption_font_weight', true);
	$crispgallery_fontst = get_post_meta($post->ID, 'crispgallery_caption_font_style', true);
	$crispgallery_fontc = get_post_meta($post->ID, 'crispgallery_caption_font_color', true); ?>

	<div id="crispgallery-settings">
		<div class="crispgallery-wrap">
			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'Gallery Columns', 'crispgallery' ); ?></span></legend>
				<label for="crispgallery_cols"><?php esc_attr_e( 'Gallery Columns', 'crispgallery' ); ?></label>
				<select name="crispgallery_cols" id="crispgallery-cols">
					<option value="2" <?php selected( $crispgallery_cols, '2' ); ?>>2</option>
					<option value="3" <?php selected( $crispgallery_cols, '3' ); ?> <?php if (!$crispgallery_cols) { echo "selected"; } ?>>3</option>
					<option value="4" <?php selected( $crispgallery_cols, '4' ); ?>>4</option>
					<option value="5" <?php selected( $crispgallery_cols, '5' ); ?>>5</option>
					<option value="6" <?php selected( $crispgallery_cols, '6' ); ?>>6</option>
				</select>
			</fieldset>

			<div class="crispgallery-display">
				<label>Display Type</label>
				<fieldset>
					<div class="crispgallery-display-wrap">
						<legend class="screen-reader-text"><span><?php esc_attr_e( 'Square', 'crispgallery' ); ?></span></legend>
						<label for="crispgallery-display">
							<input name="crispgallery_display" type="radio" value="square" <?php checked( $crispgallery_display, 'square' ); ?> <?php if (!$crispgallery_display) { ?>checked<?php } ?> />
							<span><?php esc_attr_e( 'Square', 'crispgallery' ); ?></span>
						</label>
					</div>

					<div class="crispgallery-display-wrap">
						<legend class="screen-reader-text"><span><?php esc_attr_e( 'Rectangle', 'crispgallery' ); ?></span></legend>
						<label for="crispgallery-display">
							<input name="crispgallery_display" type="radio" value="rectangle" <?php checked( $crispgallery_display, 'rectangle' ); ?> />
							<span><?php esc_attr_e( 'Rectangle', 'crispgallery' ); ?></span>
						</label>
					</div>

					<div class="clear"></div>
				</fieldset>

				<div class="clear"></div>
			</div>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'Show Border', 'crispgallery' ); ?></span></legend>
				<label for="crispgallery-border"><input type="checkbox" id="crispgallery-border" name="crispgallery_border" <?php checked( $crispgallery_border, 'on' ); ?>><?php esc_attr_e( 'Show Border', 'crispgallery' ); ?></label>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'Border Color', 'crispgallery' ); ?></span></legend>
				<label for="crispgallery-border-color"><?php esc_attr_e( 'Border Color', 'crispgallery' ); ?></label>
				<input type="text" name="crispgallery_border_color" id="crispgallery-border-color" class="crispgallery-color" value="<?php if ($crispgallery_border_color) { echo $crispgallery_border_color; } ?>" placeholder="#ccc" />
			</fieldset>

			<div class="crispgallery-caption-font">
				<h4>Caption Font</h4>
				<fieldset>
					<legend class="screen-reader-text"><span><?php esc_attr_e( 'Caption Font', 'crispgallery' ); ?></span></legend>
					<label for="crispgallery-caption-font"><?php esc_attr_e( 'Caption Font', 'crispgallery' ); ?></label>
					<select name="crispgallery_caption_font" id="crispgallery-caption-font">
						<option value="droid-sans" <?php selected( $crispgallery_font, 'droid-sans' ); ?>>Droid Sans</option>
						<option value="open-sans" <?php selected( $crispgallery_font, 'open-sans' ); ?> <?php if (!$crispgallery_font) { echo "selected"; } ?>>Open Sans</option>
						<option value="lato" <?php selected( $crispgallery_font, 'lato' ); ?>>Lato</option>
						<option value="raleway" <?php selected( $crispgallery_font, 'raleway' ); ?>>Raleway</option>
						<option value="roboto" <?php selected( $crispgallery_font, 'roboto' ); ?>>Roboto</option>
						<option value="ubuntu" <?php selected( $crispgallery_font, 'ubuntu' ); ?>>Ubuntu</option>
					</select>
				</fieldset>

				<fieldset>
					<legend class="screen-reader-text"><span><?php esc_attr_e( 'Caption Font Size', 'crispgallery' ); ?></span></legend>
					<label for="crispgallery-caption-font-size"><?php esc_attr_e( 'Caption Font Size', 'crispgallery' ); ?></label>
					<select name="crispgallery_caption_font_size" id="crispgallery-caption-font-size">
						<option value="12px" <?php selected( $crispgallery_fontsi, '12px' ); ?>>12px</option>
						<option value="13px" <?php selected( $crispgallery_fontsi, '13px' ); ?> <?php if (!$crispgallery_fontsi) { echo "selected"; } ?>>13px</option>
						<option value="14px" <?php selected( $crispgallery_fontsi, '14px' ); ?>>14px</option>
						<option value="15px" <?php selected( $crispgallery_fontsi, '15px' ); ?>>15px</option>
						<option value="16px" <?php selected( $crispgallery_fontsi, '16px' ); ?>>16px</option>
						<option value="17px" <?php selected( $crispgallery_fontsi, '17px' ); ?>>17px</option>
						<option value="18px" <?php selected( $crispgallery_fontsi, '18px' ); ?>>18px</option>
						<option value="19px" <?php selected( $crispgallery_fontsi, '19px' ); ?>>19px</option>
						<option value="20px" <?php selected( $crispgallery_fontsi, '20px' ); ?>>20px</option>
					</select>
				</fieldset>

				<fieldset>
					<legend class="screen-reader-text"><span><?php esc_attr_e( 'Caption Font Weight', 'crispgallery' ); ?></span></legend>
					<label for="crispgallery-caption-font-weight"><?php esc_attr_e( 'Caption Font Weight', 'crispgallery' ); ?></label>
					<select name="crispgallery_caption_font_weight" id="crispgallery-caption-font-weight">
						<option value="300" <?php selected( $crispgallery_fontw, '300' ); ?>>Light</option>
						<option value="400" <?php selected( $crispgallery_fontw, '400' ); ?> <?php if (!$crispgallery_fontw) { echo "selected"; } ?>>Normal</option>
						<option value="700" <?php selected( $crispgallery_fontw, '700' ); ?>>Bold</option>
					</select>
				</fieldset>

				<fieldset>
					<legend class="screen-reader-text"><span><?php esc_attr_e( 'Caption Font Style', 'crispgallery' ); ?></span></legend>
					<label for="crispgallery-caption-font-style"><?php esc_attr_e( 'Caption Font Style', 'crispgallery' ); ?></label>
					<select name="crispgallery_caption_font_style" id="crispgallery-caption-font-style">
						<option value="normal" <?php selected( $crispgallery_fontst, 'normal' ); ?> <?php if (!$crispgallery_fontst) { echo "selected"; } ?>>Normal</option>
						<option value="italic" <?php selected( $crispgallery_fontst, 'italics' ); ?>>Italics</option>
					</select>
				</fieldset>

				<fieldset>
					<legend class="screen-reader-text"><span><?php esc_attr_e( 'Caption Color', 'crispgallery' ); ?></span></legend>
					<label for="crispgallery-caption-font-color"><?php esc_attr_e( 'Caption Color', 'crispgallery' ); ?></label>
					<input type="text" name="crispgallery_caption_font_color" id="crispgallery-caption-font-color" class="crispgallery-color" value="<?php if ($crispgallery_fontc) { echo $crispgallery_fontc; } ?>" placeholder="#fff" />
				</fieldset>

				<input type="submit" id="crispgallery-update" value="Update" />
			</div>
		</div>

		<div class="crispgallery-ads-section">
			<div class="crispgallery-ad-section">
				<a href="https://www.crispthemes.com/" target="_blank"><img src="<?php echo CRISPGALLERY_URL; ?>/css/images/crisp_theme_logo.jpg" /></a>
			</div>

			<div class="crispgallery-ad-section">
				<a href="https://www.crispthemes.com/support/forum/plugins/crispgallery/" target="_blank"><img src="<?php echo CRISPGALLERY_URL; ?>/css/images/plugin-support.png" /></a>
			</div>

			<div class="crispgallery-ad-section">
				<a href="https://www.crispthemes.com/plugins/" target="_blank"><img src="<?php echo CRISPGALLERY_URL; ?>/css/images/plugin-banner.png" /></a>
			</div>

			<div class="crispgallery-ad-section">
				<a href="https://www.crispthemes.com/themes/" target="_blank"><img src="<?php echo CRISPGALLERY_URL; ?>/css/images/theme-banner.png" /></a>
			</div>
		</div>

		<div class="clear"></div>
	</div>
<?php }

add_action('save_post', 'crispgallery_save_gallery');

function crispgallery_save_gallery($post_id){
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    if( !isset( $_POST['crispgallery_nonce'] ) || !wp_verify_nonce( $_POST['crispgallery_nonce'], 'crispgallery_nonce_set' ) ) return;
     
    if( !current_user_can( 'edit_post', $post_id ) ) return;

	if(isset($_POST['post_type']) && ($_POST['post_type'] == "crispgallery")) {
        $shortcode = get_post_meta($post_id, 'crispgallery_shortcode', true);
		if (!$shortcode) {
			update_post_meta( $post_id, 'crispgallery_shortcode', '[crispgallery id="' . $post_id . '"]' );
		}

		if( $_POST['crispgallery_cols'] ) {
			update_post_meta( $post_id, 'crispgallery_cols', esc_attr( $_POST['crispgallery_cols'] ) );
		}

		update_post_meta( $post_id, 'crispgallery_display', $_POST['crispgallery_display'] );

		$crispgallery_border = isset( $_POST['crispgallery_border'] ) && $_POST['crispgallery_border'] ? 'on' : 'off';
		update_post_meta( $post_id, 'crispgallery_border', $crispgallery_border );

		if( $_POST['crispgallery_border_color'] ) {
			update_post_meta( $post_id, 'crispgallery_border_color', esc_attr( $_POST['crispgallery_border_color'] ) );
		}

		if( $_POST['crispgallery_caption_font'] ) {
			update_post_meta( $post_id, 'crispgallery_caption_font', esc_attr( $_POST['crispgallery_caption_font'] ) );
		}

		if( $_POST['crispgallery_caption_font_size'] ) {
			update_post_meta( $post_id, 'crispgallery_caption_font_size', esc_attr( $_POST['crispgallery_caption_font_size'] ) );
		}

		if( $_POST['crispgallery_caption_font_weight'] ) {
			update_post_meta( $post_id, 'crispgallery_caption_font_weight', esc_attr( $_POST['crispgallery_caption_font_weight'] ) );
		}

		if( $_POST['crispgallery_caption_font_style'] ) {
			update_post_meta( $post_id, 'crispgallery_caption_font_style', esc_attr( $_POST['crispgallery_caption_font_style'] ) );
		}

		if( $_POST['crispgallery_caption_font_color'] ) {
			update_post_meta( $post_id, 'crispgallery_caption_font_color', esc_attr( $_POST['crispgallery_caption_font_color'] ) );
		}
	}
}
?>