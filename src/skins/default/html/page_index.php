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
    <div class="row mt-2 mx-2">
        <div class="col-12 col-sm-6">
        </div>
        <div class="col-12 col-sm-6">
            <div class="card">
                <div class="card-header">Cluster Info</div>
                <div class="card-body">
                    <ul>
                        <?php
                        $res = $es->performRequest("GET","/");
                        echo('<li>Cluster name: '.$res["result"]["cluster_name"].'</li>');
                        echo('<li>Version: '.$res["result"]["version"]["number"].'</li>');
                        echo('<li>Lucene-Version: '.$res["result"]["version"]["lucene_version"].'</li>');
                        
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
PageEngine::html("footer");
?>