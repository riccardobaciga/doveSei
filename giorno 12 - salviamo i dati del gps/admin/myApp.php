<?php
    // DEFINE COSTANTI PER LINK DIRETTO E URL DELLE DIRECTORY 
    define(sl,"/");
    define(baseDir, realPath(__DIR__.sl."..").sl);
    define(baseUrl, 'https://' . $_SERVER['HTTP_HOST'].sl);
    
    $elements = scandir(baseDir);
    foreach($elements as $element){
        if (! strstr($element, ".") && is_dir(baseDir.sl.$element)){
            define("path".ucfirst($element), baseDir.$element.sl);
            define("url".ucfirst($element), baseUrl.$element.sl);
            $subPath = baseDir.$element.sl;
            $subUrl = baseUrl.$element.sl;
            $subElements = scandir($subPath);
            foreach($subElements as $subElement){
                if (! strstr($subElement, ".") && is_dir($subPath.$subElement)){
                    define("path".ucfirst($subElement), $subPath.$subElement.sl);
                    define("url".ucfirst($subElement), $subUrl.$subElement.sl);
                }
            };
        }
    };

    
    // dati per collegarsi al DB
    $myApp->database->typeDB = "mysql";
    $myApp->database->hostDB = "localhost";
    $myApp->database->userDB = "dovesei";  
	$myApp->database->passwordDB = ""; 
	$myApp->database->databaseDB= "my_dovesei";
	
	
    $cryptKey = 'nascondi';
    require_once (pathAdmin."db_class.php");

    foreach (scandir(pathElements) as $dirName) {
        $fileObjectName = pathElements.$dirName.sl."class.php";
        if (is_file($fileObjectName) ){
            require_once($fileObjectName);
        }
    } 
    
    
function createKey($string){
    global $cryptKey;
    return crypt($string, $cryptKey );
}

function debug($msg){
    $nomeFile = "./myApp.debug";
    $debugFile = fopen($nomeFile, "a") or die("Unable to open file! $nomeFile");
    fwrite($debugFile, $msg);
    fclose($debugFile);
}

function checkInput($quale, $default = "")
{
    global $$quale;
    $$quale = isset($_POST[$quale]) ? $_POST[$quale] : (isset($_GET[$quale]) ? $_GET[$quale] : $default);
    return ($$quale != "");
}

function mandatory($nome){
    global $$nome;
    checkInput($nome);
    if ($$nome === "" || strlen($$nome) < 1 ){
        debug("{\"result\":\"KO\",\"description\":\"campo $nome mancante.<br>\n".inputVariables()."\"}");
        die ("{\"result\":\"KO\",\"description\":\"campo $nome mancante.<br>\n".inputVariables()."\"}");
    }
}

function inputVariables(){
    $result = "GET <br>\n";
    foreach ($_GET as $k => $v)
    {
        $result .= " ->$k<- -->$v<-- <br>\n";
    }
    $result .= "POST <br>\n";
    foreach ($_POST as $k => $v)
    {
        $result .= " $k -->$v<-- <br>\n";
    }
    return $result;
}

function returnError($msg){
    die ('{"result":"KO","description":"'.$msg.'"}');
}
    
function returnData($msg){
    die ('{"result":"OK","data":'.$msg.'}');
}