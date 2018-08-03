<?php
/**
 * Compresser les fichiers css et les fichiers js sur 1and1
 * @author Fobec.com 02/04/2012
 * @copyright http://www.fobec.com/tuto/1114/compression-gzip-fichiers-css-javascript-chez-1and1.html
 */

//Constante
$SITE_PATH=dirname( __FILE__ ).'/';
$CACHE_PATH=dirname( __FILE__ ).'/cache/';

/*******************************************************************************
 * le fichier css ou js n'existe pas sur le serveur
 * @return rien
 ******************************************************************************/
$file=$SITE_PATH.$_GET['f'];
if (!isset($_GET['f']) || !file_exists($file)) {
    exit(0);
}

$name=str_replace('/', '-', $_GET['f']);
$file_cache=$CACHE_PATH.$name.'.gz';
$file_ext=strtolower(strrchr($_GET['f'],'.'));

/*******************************************************************************
 * Déterminer le type de ressource
 ******************************************************************************/
$header_contenttype = 'text/plain';
if ($file_ext=='.css') {
    $header_contenttype = 'text/css';
} else if ($file_ext=='.js') {
    $header_contenttype = 'text/javascript';
} else {
    //pas de css ou js
    exit(0);
}

/*****************************************************************************
 * Charger le contenu fichier css ou js
 *****************************************************************************/
$buf=file_get_contents($file);

/*******************************************************************************
 * La requete porte sur un fichier non compressé
 ******************************************************************************/
if (stripos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')=== false) {
    $len=strlen($buf);
    header("Content-type: $header_contenttype; charset= UTF-8");
    header('Content-Length: '.$len);
    header('Vary: Accept-Encoding');
    header('Expires: '.gmdate('D, d M Y H:i:s GMT', strtotime(" 1 month")));
    echo $buf;
    exit(0);
}

/*******************************************************************************
 * La requete porte sur un fichier compressé
 ******************************************************************************/

//Rechercher la ressource en cache
$filedt=filemtime($file);
if (file_exists($file_cache)) {
    $file_cachedt=filemtime($file_cache);
} else {
    $file_cachedt=0;
}

//Compression du buffer ou lecture du cache
if ($file_cachedt>$filedt) {
    $gz=file_get_contents($file_cache);
} else {
    //compression
    $gz = gzencode($buf, 6);
    //ecriture cache
    $fhandle=fopen($file_cache, 'w');
    if ($fhandle) {
        fwrite($fhandle, $gz);
        fclose($fhandle);
    }
    $file_cachedt=filemtime($file_cache);
}


/*******************************************************************************
 * Envoyer la ressource compressé au navigateur
 ******************************************************************************/
$len=strlen($gz);
header("Content-type: $header_contenttype; charset= UTF-8");
header('Content-Length: '.$len);
header('Content-Encoding: gzip');
header('Vary: Accept-Encoding');
header('Expires: '.gmdate('D, d M Y H:i:s GMT', strtotime(" 1 month")));
header('Last-Modified: '.gmdate('D, d M Y H:i:s GMT', $file_cachedt));
echo $gz;
