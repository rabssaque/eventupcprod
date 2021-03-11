<?php

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Eventos UPC',
		'menu_title'	=> 'Eventos UPC',
		'menu_slug' 	=> 'eupc-settings',
		'capability'	=> 'manage_options',
		'redirect'		=> false
	));

	
}