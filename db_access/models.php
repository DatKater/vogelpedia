<?php
require_once 'settings/object.php'; // Einstellungen
require_once 'renderer/object.php'; // Template Renderer


class Relation {
    public $column;
    public $fk_model;
    
    public function __construct($column, $fk_model) {
        $this->column = $column;
        $this->fk_model = $fk_model;
    }
    
    public function get_widget(){
        $renderer = new TemplateRenderer();
        $fk_objects = $this->fk_model->get_objects();
    }
}

class M2MRelation {
    
}


class Instance {
    protected $primary_key;
    protected $values;
    
    public function __construct($values) {
        $this->values = $values;
    }
    
    public function get_values() {
        return $this->values;
    }
    
    public function get_value($key) {
        return $this->values[$key];
    }
    
    public function __toString() {
        return '';
    }
}


class Model{
    protected $db_table = ''; // Die Datenbank-Tabelle, die genutzt wird
    protected $primary_key = ''; // Der Primaerschluessel der Tabelle
    protected $instance; // Abfragen werden als Instanz dieser Klasse zurueckgegeben
    
    // Einstellungen, die aus der settings.ini geladen wurden
    private $stns; // Datenbank
    private $form_conf; // Fuer Formulare, z.B. Pfad zu den Widgets
    private $widgets; // Aus welchen Dateien die Widgets geladen werden sollen
    private $semantic_names; // Lesbare Namen fuer die Labels -> "Name in Latein" statt "name_latin"
    private $columns; // Array in das die Spalten der Tabelle sowie Zusatzinfos (lesbarer Name, Datentyp der Spalte) gespeichert werden
    protected $exclude; // Spalten in der Tabelle, die fuer das Formular ignoriert werden sollen (ForeignKey)
    protected $foreign_keys; // Array, das Spalten fuer FKs sowie deren Tabelle+PK enthaelt
    protected $many_to_many; // Array, enthaelt M2M Tabelle sowie verbundene Tabellen und PKs


    public function __construct() {
        
        // Einstellungen aus der INI werden in Variabeln gespeichert
        $this->stns = $GLOBALS['settings']['database'];
        $this->widgets = $GLOBALS['settings']['widgets'];
        $this->semantic_names = $GLOBALS['settings']['semantic_names'];
        $this->form_conf = $GLOBALS['settings']['form'];
        
        // Spalten der DB abfragen und verarbeiten lassen (siehe query_columns)
        $this->columns = $this->query_columns();
    }
    
    public function as_str(){
        return '';
    }
    
    private function quote($handler, $string) {
        return substr($handler->quote($string), 1, -1);
    }
    
