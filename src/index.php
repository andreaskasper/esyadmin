<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if (file_exists(__DIR__."/config.inc.php")) require_once(__DIR__."/config.inc.php");
else require_once(__DIR__."/config.inc.default.php");

require_once(__DIR__."/app/code/classes/esyadmin.php");
esyadmin::init();
routing::run();