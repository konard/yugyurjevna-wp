<?php
function almaz_theme_demo_import_lists(){
	$arr1 = almaz_theme_free_starter_sites();

	if (function_exists('almaz_premium_starter_sites')) {
		$arr2 = almaz_premium_starter_sites();
		return (array_merge( $arr2 , $arr1 ));
	}
	return $arr1;
}
add_filter('hdi_import_files','almaz_theme_demo_import_lists');