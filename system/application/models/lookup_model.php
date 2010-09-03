<?php
class Lookup_model extends Model {

    function Lookup_model() {
        parent::Model();
    }

    function get_sponsor_list($session,$location) {

        $sql = "SELECT p.id, REPLACE(CONCAT(UPPER(r.role_type),'.', ' ',firstname,' ',IFNULL(middlename,''),' ', lastname,' ', IFNULL(suffix,'')),'  ',' ') AS fullname";
        $sql = $sql." FROM people p INNER JOIN roles r ON r.person_id = p.id INNER JOIN SESSION s ON (s.start_date > r.startdate OR s.start_date = r.startdate)";
        $sql = $sql." AND (s.end_date < r.enddate OR s.end_date = r.enddate) WHERE session_identifier = ?";
        $sql = $sql." AND (CASE role_type WHEN 'rep' THEN 'H' ELSE 'S' END) = ?";

        $q = $this->db->query($sql, array($session,$location));

        if($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }

            return $data;
        }else {
            return false;
        }
    }

    function get_subjects_list($session) {

        $sql = "SELECT DISTINCT s.id,(CASE LENGTH(s.subject) WHEN 0 THEN ' [No Subject]' ELSE s.subject END) AS subject FROM subjects s INNER JOIN
         bills_subjects bs ON bs.subject_id = s.id INNER JOIN
        bills b ON b.id = bs.bill_id WHERE
        b.session_identifier = ? ORDER BY SUBJECT";

        $q = $this->db->query($sql,array($session));

        if($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }

            return $data;
        }else {
            return false;
        }
    }

    function get_action_date_list($session) {

        $sql = "SELECT DISTINCT action_date
                    FROM actions
                    INNER JOIN bills b ON b.id = bill_id
                    WHERE session_identifier = ?
                    ORDER BY 1";

        $q = $this->db->query($sql,array($session));

        if($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }

            return $data;
        }else {
            return false;
        }
    }
}

/* End of file lookup_model.php */
/* Location: ./system/application/models/lookup_model.php */