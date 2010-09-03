<?php

class Admin_model extends Model {

    function Admin_model() {
        parent::Model();
    }

    function get_committees() {
        $sql = "SELECT c.id AS committee_id,CONCAT(c.committee_name,' ',IFNULL(c.subcommittee_name,'')) AS committee_name
                    FROM committees c
                    WHERE active = true
                    ORDER BY 2";

        $query = $this->db->query($sql);

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

    function get_all_people($session) {
        $sql = 'SELECT p.id AS person_id,p.full_name
                FROM people p
                INNER JOIN roles r ON r.person_id = p.id
                INNER JOIN SESSION s ON s.start_date > r.startdate AND s.end_date < r.enddate
                WHERE session_identifier = ?
                ORDER BY p.full_name';

        $query = $this->db->query($sql, array($session));

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

    function delete_committee_member($id) {

        $this->db->delete('committees_people', array('id' => $id));
    }

    function insert_committee_member($committee_id,$person_id,$role,$session) {
        $data = array(
            'committee_id' => $committee_id,
            'person_id' => $person_id ,
            'role' => $role,
            'session_identifier' => $session
        );

        $this->db->insert('committees_people', $data);

    }

    function get_all_committee_members($session) {
        $sql = 'SELECT cp.id, cp.person_id, p.full_name, cp.role, cp.committee_id,c.committee_name,c.subcommittee_name
                FROM committees_people cp
                INNER JOIN people p ON p.id = cp.person_id
                INNER JOIN committees c on c.id = cp.committee_id
                WHERE session_identifier = ? ORDER BY c.committee_name,c.subcommittee_name,p.full_name';

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