<?php

class Vote_model extends Model {

    function Vote_model() {
        parent::Model();
    }

    function get_most_viewed_vote($session) {

        $sql = 'SELECT a.action_text,rc.*,CONCAT(b.bill_type,b.number) AS bill_label,openbama.get_roll_call_page_view_count(rc.id) AS page_view_count
                FROM roll_calls rc
                INNER JOIN bills b ON b.id = rc.bill_id
                INNER JOIN actions a ON a.roll_call_id = rc.id
                WHERE session_identifier = ?
                ORDER BY page_view_count DESC
                LIMIT 1';

        $query = $this->db->query($sql, array($session));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_roll_call_stats($vote_id) {

        $sql = "SELECT
(CASE r.vote WHEN 'Y' THEN 1 WHEN 'N' THEN 2 WHEN 'A' THEN 3 WHEN 'P' THEN 4 ELSE 5 END)  AS order_num,
r.vote,
                         (SELECT COUNT(*)
                         FROM    roll_call_votes r2
                                 INNER JOIN people p2
                                 ON      p2.id   = r2.person_id
                         WHERE   r2.roll_call_id = ?
                         AND     p2.party        = 'Democrat'
                         AND     r2.vote         = r.vote
                         ) AS dem_count,
                         (SELECT COUNT(*)
                         FROM    roll_call_votes r2
                                 INNER JOIN people p2
                                 ON      p2.id   = r2.person_id
                         WHERE   r2.roll_call_id = ?
                         AND     p2.party        = 'Republican'
                         AND     r2.vote         = r.vote
                         )        AS repub_count,
                         COUNT(*) AS vote_count
                FROM     roll_call_votes r
                         INNER JOIN people p
                         ON       p.id = r.person_id
                WHERE    roll_call_id  = ?
                GROUP BY r.vote
                ORDER BY order_num";

        $query = $this->db->query($sql, array($vote_id,$vote_id,$vote_id));

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }
    }

    function get_roll_call_votes($vote_id) {

        $sql = "SELECT r.*,p.full_name,p.district, p.party,
(CASE r.vote WHEN 'Y' THEN 'Aye' WHEN 'N'
                THEN 'Nay' WHEN 'P' THEN 'Pass' WHEN 'A'
                THEN 'Absent' ELSE r.vote END) AS vote_text
                FROM roll_call_votes r
                INNER JOIN people p ON p.id = r.person_id
                WHERE roll_call_id = ?";

        $query = $this->db->query($sql, array($vote_id));

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }

    }

    function get_vote_by_id($vote_id) {

        $sql = 'SELECT r.*,a.action_text, CONCAT(b.bill_type,b.number) AS bill_label,
                b.description
                FROM roll_calls r
                INNER JOIN actions a ON a.roll_call_id = r.id
                INNER JOIN bills b ON b.id = r.bill_id
                WHERE r.id = ? and a.deleteddate is null';

        $query = $this->db->query($sql,array($vote_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function insert_vote_view($ip,$vote_id) {

        $sql = "INSERT INTO page_views (ip, roll_calls_id, viewed_on) VALUES (?, ?, CURRENT_TIMESTAMP)";

        $this->db->query($sql,array($ip,$vote_id));

    //echo $this->db->affected_rows();
    }

    function get_bill_vote($vote_id) {
    //TODO: OpenBama - finish get_bill_vote
    }

    function get_votes($sort, $filter, $session,$row) {

        if($sort) {
            if($sort == 'new') {
                $sort_exp = 'vote_date DESC';
            }elseif($sort == 'old') {
                $sort_exp = 'vote_date ASC';
            }elseif($sort == 'popular') {
                $sort_exp = 'bill_popularity DESC';
            }else {
                $sort_exp = 'vote_date DESC';
            }
        }else {
            $sort_exp = 'vote_date DESC';
        }

        if($filter) {
            if($filter == 'all') {
                $filter_exp = '';
            }elseif($filter == 'house') {
                $filter_exp = " AND r.location = 'h'";
            }elseif($filter == 'senate') {
                $filter_exp = " AND r.location = 's'";
            }elseif($filter == 'pass') {
                $filter_exp = " AND r.result = 'PASSED'";
            }elseif($filter == 'fail') {
                $filter_exp = " AND r.result = 'LOST'";
            }else {
                $filter_exp = '';
            }
        }else {
            $filter_exp = '';
        }

        $sql = 'SELECT r.id as vote_id, b.id,CONCAT(b.bill_type,b.number) AS bill_number,r.vote_date,r.result,r.ayes,r.nays,
                r.abstains, r.presents,a.action_text,Get_bill_popularity(b.id) AS bill_popularity
                FROM roll_calls r
                INNER JOIN bills b ON b.id = r.bill_id
                INNER JOIN actions a ON a.roll_call_id = r.id
                WHERE session_identifier = ? '.$filter_exp.' ORDER BY '.$sort_exp.' LIMIT '.$row.', 10';

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

    function get_votes_count($filter, $session) {

        if($filter) {
            if($filter == 'all') {
                $filter_exp = '';
            }elseif($filter == 'house') {
                $filter_exp = " AND r.location = 'h'";
            }elseif($filter == 'senate') {
                $filter_exp = " AND r.location = 's'";
            }elseif($filter == 'pass') {
                $filter_exp = " AND r.result = 'PASSED'";
            }elseif($filter == 'fail') {
                $filter_exp = " AND r.result = 'LOST'";
            }else {
                $filter_exp = '';
            }
        }else {
            $filter_exp = '';
        }

        $sql = 'SELECT Count(*) as row_count
                FROM roll_calls r
                INNER JOIN bills b ON b.id = r.bill_id
                INNER JOIN actions a ON a.roll_call_id = r.id
                WHERE session_identifier = ? '.$filter_exp;

        $query = $this->db->query($sql, array($session));


        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }

    }
}

/* End of file vote_model.php */
/* Location: ./system/application/models/vote_model.php */