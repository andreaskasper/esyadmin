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
      <form method="POST">
      <div>
        <div class="input-group">
          <div class="input-group-prepend">
            <SELECT class="form-control" name="method">
              <OPTION value="GET">GET</OPTION>
              <OPTION value="POST">POST</OPTION>
              <OPTION value="PUT">PUT</OPTION>
              <OPTION value="DELETE">DELETE</OPTION>
            </SELECT>
          </div>
          <input type="text" class="form-control" name="url" value="<?=(empty($_POST["url"])?'/':htmlattr($_POST["url"])) ?>" />
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">run</button>
          </div>
        </div>
      </div>
        <div class="row no-gutters">
          <div class="col-6">
            <TEXTAREA name="body" class="form-control" placeholder="Request" style="min-height: 75vh;"></TEXTAREA>
          </div>
          <div class="col-6">
            <TEXTAREA class="form-control" style="min-height: 75vh;"><?=(isset($response)?html(json_encode($response["result"],JSON_PRETTY_PRINT)):''); ?></TEXTAREA>
          </div>
        </div>
      </form>
    </main>
  </body>
</html>