<?php

$es = new elasticsearch(1);

if (!empty($_GET["ajax"]) AND $_GET["ajax"] == "list01") {
    $w = array("from" => $_GET["start"], "size" => $_GET["length"]);
    //if ($_GET["order"][0]["column"] == 0 AND $_GET["order"][0]["dir"] == "asc") $w["sort"] = "_uid:asc";
    $json = $es->performRequest("GET", "/".$_GET["ind"]."/_search", $w);

    //sort
    $out = array();
    $out["draw"] = $_GET["draw"];
    $out["recordsTotal"] = $json["result"]["hits"]["total"];
    $out["recordsFiltered"] = $json["result"]["hits"]["total"];
    $out["data"] = array();
    foreach ($json["result"]["hits"]["hits"] as $row) {
        $b = array();
        $b[] = '<a href="docedit?ind='.urlencode($_GET["ind"]).'&type='.urlencode($row["_type"]).'&doc='.urlencode($row["_id"]).'"><i class="far fa-edit"></i>edit</a> <i class="far fa-copy"></i>copy <i class="far fa-trash"></i>delete';
        $b[] = $row["_id"];
        $b[] = $row["_type"];
        $b[] = (string)$row["_score"];
        $b[] = '<span data-action="editvalue" data-type="'.htmlattr($row["_type"]).'" data-doc="'.htmlattr($row["_id"]).'" style="cursor:pointer;"><i class="far fa-edit"></i>'.strlen(json_encode($row["_source"])).'byte</span>';
        $out["data"][] = $b;
    }
    die(json_encode($out));
    exit;
}

if (!empty($_GET["ajax"]) AND $_GET["ajax"] == "editvalue") {
    $res = $es->performRequest("GET", "/".$_GET["ind"]."/".$_POST["type"]."/".$_POST["doc"]);
    echo('<textarea name="json" class="form-control" style="min-height: 75vh;">'.html(json_encode($res["result"]["_source"],JSON_PRETTY_PRINT)).'</TEXTAREA>');
    exit;
}

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
        <table id="list01" class="table table-striped">
            <thead><tr>
                <th>a</th>
                <th>ID</th>
                <th>b</th>
                <th>c</th>
                <th>d</th>

            </tr></thead>
            <tbody>
            </tbody>
        </table></div></div>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#list01').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 25,
        "ajax": "?ajax=list01&ind=<?=$_GET["ind"]; ?>"
    });

    $(document).on("click", "[data-action='editvalue']", function() {
        var type = $(this).data("type");
        var id = $(this).data("doc");
        $("#ModalEditValue .modal-title").text("Value of "+id);
        $("#ModalEditValue .modal-body").html('<div class="text-center"><i class="far fa-spin fa-spinner fa-2x"></i></div>');
        $("#ModalEditValue").modal("show");
        $.post("?ind=<?=$_GET["ind"]; ?>&ajax=editvalue", { type: type, doc: id}, function(data) {
            $("#ModalEditValue .modal-body").html(data);
        }, "html");
    });
});
</script>
    </div>
</main>

<div class="modal fade" id="ModalEditValue" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php
PageEngine::html("footer");
?>