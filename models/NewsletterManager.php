<?php

class NewsletterManager extends Model
{
    public function insert( $array )
    {
        if (
            empty($array['expediteur'])
            || empty($array['sujet'])
            || empty($array['message'])
        ) {
            return false;
        }

        array_walk_recursive( $array, function (&$valeur) { $valeur = $this->db->real_escape_string( $valeur ); } );

        $sql = "INSERT INTO pseudomails
                VALUES ('',
                        '" . substr( $array['expediteur'], 0, 254 ) . "',
                        '" . substr( $array['sujet'], 0, 254 )      . "',
                        '" . $array['message'] . "',
                        UNIX_TIMESTAMP());";

        return $this->exequery($sql);
    }

    public function countAbo()
    {
        return $this->exequery("SELECT id FROM newsletters;")->num_rows;
    }

    public function getLastNewsletter()
    {
        $result = $this->exequery("SELECT * FROM pseudomails ORDER BY id DESC");

        if ( $result ) {
            return $result->fetch_assoc();
        } else {
            return [];
        }
    }
}
