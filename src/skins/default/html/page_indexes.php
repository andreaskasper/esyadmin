<?php

$es = new elasticsearch(1);

if (!empty($_POST["method"])) {
  $response = $es->performRequest($_POST["method"], $_POST["url"], $_POST["body"]);
}

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
        <table class="table table-striped">
            <thead><tr>
                <th>health</th>
                <th>status</th>
                <th>name</th>
                <th>uuid</th>
                <th></th>
                <th></th>
                <th>docs</th>
                <th>deleted</th>
                <th>size</th>
                <th>pri size</th>
            </tr></thead>
            <tbody>
        <?php

$es = new elasticsearch(1);
$json = $es->performRequest("GET", "/_cat/indices?format=json");
foreach ($json["result"] as $row) {
echo('<tr>');
echo('<td class="text-center">');
switch ($row["health"]) {
    case "yellow": echo('<i class="fas fa-circle" style="color: #FF9E1C;"></i>'); break;
    default: echo($row["health"]);
}
echo('</td>');
echo('<td class="text-center">');
switch ($row["status"]) {
    case "open": echo('<i class="far fa-lock-open"></i>'); break;
    default: echo($row["status"]);
}
echo('</td>');
echo('<td><a href="'.$_ENV["baseurl"].'ind?ind='.urlencode($row["index"]).'">'.$row["index"].'</a></td>');
echo('<td>'.$row["uuid"].'</td>');
echo('<td class="text-right">'.$row["pri"].'</td>');
echo('<td class="text-right">'.$row["rep"].'</td>');
echo('<td class="text-right">'.$row["docs.count"].'</td>');
echo('<td class="text-right">'.$row["docs.deleted"].'</td>');
echo('<td class="text-right">'.$row["store.size"].'</td>');
echo('<td class="text-right">'.$row["pri.store.size"].'</td>');
echo('</tr>');
}
?>
            </tbody>
        </table>
    </div>
</main>
<?php
PageEngine::html("footer");
?>