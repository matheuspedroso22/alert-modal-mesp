<?php
/**
 * Plugin Name: Alert modal site
 * Plugin URI: https://github.com/matheuspedroso22
 * Description: Display modal with alert message (Bootstrap modal required). Use if(shortcode_exists('alert_modal_mesp')){ echo do_shortcode('[alert_modal_mesp title="CUSTOM_TITLE" modal_class="CUSTOM_CLASS"]'); } on page.
 * Version: 0.1
 * Text Domain: alert-modal-mesp
 * Author: Matheus Eduardo Souza
 * Author URI: https://github.com/matheuspedroso22
 */
function create_post_type_alert_modal_mesp() {

	// Register custom post type alert message
	register_post_type( 'alert-modal-mesp',
		array(
			'labels' => array(
			'name' => __( 'Alerts' ),
			'singular_name' => __( 'Alert' )
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 8,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'supports' => array( 'title', 'editor','author','thumbnail', 'custom-fields','comments' ),
			'taxonomies' => array( 'category', 'post_tag' )
		)  
	);
}
add_action( 'init', 'create_post_type_alert_modal_mesp' );

function alert_modal_mesp($atts) {

	$default = array(
		'title' => '',
		'modal_class' => '',
	);
	$shortcode_atts = shortcode_atts($default, $atts);

	//QUERY CUSTOM POST TYPE POSTS
	$post_alert = new WP_Query( array(
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'post_type' 		  => 'alert-modal-mesp'
	) );

	$my_plugin_dir = WP_PLUGIN_DIR . '/alert_modal_mesp';

	if($post_alert->have_posts() AND is_dir($my_plugin_dir)){ ?>

		<link rel='stylesheet' id='alert_modal_mesp-style-css' href='<?=plugins_url( 'alert_modal_mesp/assets/css/style.css', dirname(__FILE__) )?>' type='text/css' media='all' />
	
		<!-- The Modal -->
		<div id="alert-modal-mesp" class="modal">

			<!-- Modal content -->
			<div class="modal-content <?=$shortcode_atts['modal_class']?> flip-top">
				<span class="close" onclick="document.getElementById('alert-modal-mesp').style.display = 'none'">&times;</span>

				<?php if(!empty($shortcode_atts['title'])){ ?>
					<h2><?=$shortcode_atts['title']?></h2>
				<?php } ?>
				
				<?php
				$count_alerts = 0;
				foreach( $post_alert->posts as $page ) {     

					if ( ! $page->post_content ) // Check for empty page
					continue;
			
					if ( $count_alerts > 0 ) 
					echo '<hr>';
					?>
					<div class='alert-container'>
						<h2 class='alert-title'>
							<?=$page->post_title?>
						</h2>
						<div class='alert-content'>
							<?=$page->post_content?>
						</div>
						<div class='alert-date'>
							<?=get_the_date( 'j F, Y', $page->ID  )?>
						</div>
					</div>
					
				<?php $count_alerts++;} ?>

				<hr>

				<span class="close" onclick="document.getElementById('alert-modal-mesp').style.display = 'none'">Fechar</span>
				
			</div>

		</div>

		<script type='text/javascript' id='alert_modal_mesp-js' src='<?=plugins_url( 'alert_modal_mesp/assets/js/script.js', dirname(__FILE__) )?>' ></script>
	<?php } 
}
add_shortcode('alert_modal_mesp', 'alert_modal_mesp');
add_action('wp_footer', 'alert_modal_mesp');