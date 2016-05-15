<?php
    require_once 'settings/object.php';
    require_once 'renderer/object.php';
    require_once 'functions.php';
    
    is_404(!isset($_GET['pk'])); // Wurde kein pk angegeben, gibts nen 404
    $pk = $_GET['pk'];
    $dbHandler = get_handler(); // PDO
    $obj = get_object_by_col($dbHandler, 'bird', 'idbird', $pk); // Aus DB laden
    ob_start(); // Output zwischenspeichern
    $out = fopen('php://output', 'w'); // Wir schreiben direkt in den "Output"
    foreach($obj as $key=>$val) { // Durch das Objekt durch
        fwrite($out, $key.';'.$val."\n"); // In den Output schreiben wir z.B. name;Specht\n --> Ergibt eine Zeile mit zwei Spalten
    }
    fclose($out); // Output schliessen
    download_send_headers($obj['name'].'_export.csv'); // Header bearbeiten, weil kein HTML sondern Datei
    echo ob_get_clean(); // Output zurueck geben
?>