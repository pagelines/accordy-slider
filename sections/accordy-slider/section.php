<?php
/*
	Section: Accordy Slider
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Description: Accordy Slider is a fully responsive slider that supports up to 10 slides with your custom content or images.
	Class Name: AccordySlider
	Cloning: true
	V3: true
	Filter: slider
*/

class AccordySlider extends PageLinesSection {

	var $default_limit = 2;

	function section_styles() {

		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'jquery-easing', $this->base_url.'/js/jquery.easing.1.3.js' );

		wp_enqueue_script( 'pl-accordion-slider', $this->base_url.'/js/liteaccordion.jquery.js' );

	}

	function section_head() {

		$clone_id = $this->get_the_id();

		$prefix = ( $clone_id != '' ) ? 'Clone_'.$clone_id : '';

		$speed = $this->opt('accordion_slider_speed' ) ? $this->opt('accordion_slider_speed' )  : '800';

		?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('#accordionSlider<?php echo $prefix ?>').liteAccordion({
						onTriggerSlide : function() {
							this.find('figcaption').fadeOut();
						},
						onSlideAnimComplete : function() {
							this.find('figcaption').fadeIn();
						},
						autoPlay : true,
						pauseOnHover : true,
						<?php
							if ( $this->opt( 'accordion_slider_theme'  ) ) {
								printf( 'theme:"%s",', $this->opt( 'accordion_slider_theme'  ) );
							} else {
								printf( 'theme:"%s",', 'stitch' );
							}
						?>
						rounded : true,
						responsive: true,
						slideSpeed : <?php echo $speed; ?>,
						autoScaleImages : false,                // if a single image is placed within the slide, this will be automatically scaled to fit


					}).find('figcaption:first').show();
				});
			</script>

			<!--[if lt IE 9]>
	            <script>
	                document.createElement('figure');
	                document.createElement('figcaption');
	            </script>
	        <![endif]-->

		<?php

	}

	function section_template() {

		$clone_id = $this->get_the_id();

		$prefix = ( $clone_id != '' ) ? 'Clone_'.$clone_id : '';

		// The boxes
		$accordion_slider_array = $this->opt('accordion_slider_array');

		$format_upgrade_mapping = array(
			'name'	=> 'accordion_slider_name_%s',
			'image'	=> 'accordion_slider_image_%s',
			'alt'	=> 'accordion_slider_alt_%s',
			'link'	=> 'accordion_slider_link_%s',
			'text'	=> 'accordion_slider_text_',
			'content'	=> 'accordion_slider_content_%s'
		);

		$accordion_slider_array = $this->upgrade_to_array_format( 'accordion_slider_array', $accordion_slider_array, $format_upgrade_mapping, $this->opt('accordion_slider_slides'));

		// must come after upgrade
		if( !$accordion_slider_array || $accordion_slider_array == 'false' || !is_array($accordion_slider_array) ){
			$accordion_slider_array = array( array(), array(), array(), array() );
		}

		?>
			<div class="container">
				<div id="accordionSlider<?php echo $prefix ?>">
					<ol>
						<?php

							if( is_array($accordion_slider_array) ){

								$slides = count( $accordion_slider_array );

								foreach( $accordion_slider_array as $slide ){

									if ( pl_array_get( 'image', $slide) || pl_array_get( 'content', $slide) ) {

										$the_text = pl_array_get( 'text', $slide);

										$the_name = pl_array_get( 'name', $slide);

										$alt = pl_array_get( 'alt', $slide);

										$text = ( $the_text ) ? sprintf( '<figcaption class="ap-caption">%s</figcaption>', $the_text ) : '';

										$name = ( $the_name ) ? sprintf( '<h2><span>%s</span></h2>', $the_name ) : '<h2><span><br/></span></h2>';

										$custom_content = pl_array_get( 'content', $slide);

										if ( $this->opt( 'accordion_slider_image_'.$i  ) ) {
											$img = sprintf( '<figure><img src="%s" alt="%s" />%s</figure>', pl_array_get( 'image', $slide), $img_alt, $text );
										} else {
											$img = '';
										}

										if ( pl_array_get( 'link', $slide ) ) {
											$link = sprintf( '<a href="%s"><figure><img src="%s" alt="%s" />%s</figure></a>', pl_array_get( 'link', $slide), pl_array_get( 'image', $slide, ''), $img_alt, $text );
										} else {
											$link = '';
										}

										if ( $link ) {
											$content = $link;
										} elseif ( $img ) {
											$content = $img;
										} elseif ( $custom_content ) {
											$content = do_shortcode( $custom_content );
										}

										$output .= sprintf( '<li>%s<div>%s</div></li>', $name, $content );
									}
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
		<?php

	}

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


		function section_opts() {

		$options = array();

		$how_to_use = __( '
		<strong>Read the instructions below before asking for additional help:</strong>
		</br></br>
		<strong>1.</strong> In Drag&Drop, drag the Accordy Slider section to a template of your choice.
		</br></br>
		<strong>2.</strong> Edit settings.
		</br></br>
		<strong>3.</strong> Setup each slide.
		</br></br>
		<strong>4.</strong> Hit "Publish" to see changes.
		</br></br>
		<div class="row zmb">
				<div class="span6 tac zmb">
					<a class="btn btn-info" href="http://forum.accordy-slider.com/71-products-by-aleksander-hansson/" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-ambulance"></i>          Forum</a>
				</div>
				<div class="span6 tac zmb">
					<a class="btn btn-info" href="http://betterdms.com" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-align-justify"></i>          Better DMS</a>
				</div>
			</div>
			<div class="row zmb" style="margin-top:4px;">
				<div class="span12 tac zmb">
					<a class="btn btn-success" href="http://shop.ahansson.com" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-shopping-cart" ></i>          My Shop</a>
				</div>
			</div>
		', 'accordy-slider' );

		$options[] = array(
			'key' => 'accordion_slider_help',
			'type'     => 'template',
			'template'      => do_shortcode( $how_to_use ),
			'title' =>__( 'How to use:', 'accordy-slider' ) ,
		);

		$options[] = array(

			'key'	=>	'accordion_slider_slide_',
			'type'  => 	'multi',
			'title' => __( 'Settings', 'accordy-slider' ),
			'opts' => array(

				array(
					'key'	=>	'accordion_slider_theme',
					'label' => __( 'Slide Theme', 'accordy-slider' ),
					'type'   => 'select',
					'default'  => 'stitch',
					'opts' => array(
						'stitch' => array( 'name'=> 'Stiches' ),
						'light' => array( 'name'=> 'Light' ),
						'dark' => array( 'name'=> 'Dark' ),
						'basic'  => array( 'name'=> 'Basic' )
					),
					'title'   => __( 'Choose theme for this slide', 'accordy-slider' ),
					'help'   => __( 'You can choose from 4 different themes.', 'accordy-slider' ),

				),
				array(
					'key'	=>	'accordion_slider_speed',
					'label' => __( 'Slide speed in ms', 'accordy-slider' ),
					'type'  => 'text',
					'default' => '800',
					'title' => __( 'Slide speed', 'accordy-slider' ),
					'help'  => __( 'Enter slide speed in ms (default is 800)', 'accordy-slider' )
				),
			),
		);

		$options[] = array(
			'key'		=> 'accordion_slider_array',
	    	'type'		=> 'accordion',
			'title'		=> __('Slides Setup', 'accordy-slider'),
			'post_type'	=> __('Slide', 'accordy-slider'),
			'opts'		=> array(
				array(
					'key'	=> 'name',
					'label' => __( 'Slide Name', 'accordy-slider' ),
					'type'  => 'text'
				),
				array(
					'key'	=>'image',
					'label' => __( 'Slide Image', 'accordy-slider' ),
					'type'  => 'image_upload'
				),
				array(
					'key'	=>'alt',
					'label' => __( 'Image ALT tag', 'accordy-slider' ),
					'type'  => 'text'
				),
				array(
					'key'	=>'link',
					'label' => __( 'Slide Image Link', 'accordy-slider' ),
					'type'  => 'text'
				),
				array(
					'key'	=>'text',
					'label' => __( 'Slide Image Text', 'accordy-slider' ),
					'type'  => 'text'
				),
				array(
					'key'	=>'content',
					'label' => __( 'If you do not want an image, then add any HTML in this Custom Content field. If you have a link typed in the Slide Image Link field, then the HTML will not show.:', 'accordy-slider' ),
					'type'  => 'textarea',
				),

			)
	    );

		return $options;

	}

}
