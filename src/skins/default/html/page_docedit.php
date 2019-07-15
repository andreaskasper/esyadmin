<?php

$es = new elasticsearch(1);
$res = $es->performRequest("GET", "/".$_GET["ind"]."/".$_GET["type"]."/".$_GET["doc"]);

PageEngine::html("header");
PageEngine::html("navsidebar");
?>
<main class="w-100">
    <div class="bg-dark p-1 px-4" style="background: #888 !important; text-shadow: 0 1px 0 #000; color: #fff;">
        <i class="far fa-server"></i> <?=html($es->hostport); ?>
    </div>
    <nav class="nav topnav_container">
        <a href="<?=$_ENV["baseurl"]; ?>indexes" class="nav-link"><i class="far fa-database"></i> Indexes</a>

    </nav>
    <div class="p-4">

    <script src="<?=$_ENV["baseurl"] ?>skins/default/libs/jsoneditor/jsoneditor.min.js"></script>
<style>
@import url(<?=$_ENV["baseurl"] ?>skins/default/libs/jsoneditor/jsoneditor.min.css);
</style>

    <div id="jsoneditor"></div>
    <script>
    var container = document.getElementById('jsoneditor');
  var options = {};
  var editor = new JSONEditor(container, options);
  editor.set(<?=json_encode($res["result"]["_source"]); ?>);
  alert("123");
        </script>




    </div>
</main>
<?php
PageEngine::html("footer");
?>