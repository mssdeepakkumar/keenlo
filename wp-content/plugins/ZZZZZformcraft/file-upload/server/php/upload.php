<?php
error_reporting(0);
header('Content-Type: text/plain; charset=utf-8');

require_once('../../../../../../wp-config.php');
require_once(ABSPATH . 'wp-settings.php');

if ( !isset($_FILES) ) { echo json_encode(array('failed'=>'No file found')); die(); }
if ( !isset($_FILES['files']) ) { echo json_encode(array('failed'=>'No file found 2')); die(); }
if ( !is_writable(getcwd().'/files/') ) { echo json_encode(array('failed'=>'Not writable')); die(); }

if (function_exists('is_multisite') && is_multisite())
{
	$base = getcwd().'/files/'.$wpdb->blogid.'/';
	$full = plugins_url('formcraft/file-upload/server/php/files/'.$wpdb->blogid.'/');
	mkdir($base, 0755);
}
else
{
	$base = getcwd().'/files/';
	$full = plugins_url('formcraft/file-upload/server/php/files/');	
}

foreach ($_FILES as $key => $file)
{
	$uniq = uniqid(1);
	$new_name = $uniq.'---'.$file['name'][0];
	$uploads_dir = $base.$new_name;
	$moved = move_uploaded_file($file['tmp_name'][0], $uploads_dir);
	$files['files']['name'] = $file['name'][0];
	$files['files']['new_name'] = $new_name;
	$files['files']['size'] = $file['size'][0];
	$files['files']['url'] = $uploads_dir;
	$files['files']['full-url'] = $full.$new_name;
	$file = $base.'info.txt';
	$old = file_get_contents($file);
	if (!$old)
	{
		$new = array();
	}
	else
	{
		$new = json_decode($old, 1);
	}
	$new[$uniq] = json_encode($files['files']);
	file_put_contents($file, json_encode($new), LOCK_EX);
}

echo json_encode($files);


?>