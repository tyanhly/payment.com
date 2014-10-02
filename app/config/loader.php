<?php

$loader = new \Phalcon\Loader();

$configDirs = array(
    $config->application->modelsDir,
    $config->application->modelsRealDir,
    $config->application->formsDir,
    $config->application->libraryDir,
    $config->application->pluginsDir
);
$libraryDirs = dirToArray($config->application->libraryDir);
$formsDirs   = dirToArray($config->application->formsDir);

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array_merge($configDirs, $libraryDirs, $formsDirs)
)->register();


function directoryToArray($directory, $recursive = true, $listDirs = true, $listFiles = false, $exclude = '') {
    if (substr($directory, -1) == '/') $directory = substr($directory, 0, -1);

    $arrayItems    = array();
    $skipByExclude = false;
    $handle        = opendir($directory);

    if ($handle) {
        while (false !== ($file = readdir($handle))) {
            preg_match("/(^(([\.]){1,2})$|(\.(svn|git|md))|(Thumbs\.db|\.DS_STORE))$/iu", $file, $skip);
            if($exclude){
                preg_match($exclude, $file, $skipByExclude);
            }
            if (!$skip && !$skipByExclude) {
                if (is_dir($directory. DIRECTORY_SEPARATOR . $file)) {
                    if($recursive) {
                        $arrayItems = array_merge($arrayItems, directoryToArray($directory. DIRECTORY_SEPARATOR . $file, $recursive, $listDirs, $listFiles, $exclude));
                    }
                    if($listDirs){
                        $file = $directory . DIRECTORY_SEPARATOR . $file;
                        $arrayItems[] = $file;
                    }
                } else {
                    if($listFiles){
                        $file = $directory . DIRECTORY_SEPARATOR . $file;
                        $arrayItems[] = $file;
                    }
                }
            }
        }

        closedir($handle);
    }

    return $arrayItems;
}

function dirToArray($dir, $result = array()) {
    $result = array();
    $cdir   = scandir($dir); 
    foreach ($cdir as $key => $value) { 
        if (!in_array($value,array(".",".."))) {
            if (is_dir($dir . $value)) { 
                $result[] = $dir . $value;
            } 
        } 
    } 

    return $result; 
}