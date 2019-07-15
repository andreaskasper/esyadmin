<?php

class PageEngine {

    public static function html($key, array $params = array()) {
        $file  = self::html_find($key);
		if (!is_null($file)) {
			include($file); 
			return;
        }
		if (defined("debug")) trigger_error("Seite ".$key." kann nicht gefunden werden.", E_USER_WARNING);
    }

    public static function html_find($key, $extension = ".php") {
		$local = __DIR__."/../../../skins/default/html/".$key.$extension;
		if (file_exists($local)) return $local;
		return null;
	}

}
