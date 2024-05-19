<?php
class Connection {
    private $_host = 'localhost';
    private $_dbname = 'prak_pbo';
    private $_username = 'root';
    private $_password = '';

    private $_pdo;
    private static $_instance = null;
    private $_columnName = "*";
    private $_orderBy = "";
    private $_count = 0;

    public function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host='.$this->_host.';dbname='.$this->_dbname, $this->_username, $this->_password);
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $th) {
            die('Koneksi Bermasalah '. $th->getMessage());
        }
    }

    // Singelton pattern
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Connection();
        }
        return self::$_instance;
    }

    public function runQuery($query, $bindValue=[])
    {
        try {
            $stmt = $this->_pdo->prepare($query);
            $stmt->execute($bindValue);
        } catch (PDOException $th) {
            die('Koneksi Bermasalah '. $th->getMessage());
        }

        return $stmt;
    }

    public function getQuery($query, $bindValue=[])
    {
        return $this->runQuery($query, $bindValue)->fetchAll(PDO::FETCH_OBJ);
    }

    public function get($tableName, $condition = "", $bindValue=[])
    {
        $query = "SELECT {$this->_columnName} FROM {$tableName} {$condition} {$this->_orderBy}";
        $this->_columnName = "*";
        $this->_orderBy = "";
        return $this->getQuery($query, $bindValue);
    }

    public function insert($tableName, $data)
    {
        $dataKeys = array_keys($data);
        $dataValues = array_values($data);
        $placeholder = '('.str_repeat('?,', count($data) - 1). '?)';
        $query = "INSERT INTO {$tableName} (".implode(',', $dataKeys).") VALUES {$placeholder}";
        $this->_count = $this->runQuery($query, $dataValues)->rowCount();
        return true;
    }

    public function getWhere($tableName, $condition)
    {
        $queryCondition = "WHERE {$condition[0]} {$condition[1]}?";
        return $this->get($tableName, $queryCondition, [$condition[2]]);
    }

    public function getWhereOnce($tableName, $condition)
    {
        $result = $this->getWhere($tableName, $condition);
        
        if (!empty($result)) {
            return $result[0];
        } else {
            return false;
        }
    }

    public function update($tableName, $data, $condition)
    {
        $query = "UPDATE {$tableName} SET ";
        foreach ($data as $key => $val) {
            $query .= "$key=?,";
        }
        $query = substr($query, 0, -1);
        $query .= "WHERE {$condition[0]} {$condition[1]} ?";
        $dataValues = array_values($data);
        array_push($dataValues, $condition[2]);

        $this->_count = $this->runQuery($query, $dataValues)->rowCount();
        return true;
    }

    public function delete($tableName, $condition)
    {
        $query = "DELETE FROM {$tableName} WHERE {$condition[0]} {$condition[1]} ?";
        $this->_count = $this->runQuery($query, [$condition[2]])->rowCount();
        return true;
    }
}
?>
