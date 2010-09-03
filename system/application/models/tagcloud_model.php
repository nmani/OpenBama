<?php

class Tagcloud_model extends Model {

    function Tagcloud_model() {
        parent::Model();
    }

    function get_tag_by_id($tag_id = NULL) {
        $sql = 'SELECT * FROM tags WHERE id = ?';

        $query = $this->db->query($sql, array($tag_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_tag_by_tag_name($tag_name = NULL) {
        $sql = 'SELECT id,tag_name FROM tags WHERE tag_name = ?';

        $query = $this->db->query($sql, array($tag_name));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function _bill_tag_exists($tag_id = NULL,$bill_id = NULL) {
        $sql = 'SELECT id FROM bills_tags WHERE tag_id = ? and bill_id = ?';

        $query = $this->db->query($sql, array($tag_id,$bill_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function insert_bill_tag($bill_id = NULL,$tag = NULL) {

        $tag_row = $this->get_tag_by_tag_name($tag);


        if (!$tag_row) {
            $data = array(
                'tag_name' => $tag
            );

            $this->db->insert('tags', $data);

            $tag_id = $this->get_tag_by_tag_name($tag)->id;

        }else{
            $tag_id = $tag_row->id;
        }

        if ($bill_id && $tag_id) {

            if(!$this->_bill_tag_exists($tag_id, $bill_id)) {

                $data = array(
                    'tag_id' => $tag_id,
                    'bill_id' => $bill_id
                );

                $this->db->insert('bills_tags', $data);

            }

        }
    }

    function get_bills_by_tag_id($tag_id = NULL,$session = NULL) {

        $sql = 'SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name
                FROM bills b
                INNER JOIN bills_tags bt ON bt.bill_id = b.id
                WHERE bt.tag_id = ?
                AND session_identifier = ?';

        $query = $this->db->query($sql,array($tag_id,$session));

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        else {
            return false;
        }
    }

        function get_bill_tags($bill_id = NULL) {

        $sql = 'SELECT t.id,t.tag_name
                FROM tags t
                INNER JOIN bills_tags bt ON bt.tag_id = t.id
                WHERE bt.bill_id = ?';

        $query = $this->db->query($sql,array($bill_id));

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        else {
            return false;
        }
    }

    function get_bill_tag_cloud($session) {
        $sql = 'SELECT t.id, t.tag_name,COUNT(*) AS tag_count
                FROM tags t
                INNER JOIN bills_tags bt ON bt.tag_id = t.id
                INNER JOIN bills b ON b.id = bt.bill_id
                WHERE session_identifier = ?
                AND LENGTH(t.tag_name) > 0
                GROUP BY t.id, t.tag_name
                ORDER BY 3 DESC
                ';

        $query = $this->db->query($sql,array($session));

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        else {
            return false;
        }
    }
}