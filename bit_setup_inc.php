<?php
$registerHash = array(
	'package_name' => 'geo',
	'package_path' => dirname( __FILE__ ).'/',
	'service' => LIBERTY_SERVICE_GEO,
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'geo' ) ) {
	require_once( GEO_PKG_PATH.'LibertyGeo.php' );

	$gLibertySystem->registerService( LIBERTY_SERVICE_GEO, GEO_PKG_NAME, array(
		'content_load_sql_function' => 'geo_content_load_sql',
		'content_store_function'  => 'geo_content_store',
		'content_expunge_function'  => 'geo_content_expunge',
		'content_edit_mini_tpl' => 'bitpackage:geo/edit_geo.tpl',
	) );
}
?>
