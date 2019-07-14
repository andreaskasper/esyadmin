    <nav id="esy_navigation">
        <div id="logo"><a href="<?=$_ENV["baseurl"] ?>">esyadmin</a></div>
        <div id="navipanellinks">
            <a href="<?=$_ENV["baseurl"] ?>"><i class="fas fa-home" TITLE="back to home"></i></a>
            <a href="<?=$_ENV["baseurl"] ?>terminal"><i class="fas fa-terminal" TITLE="terminal / console"></i></a>
            <a href="https://github.com/andreaskasper/esyadmin/wiki" TARGET="_blank" TITLE="esyadmindocumentation"><i class="far fa-question-circle"></i></a>
            <a href="https://www.elastic.co/guide/index.html" TARGET="_blank" TITLE="Elasticsearch documentation"><i class="fas fa-book-spells"></i></a>
            <a href="https://github.com/andreaskasper/esyadmin/issues" TARGET="_blank" TITLE="report a bug"><i class="fas fa-bug"></i></a>
            <a href="https://paypal.me/andreaskasper" TARGET="_blank" TITLE="help via PayPal"><i class="fab fa-paypal"></i></a>
            <a href="https://www.patreon.com/AndreasKasper" TARGET="_blank" TITLE="help via Patreon"><i class="fab fa-patreon"></i></a>
        </div>
        <div class="my-1 px-4">
          <SELECT class="form-control">
            <OPTION value="">(Server) ...</OPTION>
            <OPTION value="1" SELECTED="SELECTED">localhost</OPTION>
          </SELECT>
        </div>

        <div class="px-4">
<?php
$es = new elasticsearch(1);
$json = $es->performRequest("GET", "/_cat/indices?format=json");
foreach ($json["result"] as $row) {
  echo('<div><a href="'.$_ENV["baseurl"].'ind?ind='.urlencode($row["index"]).'"><i class="far fa-database"></i> '.html($row["index"]).'</a></div>');
}
?>
  </div>
    </nav>
 