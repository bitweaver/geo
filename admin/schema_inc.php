<?php
// Add the following to your config_inc.php to add postgis support to geo
// define('POSTGIS_SUPPORT', true); define('POSTGIS_SRID', 4326);

$tables = array(
  'geo' => "
    content_id I4 NOTNULL,
    lat F,
    lng F,
    amsl F,
    amsl_unit C(2)
    CONSTRAINT ', CONSTRAINT `geo_ref` FOREIGN KEY (`content_id`) REFERENCES `".BIT_DB_PREFIX."liberty_content`( `content_id` )'
  "
);

global $gBitInstaller;

if (defined('POSTGIS_SUPPORT')) {
	// We use the schema default to create the geometry column in geo table
	$gBitInstaller->registerSchemaDefault(GEO_PKG_NAME, array(
		  "SELECT AddGeometryColumn('".BIT_DB_PREFIX."geo', 'geom', ".POSTGIS_SRID.", 'POINT', 2)",
		  "CREATE VIEW `".BIT_DB_PREFIX."liberty_feature_type`  AS SELECT lc.content_id AS oid, lc.*, g.geom, -1 AS requesting_users_id, lc.title as requesting_users_groups FROM `".BIT_DB_PREFIX."liberty_content` lc LEFT JOIN `".BIT_DB_PREFIX."geo` g on (lc.content_id = g.content_id) WHERE g.geom IS NOT NULL;",
															  )
										  );
}

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( GEO_PKG_NAME, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo( GEO_PKG_NAME, array(
	'description' => "A simple Liberty Service that any package can use to store geographic data (latitude, longitude, and above mean sea level) for any content.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
) );

// Requirements
$gBitInstaller->registerRequirements( GEO_PKG_NAME, array(
	'liberty' => array( 'min' => '2.1.4' ),
));
