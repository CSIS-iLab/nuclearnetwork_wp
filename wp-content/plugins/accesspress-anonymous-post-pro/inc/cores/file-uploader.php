<?php

if ( !wp_verify_nonce($_GET[ 'file_uploader_nonce' ], 'ap-file-uploader-nonce') )
    die('No script kiddies please!');
$allowedExtensions = array_map('sanitize_text_field', $_GET[ 'allowedExtensions' ]); //array('jpg', 'jpeg', 'png', 'gif');
$sizeLimit = sanitize_text_field($_GET[ 'sizeLimit' ]);
$custom_folder = sanitize_text_field($_GET[ 'custom_folder' ]);
$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$upload_dir = wp_upload_dir();
if ( $custom_folder != '' ) {
    $upload_path = $upload_dir[ 'basedir' ] . '/' . $custom_folder . '/';
    $upload_url = $upload_dir[ 'baseurl' ] . '/' . $custom_folder;
} else {
    $upload_path = $upload_dir[ 'path' ] . '/';
    $upload_url = $upload_dir[ 'url' ];
}
//$this->print_array($upload_dir);
//die();
$result = $uploader->handleUpload($upload_path, $replaceOldFile = false, $upload_url);

echo json_encode($result);
