<?php

$es = new elasticsearch(1);

if (!empty($_POST["act"]) AND $_POST["act"] == "newindex") {
    $w = array("settings" => array());
    $w["settings"]["number_of_shards"] = $_POST["shards"];
    $w["settings"]["number_of_replicas"] = $_POST["replicas"];
    $es->performRequest("PUT", "/".$_POST["name"], $w);
    $msg_new = "new index created";
}

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

<?php
if (!empty($msg_new)) echo('<div class="alert alert-info">'.$msg_new.'</div>');
?>

        <div class="w-100">
        <div style="overflow-x: auto;">
        <table class="table table-striped">
            <thead><tr>
                <th>health</th>
                <th>status</th>
                <th>name</th>
                <th>uuid</th>
                <th>Primary</th>
                <th>Replicas</th>
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
        </table></div></div>

        <form method="POST"><INPUT type="hidden" name="act" value="newindex"/>
        <div class="card">
            <div class="card-header">Create new index</div>
            <div class="card-body">
                <div><INPUT type="text" class="form-control" name="name" placeholder="index name"/></div>
                <div class="row"><div class="col">Number of Shards:</div><div class="col"><INPUT type="text" class="form-control" name="shards" value="1"/></div></div>
                <div class="row"><div class="col">Number of Replicas:</div><div class="col"><INPUT type="text" class="form-control" name="replicas" value="1"/></div></div>
            </div>
            <div class="card-footer text-right"><button class="btn btn-primary" type="submit">create</button></div>
        </div>
        </form>
    </div>
</main>
<?php
PageEngine::html("footer");
?>