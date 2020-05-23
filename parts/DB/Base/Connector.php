<?php

namespace db\base;

use PDO;

class Connector{
    private $pdo;

    /**
     * @return PDO
     */
    function getConnector(){
        $this->pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD,
            array(PDO::ATTR_EMULATE_PREPARES => false));
            
    	$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $this->pdo->query('SET NAMES utf8');
        return $this->pdo;
    }

    function commitExecute($sql, $param){
        $stmt = null;
        try{
            $pdo = $this->getConnector();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($param);
        } finally{
            $stmt = null;
        }
    }

    /**
     * Returns an array containing all of the result set rows
     */
    function execute($sql, $params =null){
        $stmt = null;
        try{
            $pdo = $this->getConnector();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } finally{
            $stmt = null;
        }
        return null;
    }

    function count($sql, $param = null){
        $pdo = $this->getConnector();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($param);
        return $stmt->fetch();
    }
}