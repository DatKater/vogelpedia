<?php
require_once 'settings/object.php';


class Model{
    protected $db_table = '';
    protected $primary_key = '';
    private $stns;
    private $widgets;
    private $columns;


    function __construct() {
        $this->stns = $GLOBALS['settings']['database'];
        $this->widgets = $GLOBALS['settings']['widgets'];
        $this->columns = $this->query_columns();
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
                         WHERE TABLE_SCHEMA="%s" AND TABLE_NAME="%s";', $GLOBALS['dbname'],
                         $this->db_table);
        
        $stmt = $dbHandler->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $processed = array();
        foreach($result as $res) {
            array_push($processed, array('name' => $res['COLUMN_NAME'],
                                         'type' => $res['DATA_TYPE']));
        }
        print '<br>'.$query;
        $stmt->closeCursor();
        return $processed;
    }
    
    public function get_columns() {
        return $this->columns;
    }
    
    public function get_form() {
        
    }
    
    private function select_query($data, $cond) {
        
        $query = sprintf('SELECT %s FROM %s WHERE %s;', $data, $this->db_table,
                         $cond);
        return $query;
    }
    
    private function insert_query($data) {
        $query = sprintf('INSERT %s INTO %s;', $data, $this->db_table);
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
}
?>
