<?php

/**
 	* Creates a fullscreen chapter heading
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_chapter_shortcode')){

	function aesop_chapter_shortcode($atts, $content = null) {
		$defaults = array(
			'label'	=> '',
			'title' => '',
			'subtitle' => '',
			'bgtype' => 'img',
			'img' => ''
		);

		$atts = shortcode_atts($defaults, $atts);
		$hash = rand();

		ob_start();

		do_action('aesop_chapter_component_before'); //action

			if ('video' == $atts['bgtype']) { ?>

				<section id="chapter-hash-<?php echo $hash;?>" class="aesop-article-chapter-wrap default-cover aesop-video-chapter aesop-component" >

					<?php do_action('aesop_chapter_component_inside_top'); //action ?>

					<div class="aesop-article-chapter clearfix" style="height:auto;">
						<span class="aesop-chapter-title"><?php echo $atts['label'];?></span>
						<h2 class="aesop-cover-title" itemprop="title" >
							<?php echo $atts['title'];

							if ($atts['subtitle']) { ?>
								<small><?php echo $atts['subtitle'];?></small>
							<?php } ?>
						</h2>
						<div class="video-container">
							<?php echo do_shortcode('[video src="'.$atts['img'].'" loop="on" autoplay="on"]'); ?>
						</div>
					</div>

					<?php do_action('aesop_chapter_component_inside_bottom'); //action ?>

				</section>

			<?php } else { ?>

				<section id="chapter-hash-<?php echo $hash;?>" class="aesop-article-chapter-wrap default-cover aesop-component">

					<?php do_action('aesop_chapter_component_inside_top'); //action ?>

					<div class="aesop-article-chapter clearfix" style="background:url('<?php echo $atts['img'];?>') center center;background-size:cover;">
						<span class="aesop-chapter-title"><?php echo $atts['label'];?></span>
						<h2 class="aesop-cover-title" itemprop="title" >
							<?php echo $atts['title'];
							if ($atts['subtitle']) { ?>
								<small><?php echo $atts['subtitle'];?></small>
							<?php } ?>
						</h2>
					</div>

					<?php do_action('aesop_chapter_component_inside_bottom'); //action ?>

				</section>

			<?php }

		do_action('aesop_chapter_component_after'); //action

		return ob_get_clean();
	}
}

if (!function_exists('aesop_chapter_heading_loader')){

	add_action('wp','aesop_chapter_heading_loader');
	function aesop_chapter_heading_loader() {

		global $post;

		if( isset($post) && is_single() && has_shortcode( $post->post_content, 'aesop_chapter') )  {

			new AesopChapterHeadingComponent;

		}
	}

}

// @TODO - this needs to be moved to theme level because not all will use the offset and setup here
class AesopChapterHeadingComponent {

	function __construct(){
		add_action('wp_footer', array($this,'aesop_chapter_loader'),21);
	}

	function aesop_chapter_loader(){

		?>
			<!-- Chapter Loader -->
			<script>
				jQuery(document).ready(function(){

					jQuery('.aesop-entry-content').scrollNav({
					    sections: '.aesop-chapter-title',
					    arrowKeys: true,
					    insertTarget: '.aesop-story-header',
					    insertLocation: 'appendTo',
					    showTopLink: true,
					    showHeadline: false,
					    scrollOffset: 36,
					});

				});
			</script>

		<?php
	}
}





