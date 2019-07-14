<?php

class esyadmin {

    public static function init() {
        spl_autoload_register(function($class_name) {
            $prio = array();
            /*if (substr($class_name,0,4) == "API_") {
                require_once(__DIR__."/app/api/0.1/classes/".substr($class_name,4,999).".php");
                return true;
            }*/
            
            $prio[] = __DIR__."/".str_replace(chr(92), "/", $class_name).".php";
        
            foreach ($prio as $file) {
                if (file_exists($file)) {
                    require($file);
                    return true;
                }
            }
            trigger_error("Class ".$class_name." not found", E_USER_WARNING);
            return false;
        });

    }
}

function html($txt) {
	return htmlentities($txt, 3, "UTF-8");
}

function htmlattr($txt) {
	return str_replace(array("&",'"'),array("&amp;",'&quot;'),$txt);
}

function htmlhref($txt) {
	$txt = str_replace(array(" ","ä","ö","ü","ß","Ä","Ö","Ü"),array("_","ae","oe","ue","ss","Ae","Oe","Ue"),$txt);
	$txt = preg_replace("@[^a-zA-Z0-9\_\-]@iU","",$txt);
	return $txt;
}