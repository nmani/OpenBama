<?php

class Issue_model extends Model {

    function Issue_model() {
        parent::Model();
    }

    function get_most_viewed_issue_past7days($session) {

        $sql = 'SELECT s.*,Get_issue_page_view_count_7days(id) AS page_view_count
                    FROM subjects s
                    WHERE s.id IN (
            SELECT subject_id
	FROM (SELECT subject_id,COUNT(*) AS view_count
	FROM (SELECT DISTINCT subject_id,ip
		FROM page_views
		WHERE viewed_on >= CURRENT_DATE - 7
		AND subject_id IS NOT NULL) v
		GROUP BY subject_id
		ORDER BY view_count DESC
		LIMIT 1) c
            )';

        $query = $this->db->query($sql);

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_bills_by_issue_id($issue_id,$session) {
        $sql = 'SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name
                FROM bills b
                INNER JOIN bills_subjects bs ON bs.bill_id = b.id
                WHERE session_identifier = ?
                AND bs.subject_id = ?';

        $query = $this->db->query($sql, array($session,$issue_id));

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

    function insert_issue_view($ip,$issue_id) {

        $sql = "UPDATE page_views SET viewed_on = CURRENT_TIMESTAMP WHERE ip = ? AND subject_id = ?";

        $this->db->query($sql,array($ip,$issue_id));

        if ($this->db->affected_rows() == 0) {
            $sql = "INSERT INTO page_views (ip, subject_id, viewed_on) VALUES (?, ?, CURRENT_TIMESTAMP)";
            $this->db->query($sql,array($ip,$issue_id));
        }
        
    }

    function get_all_issues($session, $sort) {

        if($sort) {
            if($sort == 'name') {
                $sort_exp = 'subject ASC';
            }elseif($sort == 'viewed') {
                $sort_exp = 'page_views DESC, subject ASC';
            }elseif($sort == 'bills') {
                $sort_exp = 'bill_count DESC, subject ASC';
            }else {
                $sort_exp = 'subject ASC';
            }
        }else {
            $sort_exp = 'subject ASC';
        }

        $sql = 'select id,subject,Get_issue_page_view_count(id) AS page_views,Get_issue_bill_count(id) AS bill_count ';
        $sql = $sql.' from (SELECT DISTINCT s.id,s.subject FROM subjects s INNER JOIN ';
        $sql = $sql.' bills_subjects bs ON bs.subject_id = s.id INNER JOIN ';
        $sql = $sql.' bills b ON b.id = bs.bill_id WHERE ';
        $sql = $sql.' b.session_identifier = ?) issues WHERE length(subject) > 0 ORDER BY '.$sort_exp;

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

    function get_issue_by_id($issue_id) {
        $sql = 'select * from subjects where id = ?';

        $query = $this->db->query($sql, array($issue_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_issue_bill_count_list() {

        $sql = 'SELECT s.subject,(SELECT COUNT(*) FROM bills_subjects bs ';
        $sql = $sql.' WHERE bs.subject_id = s.id) AS BillCount FROM subjects s';
        $sql = $sql.' ORDER BY s.subject';

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

    function get_issue_list_most_viewed() {
    //TODO: OpenBama - finish get_issue_list_most_viewed
        $sql = 'SELECT s.subject,(SELECT COUNT(*) FROM bills_subjects bs ';
        $sql = $sql.' WHERE bs.subject_id = s.id) AS BillCount FROM subjects s';
        $sql = $sql.' ORDER BY s.subject';


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

    
}
/* End of file issue_model.php */
/* Location: ./system/application/models/issue_model.php */
