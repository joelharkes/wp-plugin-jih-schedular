<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
get_header(); ?>

<?php // Get Theme Options from Database
$theme_options = dynamicnews_theme_options();
?>

<div id="wrap" class="container clearfix template-frontpage">
	<section id="content" class="primary" role="main">
		Mysection!!
	</section>

	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
