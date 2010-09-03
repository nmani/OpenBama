<?php

class Rss_model extends Model {

    function Rss_model() {
        parent::Model();
    }


    function get_introduced_bills($session) {

        $sql = 'select id as url_title,concat(bill_type,number) as post_title,introduced as post_date,description as post_body from bills where introduced >= date_add(current_date, INTERVAL -7 DAY) and session_identifier = ? and ifnull(disabled,false) = false order by introduced desc';

        $query = $this->db->query($sql, array($session));


        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }
    }

    function get_recently_bills_acted_on($session) {

        $sql = 'select id as url_title,concat(bill_type,number) as post_title,last_action_date as post_date,description as post_body from bills where last_action_date >= DATE_ADD(CURRENT_DATE, INTERVAL -7 DAY) and session_identifier = ? and ifnull(disabled,false) = false order by last_action_date desc';

        $query = $this->db->query($sql, array($session));

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }
    }

    function get_recent_activity_by_bill_id($bill_id) {

        $sql = "SELECT bills.id AS url_title,action_text AS post_title,action_date AS post_date,action_text AS post_body FROM bills INNER JOIN actions ON bill_id = bills.id WHERE bills.id = ?
                UNION
                SELECT DISTINCT b.id AS url_title,CONCAT(CONCAT(UPPER(b.bill_type),b.number),' - Committee meeting (',c.committee_name,')') AS post_title,meeting_date AS post_date,'Committee meeting' AS post_body FROM bills b INNER JOIN committee_meetings_bills cmb ON cmb.bill_id = b.id INNER JOIN committee_meetings cm ON cm.id = cmb.committee_meetings_id
                INNER JOIN committees c ON c.id = cm.committee_id WHERE b.id = ?
                UNION
                SELECT DISTINCT bills.id AS url_title,'Sponsor added' AS post_title,sponsor_date AS post_date,'Sponsor added' AS post_body FROM bills INNER JOIN bills_cosponsors ON bill_id = bills.id WHERE bills.id = ? ORDER BY 3 desc";

        $query = $this->db->query($sql, array($bill_id,$bill_id,$bill_id));


        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }
    }

    function get_recent_activity_by_person_id($person_id) {

        $sql = "SELECT bills.id AS url_title,CONCAT(UPPER(bills.bill_type),bills.number,' - ',action_text) AS post_title,action_date AS post_date,action_text AS post_body FROM bills INNER JOIN actions ON bill_id = bills.id WHERE bills.sponsor_id = ?
                UNION
                SELECT DISTINCT bills.id AS url_title,CONCAT(UPPER(bills.bill_type),bills.number,' - ','Sponsor added') AS post_title,sponsor_date AS post_date,'Sponsor added' AS post_body FROM bills INNER JOIN bills_cosponsors ON bill_id = bills.id WHERE bills.sponsor_id = ? ORDER BY 3 DESC";

        $query = $this->db->query($sql, array($person_id,$person_id));


        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }
    }

    function get_recent_activity_by_subject_id($subject_id) {

        $sql = "SELECT bills.id AS url_title,CONCAT(UPPER(bills.bill_type),bills.number,' - ',action_text) AS post_title,action_date AS post_date,action_text AS post_body FROM bills INNER JOIN actions ON bill_id = bills.id INNER JOIN bills_subjects bs ON bs.bill_id = bills.id WHERE bs.subject_id = ?
                UNION
                SELECT DISTINCT bills.id AS url_title,CONCAT(UPPER(bills.bill_type),bills.number,' - ','Sponsor added') AS post_title,sponsor_date AS post_date,'Sponsor added' AS post_body FROM bills INNER JOIN bills_cosponsors ON bill_id = bills.id INNER JOIN bills_subjects bs ON bs.bill_id = bills.id WHERE bs.subject_id = ?";

        $query = $this->db->query($sql, array($subject_id,$subject_id));


        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }
    }
}