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
		'title' => 'Messages',
		'modal_class' => '',
	);
	$shortcode_atts = shortcode_atts($default, $atts);

	//QUERY CUSTOM POST TYPE POSTS
	$post_alert = new WP_Query( array(
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'post_type' 		  => 'alert-modal-mesp'
	) );

	if($post_alert->have_posts()){ ?>
		<style>
			#alertModalMesp{
				color:#303030 !important;				
			}
			#alertModalMesp .alertContainer{
				margin:10px auto;				
			}
			#alertModalMesp .alertTitle{
				text-align: left;				
			}			
			#alertModalMesp .alertDate{
				text-align: right;				
			}		
			#alertModalMesp .alertContent{
				text-align: justify;				
			}
		</style>

		<!-- Modal -->
		<div class="modal fade" id="alertModalMesp" tabindex="-1" aria-labelledby="alertModalMespLabel" aria-hidden="true">
			<div class="modal-dialog <?=$shortcode_atts['modal_class']?>">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="modal-title" id="alertModalMespLabel"><?=$shortcode_atts['title']?></h2>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
					
						<?php
						$count_alerts = 0;
						foreach( $post_alert->posts as $page ) {     

							if ( ! $page->post_content ) // Check for empty page
							continue;
					
							if ( $count_alerts > 0 ) 
							echo '<hr>';
							?>
							<div class='alertContainer'>
								<h3 class='alertTitle'>
									<?=$page->post_title?>
								</h3>
								<p class='alertContent'>
									<?=$page->post_content?>
								</p>
								<p class='alertDate'>
									<?=get_the_date( 'j F, Y', $page->ID  )?>
								</p>
							</div>
							
						<?php $count_alerts++;} ?>
			
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function() {	
				$('#alertModalMesp').modal('show');
			});
		</script>
	<?php } 
}
add_shortcode('alert_modal_mesp', 'alert_modal_mesp');