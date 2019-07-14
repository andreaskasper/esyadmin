<?php

/*
 * Last Change: 2019-01-10
 * -> adding read
 */

class elasticsearch {

    private static $default_servers = array();
    private $_host = null;
    private $_localdatastore = null;



    public function __construct($server = null) {
        global $cfg;
        if (is_null($server)) "http://".$cfg['Servers'][1]["host"].":".$cfg['Servers'][1]["port"];
        elseif (is_string($server)) $this->_host = $server;
        elseif (is_numeric($server)) $this->_host = "http://".$cfg['Servers'][$server]["host"].":".$cfg['Servers'][$server]["port"];
        else throw new Exception("Unbekannter Elasticsearch-Server");
    }

    public static function init($id, $url) {
        self::$default_servers[$id] = $url;
    }

    public function __get($name) {
        switch ($name) {
            case "name":
                $str = json_decode(file_get_contents($this->_host."/"),true);
                return $str["name"];
            case "hostport":
                $a = parse_url($this->_host);
                return $a["host"].":".$a["port"];
        }
        trigger_error("Unbekannte Variable ".$name, $_USER_WARNING);
        return null;
    }

    public function __set($name, $value) {
        switch ($name) {
            case "localdatastore":
                if (!file_exists($value) OR !is_dir($value)) throw new Exception("Directory for Datastore doesn't exist.");
                if (!is_writeable($value)) trigger_error("Datastore is not writeable.", E_USER_WARNING);
                $this->_localdatastore = $value;
                return true;
        }
        return false;
    }

    public function write(string $index, string $type, string $id = null, $data) {
        $out = array();
        if (!is_string($data) AND !is_array($data)) throw new Exception("Falscher Typ für data");
        $res = $this->performRequest("PUT", "/".$index."/".$type."/".(is_null($id)?'':$id), $data);
        print_r($res);
        return $out;
    }

    public function read(string $index, string $type, string $id) {
        $res = $this->performRequest("GET", "/".$index."/".$type."/".$id);
        if ($res["http_code"] == 404) return null;
        return $res["result"];
    }


    public function performRequest($method = "GET", string $path = "", $data = null) {
        $out = array();
        if (is_array($data)) $data= json_encode($data);

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $this->_host.$path); 
      
        if (!is_null($data)) {
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        } else {
            curl_setopt($ch, CURLOPT_HEADER, FALSE); 
        }
        //curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        $out["result_str"] = curl_exec($ch); 
        if (substr($out["result_str"],0,1) == "{" OR substr($out["result_str"],0,1) == "[") $out["result"] = json_decode($out["result_str"], true); else $out["result"] = $out["result_str"];
        $out["http_code"] = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close($ch); 
        return $out;
    }



}