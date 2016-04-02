<?php
$dbname = 'vogelpedia';
$host = 'localhost';
$db_host = "mysql:host=$host;dbname=$dbname;charset=utf8";
$user = 'vogelpedia_user';
$passwd = '1234';

class Model{
    protected $db_table = '';
    protected $primary_key = '';
    
//    function __construct() {
//        
//    }
    private function get_handler() {
        $dbHandler = new PDO($GLOBALS['db_host'], $GLOBALS['user'], $GLOBALS['passwd']);
        return $dbHandler;
    }
    
    public function get_columns() {
        $dbHandler = $this->get_handler();
        echo $this->db_table;
        $query = sprintf('SELECT "COLUMN_NAME" FROM "INFORMATION_SCHEMA"."COLUMNS"
                         WHERE "TABLE_SCHEMA"=%s AND "TABLE_NAME"=%s";', $GLOBALS['dbname'],
                         $this->db_table);
        $query = "SELECT :column_name FROM :schema . :columns WHERE :t_schema = :db_name"
                . " AND :t_name = :table";
        
        $stmt = $dbHandler->prepare($query);
//        $stmt->execute(array(':column_name' => 'COLUMN_NAME', ':schema' => 'INFORMATION_SCHEMA',
//                             ':columns' => 'COLUMNS', ':t_schema' => 'TABLE_SCHEMA',
//                             ':db_name' => $GLOBALS['dbname'], ':t_name' => 'TABLE_NAME',
//                             ':table' => $this->db_table));
        $result = $stmt->fetchAll();
        print_r($result);
        print '<br>'.$query;
        foreach($result as $res){
            echo "$res <br>";
        }
        
        $stmt->closeCursor();
        return $result;
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
        $query = $this->create_query('INSERT INTO', $data);
        $dbHandler = $this->get_handler();
    }
    
}

class BirdModel extends Model{
    protected $db_table = 'bird';
    protected $primary_key = 'idbird';
}
?>
