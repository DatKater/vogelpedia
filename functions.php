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
    $options = '';
    foreach($array as $key){
        $options .= sprintf('<option value="%s">%s</option>', $key[$id], $key[$name]);
    }
    return $options;
}

function split_m2m($m2m, $post){
    foreach($m2m as $key => $val){
        if(isset($post[$key])){
            $m2m[$key]['value'] = $post[$key];
        }
        unset($post[$key]);
    }
    return array($post, $m2m);
}

function handle_m2m($m2m, $id, $handler) {
    foreach($m2m as $table => $array) {
        $fk_id_name = $array['fk_id'];
        $id_name = $array['id'];
        $values = $array['value'];
        
        $query = sprintf("INSERT INTO %s (%s, %s) VALUES (:fk_id, '%s')", $table, $fk_id_name, $id_name, $id);
        $stmt = $handler->prepare($query);
        
        echo $query;
        print_r($values);
        
        foreach($values as $val) {
            $stmt->bindParam(':fk_id', $val);
            $stmt->execute();
        }
        $stmt->closeCursor();
        
    }
}
?>