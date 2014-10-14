<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$theme_options = dynamicnews_theme_options();
echo JihTwig::getInstance()->TryRender();
get_header();
?>
