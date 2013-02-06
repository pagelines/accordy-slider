<?php
/*
	Section: Accordy Slider
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://accordy.ahansson.com
	Version: 1.1
	Description: Accordy Slider is a fully responsive slider that supports up to 10 slides with your custom content or images.
	Class Name: PageLinesAccordySlider
	Workswith: main, templates
	Cloning: true
*/

/**
 * PageLines Accordion Slider
 *
 * @package PageLines Framework
 * @author Aleksander Hansson
 */



class PageLinesAccordySlider extends PageLinesSection {

	/*

function section_persistent(){

	add_filter( 'pless_vars', 'pl_counter_less');

	function pl_beefy_less( $constants ){

		$countdown_background_color = (ploption('countdown-background-color')) ? ploption('countdown-background-color') : '#1568AD';
		$countdown_label_color = (ploption('countdown-label-color')) ? ploption('countdown-label-color') : '#000000';
		$countdown_text_color = (ploption('countdown-text-color')) ? ploption('countdown-text-color') : '#ffffff';


		$newvars = array(

			'countdownbackgroundcolor' => $countdown_background_color ,
			'countdownlabelcolor' => $countdown_label_color ,
			'countdowntextcolor' => $countdown_text_color

		);

		$lessvars = array_merge($newvars, $constants);
		return $lessvars;
	}

}
*/

	var $default_limit = 2;

	function section_styles() {

		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'pl-accordion-slider-easing', $this->base_url.'/js/jquery.easing.1.3.js' );

