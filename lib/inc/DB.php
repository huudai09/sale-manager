<?php

class DB {

    private $host;
    private $dbname;
    private $username;
    private $password;
    private $db;

    public function __construct($cfg = array()) {
        $this->setConfig($cfg);
        try {
            $this->db = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=UTF-8', $this->username, $this->password);
            $this->db->exec("set names utf8"); // for older php version
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    // serve for connect to another database
    private function setConfig($cfg) {
        $sys_cfg = getConfig();
        $cfg = $cfg ? $cfg : $sys_cfg['database'];
        foreach ($cfg as $ck => $cf) {
            if (in_array($ck, array('host', 'dbname', 'username', 'password'))) {
                $this->$ck = $cf;
            }
        }
    }

    private function placeholders($text, $count = 0, $separator = ",") {
        $result = array();
        if ($count > 0) {
            for ($x = 0; $x < $count; $x++) {
                $result[] = $text;
            }
        }

        return implode($separator, $result);
    }

    public function select($sql = '') {
        if (!$sql)
            return;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectRow($sql = '') {
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($tb, $data) {
        $is_many = is_array($data[0]) ? true : false;
        $datafields = array_keys(!$is_many ? $data : $data[0]);
        if (!$is_many) {
            $data = array($data);
        }

        $this->db->beginTransaction(); // also helps speed up your inserts.
        $insert_values = array();
        foreach ($data as $d) {
            $question_marks[] = '(' . $this->placeholders('?', sizeof($d)) . ')';
            $insert_values = array_merge($insert_values, array_values($d));
        }

        $sql = "INSERT INTO `$tb` (" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute($insert_values);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $id = $this->db->lastInsertId();
        $this->db->commit();
        return $id;
    }

    public function update($tb, $fields, $cond) {
        if (is_array($fields)) {
            $new = array();
            foreach ($fields as $key => $value) {
                if (!is_numeric($value)) {
                    $new[] = '`' . $key . '`' . '=' . '\'' . $value . '\'';
                } else {
                    $new[] = '`' . $key . '`' . '=' . $value;
                }
            }

            if (!empty($cond))
                $cond = 'WHERE ' . $cond;

            $new = implode(', ', $new);

            $sth = $this->db->prepare("UPDATE `$tb` SET $new $cond ");
            $sth->execute();
        }
    }

}

//$db = new DB();
//$db->select("SELECT * FROM `types`");
//$db->insert('types', array('title' => '1235', 'date_created' => $d));
//$db->insert('types', array(array('title' => '1235', 'date_created' => $d), array('title' => '1235', 'date_created' => $d)));