<?php
    require_once 'settings/object.php';
    require_once 'renderer/object.php';
    require_once 'functions.php';
    
    is_404(!isset($_GET['pk']));
    $pk = $_GET['pk'];
    $dbHandler = get_handler();
    $obj = get_object_by_col($dbHandler, 'bird', 'idbird', $pk);
    ob_start();
    $out = fopen('php://output', 'w');
    foreach($obj as $key=>$val) {
        fwrite($out, $key.';'.$val."\n");
    }
//    fputcsv($out, array_keys($obj));
//    foreach($obj as $index) {
//        echo $index;
//        fputcsv($out, $index);
//    }
    fclose($out);
    download_send_headers($obj['name'].'_export.csv');
    echo ob_get_clean();
?>