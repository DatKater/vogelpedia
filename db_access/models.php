<?php
require_once 'settings/object.php';
require_once 'renderer/object.php';


class Model{
    protected $db_table = '';
    protected $primary_key = '';
    private $stns;
    private $form_conf;
    private $widgets;
    private $semantic_names;
    private $columns;
    protected $exclude;


    function __construct() {
        $this->stns = $GLOBALS['settings']['database'];
        $this->widgets = $GLOBALS['settings']['widgets'];
        $this->semantic_names = $GLOBALS['settings']['semantic_names'];
        $this->form_conf = $GLOBALS['settings']['form'];
        $this->columns = $this->query_columns();
    }
    
    private function quote($handler, $string) {
        return substr($handler->quote($string), 1, -1);
    }
    
    private function get_handler() {
        $stns = $this->stns;
        $dbHandler = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8',
                             $stns['database_host'], $stns['database_name']),
                             $stns['user'], $stns['password']);
        return $dbHandler;
    }
    
    public function query_columns() {
        $dbHandler = $this->get_handler();
        $query = sprintf('SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                         WHERE TABLE_SCHEMA="%s" AND TABLE_NAME="%s";', $this->stns['database_name'],
                         $this->db_table);
        
        $stmt = $dbHandler->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $processed = array();
        foreach($result as $res) {
            if(!in_array($res['COLUMN_NAME'], $this->exclude)){
                array_push($processed, array('name' => $res['COLUMN_NAME'],
                                             'type' => $res['DATA_TYPE'],
                                             'semantic_name' => $this->semantic_names[$res['COLUMN_NAME']]));
            } else {
                
            }
        }
        
        $stmt->closeCursor();
        return $processed;
    }
    
    public function get_columns() {
        return $this->columns;
    }
    
    public function get_form() {
        $base_path = $this->form_conf['directory'];
        $form = "";
        $renderer = new TemplateRenderer();
        foreach($this->columns as $col) {
            $name = $col['name'];
            $type = $col['type'];
            $semantic_name = $col['semantic_name'];
            $value = '';
            $widget = $this->widgets[$type];
            $path = sprintf("%s/%s", $base_path, $widget);
            $form .= '<p>'.$renderer->render($path, array('name' => $name,
                                      'value' => $value, 'semantic_name' => $semantic_name)).'</p>';
        }
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
        $dbhandler = $this->get_handler();
        $cols = array();
        $vals = array();
        foreach($data as $key => $value) {
            if($this->validate_input($key, $value)) {
                array_push($cols, $key);
                array_push($vals, '"'.$this->quote($dbhandler, $value).'"');
            } else {
                return false;
            }
        }
        $cols = join(', ', $cols);
        $vals = join(', ', $vals);
        
        $query = sprintf('INSERT INTO %s (%s) VALUES (%s);', $this->db_table,
                         $cols, $vals);
        return $query;
    }
    
    public function get_object_by_pk($pk) {
        $query = select_query('*', array($this->primary_key => $pk));
        $dbHandler = $this->get_handler();
    }
    
    public function create($data) {
        $query = $this->insert_query($data);
        $dbHandler = $this->get_handler();
    }
    
}

class BirdModel extends Model{
    protected $db_table = 'bird';
    protected $primary_key = 'idbird';
    protected $exclude = array('idbird', 'image_path');
}
?>
