<?php 
require_once('settings/object.php');

// Erstellt ein PDO Objekt mit den Angaben, die es aus der settings.ini Datei erhaelt (diese wurden in das $settings Array geschrieben
function get_handler() {
    global $settings;
    return new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8',
                   $settings['database']['database_host'], $settings['database']['database_name']),
                   $settings['database']['user'], $settings['database']['password']);
}

// Erstellt aus den Angaben in POST ein Array mit Doppelpunkt am Anfang des Keys, damit daraus dann prepared Statements erstellt werden
function prepare_bound_variables($array) {
    $new = array(); // Rueckgabe
    foreach($array as $key => $var) { // Jeden Key im Array (z.B. $_POST)
        $new[':'.$key] = $var; // Fuege dem neuen Array :key = value hinzu, z.B. statt [name] = Amsel --> [:name] = Amsel
    }
    return $new; // Rueckgabe
}

// Gibt alle Werte aus einer Tabelle zurueck
function get_values_from_db($handler, $table){
    
    $query = sprintf('SELECT * FROM %s;', $table); // z.B. SELECT * FROM bird;
    $stmt = $handler->prepare($query); // Statement
    $stmt->execute(); // ausfueren
    $keys = $stmt->fetchAll(); // Alle Werte in ein Array
    $stmt->closeCursor(); // Verbindung schliessen

    return $keys; // Rueckgabe
}


function get_single_value_from_db($handler, $table, $value) {
    $query = sprintf('SELECT %s FROM %s;', $value, $table); // z.B. SELECT idbird FROM bird;
    $stmt = $handler->prepare($query); // Statement
    $stmt->execute(); // ausfueren
    $keys = $stmt->fetchAll(); // Alle Werte in ein Array
    $stmt->closeCursor(); // Verbindung schliessen

    return $keys; // Rueckgabe
}


// Erstellt <option> Argumente fuer die FK/M2M-Widgets
function print_select_options($array, $id, $name) {
    $options = ''; // Rueckgabestring
    foreach($array as $key){ // Jedes Argument
        $options .= sprintf('<option value="%s">%s</option>', $key[$id], $key[$name]); // z.B. <option value="2">Spechte</option>
    }
    return $options; // String zurueckgeben
}

// M2M Angaben von normalen Angaben trennen (da diese in eine andere Tabelle kommen)
function split_m2m($m2m, $post){
    // $m2m ist ein Array, in dem alle Angaben zu den Relationen stehen
    foreach($m2m as $key => $val){ // $key ist der Tabellenname der Relation, $val ein Array mit relevanten Infos zur Relation
        if(isset($post[$key])){ // Wenn der Tabellenname in POST steht, der Nutzer also etwas angegeben hat
            $m2m[$key]['value'] = $post[$key]; // Fuege den Informationen zur Relation die Werte, die der Nutzer angegeben hat hinzu
        }
        unset($post[$key]); // Entferne die Angabe aus dem $post
    }
    return array($post, $m2m); // Gebe beides wieder zurueck
}

// M2M Relationen werden in der Datenbank gespeichert
function handle_m2m($m2m, $id, $handler) {
    foreach($m2m as $table => $array) { // $table ist der Name der Tabelle der Relation, $array ein Array mit Informationen
        print_r($m2m);
        $fk_id_name = $array['fk_id']; // Der Name der Spalte mit dem Fremdschluessel
        $id_name = $array['id']; // Der Name der Spalte mit dem eigenen Schluessel
        $values = $array['value']; // Die Werte, die in die Tabelle eingefuegt werden sollen
        
        // Beispiel: INSERT INTO bird_has_food (food_idfood, bird_idbird) VALUES (1, 1);
        $query = sprintf("INSERT INTO %s (%s, %s) VALUES (:fk_id, '%s');", $table, $fk_id_name, $id_name, $id);
        
        foreach($values as $val) { // Fuer jeden Wert des Nutzers
            echo '<br>WERT:'.$val.'</br>';
            $stmt = $handler->prepare($query); // Statement erstellen
            $stmt->bindParam(':fk_id', $val); // Den einzelnen Wert in die Query einsetzen
            $stmt->execute(); // ausfuehren
            $stmt->closeCursor(); // Statement schliessen
        }
        
        
    }
}

function form_value($array, $name, $type='text', $select_value = ''){

   if(isset($array[$name])){

      switch($type){

         case 'text':{
            return ' value="'.htmlspecialchars($array[$name]).'" ';
            break;
         }

         case 'textarea':{
            return htmlspecialchars($array[$name]);
            break;
         }

         case 'checkbox':{
            return ' checked="checked" ';
            break;
         }

         case 'radio':{
             if($array[$name] == $select_value){
               return ' checked="checked" ';
            }
            break;
         }

         case 'select':{
            if($array[$name] == $select_value){
               return ' selected="selected" ';
            }
            break;
         }

      }

   }

   return '';
}

function is_404($condition) {
    if($condition) {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        include 'parts/404.html';
        exit;
    }
}

?>