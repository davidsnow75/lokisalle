<?php

class TestModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function showTables()
    {
        $sql = 'SHOW TABLES;';
        $result = $this->db->query($sql);

        while ($row = $result->fetch_assoc()) {
            $tables[] = $row;
        }

        return $tables;
    }
}
