<?php

global $gShellScript, $gBitSystem;

// this will avoid $_SERVER related errors
$gShellScript = TRUE;

chdir( dirname( __FILE__ ));
require_once( '../../bit_setup_inc.php' );

if( !empty( $argc )) {
	// reduce feedback for command line to keep log noise way down
	define( 'BIT_PHP_ERROR_REPORTING', E_ERROR | E_PARSE );
}

if( empty( $argc ) && !$gBitUser->isAdmin() ) {
	$gBitSystem->fatalError( tra( 'You cannot enable postgis' ));
}

if (!defined('POSTGIS_SUPPORT') || !defined('POSTGIS_SRID') ) {
  echo "POSTGIS_SUPPORT or POSTGIS_SRID not defined. Please add  define('POSTGIS_SUPPORT', true); define('POSTGIS_SRID', 4326); to your kernel/config_inc.php";
  die;
}

echo "Running queries to enable postgis...";

$gBitSystem->mDb->query("SELECT AddGeometryColumn('".BIT_DB_PREFIX."geo', 'geom', ".POSTGIS_SRID.", 'POINT', 2)");
$gBitSystem->mDb->query("UPDATE `".BIT_DB_PREFIX."geo` SET `geom`=GeomFromText( 'POINT(' || lat || ' ' || lng || ')', ".POSTGIS_SRID.")");
$gBitSystem->mDb->query("CREATE VIEW `".BIT_DB_PREFIX."liberty_feature_type`  AS SELECT lc.content_id AS oid, lc.*, g.geom, -1 AS requesting_users_id, lc.title as requesting_users_groups FROM `".BIT_DB_PREFIX."liberty_content` lc LEFT JOIN `".BIT_DB_PREFIX."geo` g on (lc.content_id = g.content_id) WHERE g.geom IS NOT NULL;");

echo "Done.";

?>