    private function get_handler() {
        // Per PDO eine Verbindung zur DB herstellen mit den Einstellungen aus der INI und die Verbindung zurueckgeben
        $dbHandler = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8',
                             $this->stns['database_host'], $this->stns['database_name']),
                             $this->stns['user'], $this->stns['password']);
        return $dbHandler;
    }
    
    public function query_columns() {
        $dbHandler = $this->get_handler(); // DB-Verbindung herstellen
        
        // SQL Statement: Datentyp und Spaltenname aller Spalten in der eigenen Tabelle erhalten
        $query = sprintf('SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                         WHERE TABLE_SCHEMA="%s" AND TABLE_NAME="%s";', $this->stns['database_name'],
                         $this->db_table);
        
        $stmt = $dbHandler->prepare($query); // Abfrage vorbereiten
        $stmt->execute(); // ausfuehren
        $result = $stmt->fetchAll(); // Ergebnisse
        $processed = array(); // Resultat, wird zurueckgegeben und in die private $columns Spalte geschrieben
        
        foreach($result as $res) {
            // Wenn der Spaltenname nicht in exclude steht, also nicht ignoriert werden soll
            if(!in_array($res['COLUMN_NAME'], $this->exclude)){
                // Fuege die Spalte, ihren Datentyp und den lesbaren Namen zum Resultat hinzu
                array_push($processed, array('name' => $res['COLUMN_NAME'],
                                             'type' => $res['DATA_TYPE'],
                                             'semantic_name' => $this->semantic_names[$res['COLUMN_NAME']]));
            }
        }
        
        $stmt->closeCursor(); // Verbindung schliessen
        return $processed; // Resultat zurueckgeben
    }
    
    public function get_columns() {
        return $this->columns; // Um auf $columns zugreifen zu koennen, da private Variable
    }
    
    public function get_form($data=NULL) {
        $base_path = $this->form_conf['directory']; // Der Pfad/Ordner, in dem die Widget-Templates liegen
        $form = ""; // Wird HTML-Code fuer das Formular beinhalten
        $renderer = new TemplateRenderer(); // Parser fuer die Templates, siehe renderer/object.php
        foreach($this->columns as $col) { // Fuer jede Spalte
            $name = $col['name']; // Spaltenname
            $type = $col['type']; // Datentyp der Spalte
            $semantic_name = $col['semantic_name']; // lesbarer Name fuer die Spalte
            $value = (!empty($data[$name])) ? $data[$name] : ''; // In der Spalte gespeicherter Wert, 
            $widget = $this->widgets[$type]; // Das Widgettemplate (z.B. text.php) wird passend dem Datentyp ausgewaehlt
            $path = $base_path.'/'.$widget; // Der Pfad zum Widgettemplate
            // Das Widget wird gerendert, die Platzhalter werden durch die Werte ersetzt, siehe renderer/object.php
            $form .= '<p>'.$renderer->render($path, array('name' => $name,
                                      'value' => $value, 'semantic_name' => $semantic_name)).'</p>';
            
        }
        // Die gerenderten Widgets werden in das Template eingesetzt, liefert Submit/Reset Buttons etc.
        $form_template = $renderer->render($this->form_conf['base_template'],
                                           array('form' => $form));
        return $form_template;
    }
    
    private function validate_input($column, $input) {
        return true;
    }
    
    private function select_query($data, $cond) {
        
        $query = sprintf('SELECT %s FROM %s WHERE %s;', $data, $this->db_table,
                         $cond);
        return $query;
    }
    
    public function insert_query($data) {
        $dbhandler = $this->get_handler(); // DB-Verbindung herstellen
        $cols = array(); // Array fuer alle Spaltennamen
        $vals = array(); // Array fuer alle Werte
        // Durch den Nutzerinput
        foreach($data as $key => $value) {
            // Wenn der Nutzerinput nicht ungueltig ist, sonst abbrechen
            if($this->validate_input($key, $value)) {
                array_push($cols, $key); // Die Spalte
                array_push($vals, '"'.$this->quote($dbhandler, $value).'"'); // wird vom Wert getrennt
            } else {
                return false;
            }
        }
        $cols = join(', ', $cols); // Alles zusammenfuegen, damit SQL akzeptiert
        $vals = join(', ', $vals); // Hier auch
        
        // INSERT Statement vorbereiten
        $query = sprintf('INSERT INTO %s (%s) VALUES (%s);', $this->db_table,
                         $cols, $vals);
        return $query; // Statement zurueckgeben
    }
    
    public function get_object_by_pk($pk) {
        $query = select_query('*', array($this->primary_key => $pk));
        $dbHandler = $this->get_handler();
    }
    
    public function get_objects() {
        $query = 'SELECT * FROM '.$this->db_table.';';
        $dbHandler = $this->get_handler();
        $stmt = $dbHandler->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $queryset = array();
        print_r($result);
        foreach($result as $res){
            array_push($queryset, new $this->instance($res));
        }
        return $queryset;
    }
    
    public function create($data) {
        $query = $this->insert_query($data);
        $dbHandler = $this->get_handler();
    }
    
}


class BirdInstance extends Instance {
    protected $primary_key = 'idbird';
    
    public function __toString() {
        return $this->values['name'].' mit PK: '.$this->values[$this->primary_key];
    }
}


// Model fuer die bird-Tabelle, also die Voegel
class BirdModel extends Model{
    protected $db_table = 'bird';
    protected $primary_key = 'idbird';
    protected $instance = BirdInstance;
    protected $exclude = array('idbird', 'image_path', 'family_idfamily', 'breeding_place_idbreeding_place');
    protected $foreign_keys = array(
        array('col' => 'family_idfamily', 'fk_table' => 'family', 'fk_pk' => 'idfamily'),
        array('col' => 'breeding_place_idbreeding_place', 'fk_table' => 'breeding_place', 'fk_pk' => 'idbreeding_place'),
    );
}

// Model fuer die breeding_place-Tabelle, also den Brutort
class BreedingPlaceModel extends Model {
    protected $db_table = 'breeding_place';
    protected $primary_key = 'idbreeding_place';
    protected $exclude = array('idbreeding_place', );
}


class FamilyModel extends Model {
    
}
?>
