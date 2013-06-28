<?php

class Database {

    public $connection = null;
    private $_host = null;
    private $_user = null;
    private $_password = null;
    private $_db = null;
    private $connection_limit = 5;
    
    
    function __construct($options = array()) {
        $this->_host = isset($options['host']) ? $options['host'] : $this->_host;
        $this->_user = isset($options['user']) ? $options['user'] : $this->_user;
        $this->_password = isset($options['password']) ? $options['password'] : $this->_password;
        $this->_db = isset($options['db']) ? $options['db'] : $this->_db;
        $this->connection_limit = isset($options['connection_limit']) ? $options['connection_limit'] : $this->connection_limit;
        
        $this->init();
    }
    
    static function &getInstance($options = array()) {
        
        static $instance;
        
        if(!isset($instance)) {
            $class_name = __CLASS__;
            $instance = new $class_name($options);
        }
        return $instance;
    }
    
    public function init() {
        if (!$this->isConnect()) {
            $this->_connect();
            if (!$this->isConnect()) {
                die("Error. Connection to database failed.");
            }
        }
        return $this->connection;
    }

    protected function _connect() {
        if (isset($this->_host, $this->_user, $this->_password, $this->_db) && !$this->connection) {
            while ($this->connection_limit > 0 && !$this->connection) {
                $this->connection = mysqli_connect($this->_host, $this->_user, $this->_password, $this->_db);
                $this->db_query('SET NAMES UTF8');
            }
        }
    }
    
    public function isConnect() {
        return (bool) $this->connection;
    }
    
    protected function _clear() {
        $this->connection = null;
        $this->_host = null;
        $this->_user = null;
        $this->_password = null;
        $this->_db = null;
    }
    
    #######################################
    ###  METHODS FOR WORK WHITH TABLES  ###
    #######################################
    
    public function db_free_result($q) {
        return mysqli_free_result($q);
    }
    
    public function db_real_escape_string($q) {
        return mysqli_real_escape_string($this->connection, $q);
    }

    public function db_fetch_array($q, $flag = MYSQL_ASSOC) {
        return mysqli_fetch_array($q, $flag);
    }

    public function db_fetch_row($q) {
        return mysqli_fetch_row($q);
    }

    function db_insert_id() {
        return mysqli_insert_id();
    }

    public function db_query($query) {
        $res = mysqli_query($this->connection, $query);
        return $res;
    }

    public function query($query) {
        $res = array();
        $q = $this->db_query($query);
        if ($q) {
            while ($row = $this->db_fetch_array($q)) {
                $res[] = $row;
            }
            $this->db_free_result($q);
        }

        return $res;
    }

    public function query_first($query) {
        $res = array();
        $q = $this->db_query($query);
        if ($q) {
            $res = $this->db_fetch_array($q);
            $this->db_free_result($q);
        }

        return $res;
    }

    public function query_first_cell($query) {
        $res = false;
        $q = $this->db_query($query);
        if ($q) {
            $res = $this->db_fetch_row($q);
            $this->db_free_result($q);
        }

        return is_array($res) ? $res[0] : false;
    }

    public function query_column($query, $column = 0) {
        $res = array();
        $fetch_func = is_int($column) ? 'db_fetch_row' : 'db_fetch_array';
        $q = $this->db_query($query);
        if ($q) {
            while ($row = $this->$fetch_func($q)) {
                $res[] = $row[$column];
            }
            $this->db_free_result($q);
        }
        return $res;
    }

    public function array2insert($tbl, $arr, $is_replace = false) {
        if (empty($tbl) || empty($arr) || !is_array($arr))
            return false;

        $query = $is_replace ? 'REPLACE' : 'INSERT';
        $arr_keys = array_keys($arr);

        foreach ($arr_keys as $k => $v) {
            if (!($v{0} == '`' && $v{strlen($v) - 1} == '`'))
                $arr_keys[$k] = "`$v`";
        }
        foreach ($arr as $k => $v) {
            if (!strlen($v)) {
                $arr[$k] = "''";
            } elseif (!($v{0} == '"' && $v{strlen($v) - 1} == '"') && !($v{0} == "'" && $v{strlen($v) - 1} == "'")) {
                $arr[$k] = "'$v'";
            }
        }

        $query .= ' INTO ' . $tbl . ' (' . implode(', ', $arr_keys) . ') VALUES (' . implode(', ', $arr) . ')';
        $r = $this->db_query($query);
        return $r ? $this->db_insert_id() : false;
    }

    public function array2update($tbl, $arr, $where = '') {
        if (empty($tbl) || empty($arr) || !is_array($arr))
            return false;

        $r = array();
        foreach ($arr as $k => $v) {
            if (!($k{0} == '`' && $k{strlen($k) - 1} == '`')) {
                $k = "`$k`";
            }
            if (!strlen($v)) {
                $v = "''";
            } elseif (!($v{0} == '"' && $v{strlen($v) - 1} == '"') && !($v{0} == "'" && $v{strlen($v) - 1} == "'")) {
                $v = "'$v'";
            }
            $r[] = $k . '=' . $v;
        }
        return $this->db_query('UPDATE ' . $tbl . ' SET ' . implode(', ', $r) . ($where ? ' WHERE ' . $where : ''));
    }
    
}

?>
