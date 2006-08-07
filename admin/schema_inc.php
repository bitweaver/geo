<?php
$tables = array(
  'geo' => "
    content_id I4 NOTNULL,
    lat F,
    lon F,
    amsl F,
    amsl_unit C(2),
    CONSTRAINT ', CONSTRAINT `geo_ref` FOREIGN KEY (`content_id`) REFERENCES `".BIT_DB_PREFIX."liberty_content`( `content_id` )'
  ",
);

global $gBitInstaller;

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( GEO_PKG_NAME, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo( GEO_PKG_NAME, array(
	'description' => "A simple Liberty Service that any package can use to store geographic data (latitude, longitude, and above mean sea level) for any content.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
) );
?>
