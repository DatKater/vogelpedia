<?php 
require_once('settings/object.php');

function get_handler() {
    global $settings;
    return new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8',
                   $settings['database']['database_host'], $settings['database']['database_name']),
                   $settings['database']['user'], $settings['database']['password']);
}

function prepare_bound_variables($array) {
    $new = array();
    foreach($array as $key => $var) {
        $new[':'.$key] = $var;
    }
    return $new;
}

function get_values_from_db($handler, $table){
    $query = sprintf('SELECT * FROM %s;', $table);
    $stmt = $handler->prepare($query);
    $stmt->execute();
    $keys = $stmt->fetchAll();
    $stmt->closeCursor();
    echo $query;

    return $keys;
}

function print_select_options($array, $id, $name) {
    print_r($key);
    $options = '';
    foreach($array as $key){
        $options .= sprintf('<option value="%s">%s</option>', $key[$id], $key[$name]);
    }
    return $options;
}

?>