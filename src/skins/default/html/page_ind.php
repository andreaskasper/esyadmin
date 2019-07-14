<?php

$es = new elasticsearch(1);

PageEngine::html("header");
PageEngine::html("navsidebar");
?>
<main class="w-100">
    <div class="bg-dark p-1 px-4" style="background: #888 !important; text-shadow: 0 1px 0 #000; color: #fff;">
        <i class="far fa-server"></i> <?=html($es->hostport); ?>
        <i class="far fa-server"></i> <?=html($_GET["ind"]); ?>
    </div>
    <nav class="nav topnav_container">
        <a href="<?=$_ENV["baseurl"]; ?>indexes" class="nav-link"><i class="far fa-database"></i> Indexes</a>
    </nav>
    <div class="p-4">
        <div class="w-100">
        <div style="overflow-x: auto;">
        <table class="table table-striped">
            <thead><tr>
                <th></th>
                <th>ID</th>
                <th></th>

            </tr></thead>
            <tbody>
        <?php

$es = new elasticsearch(1);
$json = $es->performRequest("GET", "/".$_GET["ind"]."/_search");
foreach ($json["result"]["hits"]["hits"] as $row) {
echo('<tr>');
echo('<td><i class="far fa-edit"></i>edit <i class="far fa-copy"></i>copy <i class="far fa-trash"></i>delete</td>');
echo('<td>'.$row["_id"].'</td>');
echo('<td>'.var_export($row, true).'</td>');
echo('</tr>');
}
?>
            </tbody>
        </table></div></div>
    </div>
</main>
<?php
PageEngine::html("footer");
?>