		wp_enqueue_script( 'pl-accordion-slider', $this->base_url.'/js/liteaccordion.jquery.js' );


	}

	function section_head( $clone_id ) {

		$prefix = ( $clone_id != '' ) ? 'Clone_'.$clone_id : '';

?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('#accordionSlider<?php echo $prefix ?>').liteAccordion({
					onTriggerSlide : function() {
						this.find('figcaption').fadeOut();
					},
					onSlideAnimComplete : function() {
						this.find('figcaption').fadeIn();
					},
					autoPlay : true,
					pauseOnHover : true,
					<?php
						if ( ploption( 'accordion_slider_theme', $this->oset ) ) {
							printf( 'theme:"%s",', ploption( 'accordion_slider_theme', $this->oset ) );
						} else {
							printf( 'theme:"%s",', 'stitch' );
						}
					?>
					rounded : true,
					responsive: true,
					autoScaleImages : true,
				}).find('figcaption:first').show();
			})
		</script>

		<!--[if lt IE 9]>
            <script>
                document.createElement('figure');
                document.createElement('figcaption');
            </script>
        <![endif]-->
	<?php

	}

	function section_template( $clone_id ) {

		$prefix = ( $clone_id != '' ) ? 'Clone_'.$clone_id : '';

?>
	<div class="container">
		<div id="accordionSlider<?php echo $prefix ?>">
			<ol>
					<?php

		$slides = ( ploption( 'accordion_slider_slides', $this->oset ) ) ? ploption( 'accordion_slider_slides', $this->oset ) : $this->default_limit;

		$output = '';
		for ( $i = 1; $i <= $slides; $i++ ) {

			if ( ploption( 'accordion_slider_image_'.$i, $this->oset ) || ploption( 'accordion_slider_content_'.$i, $this->oset ) ) {

				$the_text = ploption( 'accordion_slider_text_'.$i, $this->tset );

				$the_name = ploption( 'accordion_slider_name_'.$i, $this->tset );

				$img_alt = ploption( 'accordion_slider_alt_'.$i, $this->tset );

				$text = ( $the_text ) ? sprintf( '<figcaption class="ap-caption">%s</figcaption>', $the_text ) : '';

				$name = ( $the_name ) ? sprintf( '<h2><span>%s</span></h2>', $the_name ) : '<h2><span><br/></span></h2>';

				$custom_content = ploption( 'accordion_slider_content_'.$i, $this->oset );

				if ( ploption( 'accordion_slider_image_'.$i, $this->oset ) ) {
					$img = sprintf( '<figure><img src="%s" alt="%s" />%s</figure>', ploption( 'accordion_slider_image_'.$i, $this->oset ), $img_alt, $text );
				} else {
					$img = '';
				}

				if ( ploption( 'accordion_slider_link_'.$i, $this->tset ) ) {
					$link = sprintf( '<figure><a href="%s"><img src="%s" alt="%s" /></a>%s</figure>', ploption( 'accordion_slider_link_'.$i, $this->tset ), ploption( 'accordion_slider_image_'.$i, $this->tset ), $img_alt, $text );
				} else {
					$link = '';
				}

				if ( $link ) {
					$content = $link;
				} elseif ( $img ) {
					$content = $img;
				} elseif ( $custom_content ) {
					$content = $custom_content;
				}

				$output .= sprintf( '<li>%s<div>%s</div></li>', $name, $content );
			}
		}

		if ( $output == '' ) {
			$this->do_defaults();
		} else {
			echo $output;
		}

?>
			</ol>
		</div>
	</div>
	<?php }

	function do_defaults() {

		printf( '<li><h2><span>%s</span></h2><div><figure><img src="%s" alt="%s" /><figcaption class="ap-caption">%s</figcaption></figure></div></li>',
			'Slide One',
			$this->base_url.'/img/1.png',
			'Image One',
			'Slide One'
		);
		printf( '<li><h2><span>%s</span></h2><div><figure><img src="%s" alt="%s" /><figcaption class="ap-caption">%s</figcaption></figure></div></li>',
			'Slide Two',
			$this->base_url.'/img/2.png',
			'Image Two',
			'Slide Two'
		);
		printf( '<li><h2><span>%s</span></h2><div><figure><img src="%s" alt="%s" /><figcaption class="ap-caption">%s</figcaption></figure></div></li>',
			'Slide Three',
			$this->base_url.'/img/3.png',
			'Image Three',
			'Slide Three'
		);
		printf( '<li><h2><span>%s</span></h2><div><figure><img src="%s" alt="%s" /><figcaption class="ap-caption">%s</figcaption></figure></div></li>',
			'Slide Four',
			$this->base_url.'/img/4.png',
			'Image Four',
			'Slide Four'
		);

	}

	function section_optionator( $settings ) {
		$settings = wp_parse_args( $settings, $this->optionator_default );

		$array = array();

		$array['accordion_slider_slides'] = array(
			'type'    => 'count_select',
			'count_start' => 2,
			'count_num'  => 30,
			'default'  => '2',
			'inputlabel'  => __( 'Number of Images to Configure', 'pagelines' ),
			'title'   => __( 'Number of images', 'pagelines' ),
			'shortexp'   => __( 'Enter the number of Accordion slides. <strong>Minimum is 2</strong>', 'pagelines' ),
			'exp'    => __( "This number will be used to generate slides and option setup. For responsive layouts, please select a low number and work your way up while testing. 10 is too many for most responsive sites.", 'pagelines' ),

		);

		$array['accordion_slider_theme'] = array(
			'inputlabel' => __( 'Slide Theme', 'pagelines' ),
			'type'   => 'select',
			'default'  => 'stitch',
			'selectvalues' => array(
				'stitch' => array( 'name'=> 'Stiches' ),
				'light' => array( 'name'=> 'Light' ),
				'dark' => array( 'name'=> 'Dark' ),
				'basic'  => array( 'name'=> 'Basic' )
			),
			'title'   => __( 'Choose theme for this slide', 'pagelines' ),
			'shortexp'   => __( 'You can choose from 4 different themes.', 'pagelines' ),
			'exp'    => __( "Select one of the themes from the list. If you want your own styling, please choose Basic and customize your the slider with custom CSS.", 'pagelines' ),

		);

		global $post_ID;

		$oset = array( 'post_id' => $post_ID, 'clone_id' => $settings['clone_id'], 'type' => $settings['type'] );

		$slides = ( ploption( 'accordion_slider_slides', $oset ) ) ? ploption( 'accordion_slider_slides', $oset ) : $this->default_limit;

		for ( $i = 1; $i <= $slides; $i++ ) {


			$array['accordion_slider_slide_'.$i] = array(
				'type'    => 'multi_option',
				'selectvalues' => array(

					'accordion_slider_name_'.$i  => array(
						'inputlabel'  => __( 'Slide Name', 'pagelines' ),
						'type'   => 'text'
					),
					'accordion_slider_image_'.$i  => array(
						'inputlabel'  => __( 'Slide Image', 'pagelines' ),
						'type'   => 'image_upload'
					),
					'accordion_slider_alt_'.$i  => array(
						'inputlabel' => __( 'Image ALT tag', 'pagelines' ),
						'type'   => 'text'
					),
					'accordion_slider_link_'.$i  => array(
						'inputlabel' => __( 'Slide Image Link', 'pagelines' ),
						'type'   => 'text'
					),
					'accordion_slider_text_'.$i  => array(
						'inputlabel' => __( 'Slide Image Text', 'pagelines' ),
						'type'   => 'text'
					),
					'accordion_slider_content_'.$i  => array(
						'inputlabel' => __( 'If you do not want an image, then add any HTML in this Custom Content field. If you have a link typed in the Slide Image Link field, then the HTML will not show.:', 'pagelines' ),
						'type'   => 'textarea',

					),
				),
				'title'   => __( 'Accordion Slide ', 'pagelines' ) . $i,
				'shortexp'   => __( 'Setup options for slide number ', 'pagelines' ) . $i,
				'exp'   => __( 'For best results all images in the slider should have the same dimensions.', 'pagelines' )
			);

		}

		$metatab_settings = array(
			'id'   => 'accordion_slider_options',
			'name'   => __( 'Accordy Slider', 'pagelines' ),
			'icon'   => $this->icon,
			'clone_id' => $settings['clone_id'],
			'active' => $settings['active']
		);

		register_metatab( $metatab_settings, $array );

	}

}
