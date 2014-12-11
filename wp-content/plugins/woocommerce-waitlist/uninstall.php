<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit ();

require_once 'definitions.php';

delete_metadata( 'post', null, WCWL_SLUG, null, true );
delete_metadata( 'user', null, WCWL_SLUG, null, true );
delete_option( WCWL_SLUG );
