<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 0);

$config = array();

// ============================ AUTH ====================================
$config['authentication'] = function () {
    return true; // sementara allow all
};

// ============================ LICENSE =================================
$config['licenseName'] = '';
$config['licenseKey']  = '';

// ============================ PRIVATE DIR =============================
$config['privateDir'] = array(
    'backend' => 'default',
    'tags'   => '.ckfinder/tags',
    'logs'   => '.ckfinder/logs',
    'cache'  => '.ckfinder/cache',
    'thumbs' => '.ckfinder/cache/thumbs',
);

// ============================ IMAGE SETTINGS ==========================
$config['images'] = array(
    'maxWidth'  => 2000,
    'maxHeight' => 2000,
    'quality'   => 85,
    'sizes' => array(
        'small'  => array('width' => 480, 'height' => 320, 'quality' => 80),
        'medium' => array('width' => 800, 'height' => 600, 'quality' => 80),
        'large'  => array('width' => 1200, 'height' => 900, 'quality' => 80),
    ),
);

// ============================ BACKEND =================================
$config['backends'][] = array(
    'name'         => 'default',
    'adapter'      => 'local',
    'baseUrl'      => '/crud_php/assets/ckfinder/userfiles/',  // ✅ sesuai struktur kamu
    'root'         => __DIR__ . '/userfiles/',                 // ✅ path lokal
    'chmodFiles'   => 0777,
    'chmodFolders' => 0777,
    'filesystemEncoding' => 'UTF-8',
);

// ============================ RESOURCE TYPES ==========================
$config['defaultResourceTypes'] = '';

$config['resourceTypes'][] = array(
    'name'              => 'Files',
    'directory'         => 'files',
    'maxSize'           => 0,
    'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpeg,mpg,pdf,png,ppt,pptx,rar,rtf,tar,tgz,tif,tiff,txt,wav,webp,wma,wmv,xls,xlsx,zip',
    'deniedExtensions'  => '',
    'backend'           => 'default'
);

$config['resourceTypes'][] = array(
    'name'              => 'Images',
    'directory'         => 'images',
    'maxSize'           => 0,
    'allowedExtensions' => 'bmp,gif,jpeg,jpg,png,webp',
    'deniedExtensions'  => '',
    'backend'           => 'default'
);

// ============================ ACCESS CONTROL ==========================
$config['roleSessionVar'] = 'CKFinder_UserRole';

$config['accessControl'][] = array(
    'role'                => '*',
    'resourceType'        => '*',
    'folder'              => '/',
    'FOLDER_VIEW'         => true,
    'FOLDER_CREATE'       => true,
    'FOLDER_RENAME'       => true,
    'FOLDER_DELETE'       => true,
    'FILE_VIEW'           => true,
    'FILE_CREATE'         => true,
    'FILE_RENAME'         => true,
    'FILE_DELETE'         => true,
    'IMAGE_RESIZE'        => true,
    'IMAGE_RESIZE_CUSTOM' => true
);

// ============================ TEMP DIR =================================
$config['tempDirectory'] = __DIR__ . '/tmp';

if (!file_exists($config['tempDirectory'])) {
    mkdir($config['tempDirectory'], 0777, true);
}

// ============================ MISC =====================================
$config['overwriteOnUpload'] = false;
$config['checkDoubleExtension'] = true;
$config['disallowUnsafeCharacters'] = false;
$config['secureImageUploads'] = true;
$config['checkSizeAfterScaling'] = true;
$config['htmlExtensions'] = array('html', 'htm', 'xml', 'js');
$config['hideFolders'] = array('.*', 'CVS', '__thumbs');
$config['hideFiles'] = array('.*');
$config['forceAscii'] = false;
$config['xSendfile'] = false;
$config['debug'] = true; // ✅ hidupin biar tahu error beneran

// ============================ PLUGINS ==================================
$config['pluginsDirectory'] = __DIR__ . '/plugins';
$config['plugins'] = array();

// ============================ CACHE ====================================
$config['cache'] = array(
    'imagePreview' => 24 * 3600,
    'thumbnails'   => 24 * 3600 * 365,
    'proxyCommand' => 0
);

// ============================ RETURN CONFIG ============================
return $config;
