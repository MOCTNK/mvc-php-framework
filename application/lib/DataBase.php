<?php

namespace application\lib;

use PDO;
class DataBase
{
    protected $link;
    public function __construct() {
        $config = require 'application/config/db.php';
        $this->link = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['password']);
    }

    public function query($sql, $params = []) {
        $stmt = $this->link->prepare($sql);
        if(!empty($params)) {
            foreach($params as $key => $val) {
                $stmt->bindValue(':'.$key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function queryFetch($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}