<html>
<?php include 'parts/head.php' ?>
<body>
<?php include 'parts/header.php' ?>
        <div id="main"><div id="inhalt">
        <br>
        <br>
        <br>
        <h1>Vogelpedia</h1>

        <?php

        require_once 'settings/object.php';
        require_once 'renderer/object.php';
        require_once '/db_access/models.php';
        require_once 'functions.php';

        $query = 'SELECT * FROM bird;';
        $dbHandler = get_handler();
        $objects = get_single_value_from_db($dbHandler, 'bird', 'idbird, name, name_latin');
        $i = count($objects);
        echo "Momentan sind ".$i." V&ouml;gel in der Datenbank eingetragen.";
        ?>
        <br>
        <br>
        <div id="result">
        <ul>
        <?php
        foreach($objects as $object) {
            echo '<li><a href="/vogelpedia/detail.php?pk='.$object['idbird'].'">'.$object["name"].',  <i>'.$object["name_latin"].'</i></a></li>';
        }
        ?>
        </ul>
        </div>
        <br>
        <br>
        </div></div>
        <?php include 'parts/footer.php' ?>
    </body>
</html>