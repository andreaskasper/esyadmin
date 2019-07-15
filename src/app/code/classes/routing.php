<?php

class routing {

    public static function run() {
        switch (self::pure_url()) {
            case "/":
                PageEngine::html("page_index"); exit;
            case "/ind":
                PageEngine::html("page_ind"); exit;
            case "/indexes":
                PageEngine::html("page_indexes"); exit;
            case "/docedit":
                PageEngine::html("page_docedit"); exit;
            case "/terminal":
            case "/console":
                PageEngine::html("page_console"); exit;
            default:
                die(self::pure_url());
        }


    }

    private function pure_url() {
        $_ENV["baseurl"] = substr($_SERVER["SCRIPT_NAME"],0, strlen($_SERVER["SCRIPT_NAME"])-9);
        $a = substr($_SERVER["REQUEST_URI"], strlen($_ENV["baseurl"])-1,999);
        return ((strpos($a, "?") === false)?$a:substr($a, 0, strpos($a,"?")));
    }
}