<?php

class Person_model extends Model {

    function Person_model() {
        parent::Model();
    }

    function get_Sponsors_By_Location($location,$session) {

        $sql = "SELECT p.id AS id, p.full_name";
        $sql = $sql." FROM people p INNER JOIN roles r ON r.person_id = p.id INNER JOIN SESSION s ON (s.start_date > r.startdate OR s.start_date = r.startdate)";
        $sql = $sql." AND (s.end_date < r.enddate OR s.end_date = r.enddate) WHERE session_identifier = ?";
        $sql = $sql." AND (CASE role_type WHEN 'rep' THEN 'H' ELSE 'S' END) = ?";

        $q = $this->db->query($sql, array($session,$location));

        return ($q);
    }

    function get_most_viewed_person($session,$type) {

        $sql = 'SELECT p.*,openbama.get_person_page_view_count(p.id) AS page_view_count
                FROM people p INNER JOIN roles r ON person_id = p.id
                INNER JOIN SESSION s ON s.start_date > r.startdate AND s.end_date < r.enddate
                WHERE s.session_identifier = ? AND role_type = ?
                ORDER BY page_view_count DESC
                LIMIT 1';

        $query = $this->db->query($sql, array($session,$type));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_most_popular_person($session,$type) {

        $sql = 'SELECT p.*,openbama.Get_person_popularity(p.id) AS popularity
                FROM people p INNER JOIN roles r ON person_id = p.id
                INNER JOIN SESSION s ON s.start_date > r.startdate AND s.end_date < r.enddate
                WHERE s.session_identifier = ? AND role_type = ?
                ORDER BY popularity DESC
                LIMIT 1';

        $query = $this->db->query($sql, array($session,$type));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_person_votes($person_id,$session) {

        $sql = "SELECT r.id AS vote_id, b.id,CONCAT(b.bill_type,b.number) AS bill_number,r.vote_date,r.result,r.ayes,r.nays,
                r.abstains, r.presents,a.action_text,openbama.Get_bill_popularity(b.id) AS bill_popularity,
                CASE rcv.vote WHEN 'Y' THEN 'Aye' WHEN 'N'
                THEN 'Nay' WHEN 'P' THEN 'Present' WHEN 'A'
                THEN 'Absent' ELSE rcv.vote END AS vote
                FROM roll_calls r
                INNER JOIN bills b ON b.id = r.bill_id
                INNER JOIN actions a ON a.roll_call_id = r.id
                INNER JOIN roll_call_votes rcv ON rcv.roll_call_id = r.id
                WHERE session_identifier = ?
		AND rcv.person_id = ?
                ORDER BY r.vote_date DESC";

        $query = $this->db->query($sql, array($session,$person_id));


        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }
    }

    function get_Person_By_ID($id) {

        $this->db->where('id', $id);
        $query = $this->db->get('people');


        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_person_bio_by_id($person_id) {

        $this->db->where('person_id', $person_id);
        $query = $this->db->get('people_meta_data');


        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_person_electronic_addresses_by_id($person_id) {

        $this->db->where('person_id', $person_id);
        $this->db->order_by('web_address_type');
        $query = $this->db->get('web_addresses');


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

    function get_person_addresses_by_id($person_id) {

        $this->db->where('person_id', $person_id);
        $this->db->order_by('address_type');
        $query = $this->db->get('addresses');


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

    function get_Senators($session, $filter, $sort,$row) {

        if($filter) {
            if($filter == 'all') {
                $filter_exp = '';
            }elseif($filter == 'dem') {
                $filter_exp = " AND p.party = 'democrat'";
            }elseif($filter == 'repub') {
                $filter_exp = " AND p.party = 'republican'";
            }elseif($filter == 'other') {
                $filter_exp = " AND (p.party <> 'democrat' AND p.party <> 'republican')";
            }else {
                $filter_exp = '';
            }
        }else {
            $filter_exp = '';
        }

        if($sort) {
            if($sort == 'name') {
                $sort_exp = 'lastname asc, firstname asc';
            }elseif($sort == 'district') {
                $sort_exp = 'dist asc';
            }elseif($sort == 'viewed') {
                $sort_exp = 'page_view desc';
            }elseif($sort == 'popular') {
                $sort_exp = 'popularity_score desc';
            }else {
                $sort_exp = 'lastname asc, firstname asc';
            }
        }else {
            $sort_exp = 'lastname asc, firstname asc';
        }

        $sql = 'SELECT Get_person_popularity(p.id) AS popularity_score, Get_person_page_view_count(p.id) AS page_view,p.*,convert(p.district,signed) as dist, r.startdate, r.enddate, r.url,r.address,r.phone,';
        $sql = $sql.' r.email, (SELECT SUM(rating)/COUNT(*) FROM person_ratings WHERE person_id = p.id)';
        $sql = $sql.'  AS PersonRating, (SELECT count(*) FROM bills_cosponsors bc ';
        $sql = $sql.' inner join bills b1 on b1.id = bc.bill_id WHERE person_id = p.id AND b1.session_identifier = ?) AS CoSponsoredTotal,';
        $sql = $sql.' (SELECT COUNT(*) FROM bills WHERE sponsor_id = p.id AND session_identifier = ?) AS SponsoredBillTotal FROM people p INNER JOIN roles r ON person_id = p.id ';
        $sql = $sql.' INNER JOIN SESSION s ON s.start_date > r.startdate AND s.end_date < r.enddate';
        $sql = $sql.' WHERE s.session_identifier = ? AND role_type = "sen"';
        $sql = $sql.$filter_exp;
        $sql = $sql.' ORDER BY '.$sort_exp.' LIMIT '.$row.', 10';

        $query = $this->db->query($sql, array($session, $session, $session));

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

    function get_senators_count($session, $filter) {

        if($filter) {
            if($filter == 'all') {
                $filter_exp = '';
            }elseif($filter == 'dem') {
                $filter_exp = " AND p.party = 'democrat'";
            }elseif($filter == 'repub') {
                $filter_exp = " AND p.party = 'republican'";
            }elseif($filter == 'other') {
                $filter_exp = " AND (p.party <> 'democrat' AND p.party <> 'republican')";
            }else {
                $filter_exp = '';
            }
        }else {
            $filter_exp = '';
        }

        $sql = 'SELECT count(*) as row_count FROM people p INNER JOIN roles r ON person_id = p.id ';
        $sql = $sql.' INNER JOIN SESSION s ON s.start_date > r.startdate AND s.end_date < r.enddate';
        $sql = $sql.' WHERE s.session_identifier = ? AND role_type = "sen"';
        $sql = $sql.$filter_exp;


        $query = $this->db->query($sql, array($session));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_representatives_count($session, $filter) {

        if($filter) {
            if($filter == 'all') {
                $filter_exp = '';
            }elseif($filter == 'dem') {
                $filter_exp = " AND p.party = 'democrat'";
            }elseif($filter == 'repub') {
                $filter_exp = " AND p.party = 'republican'";
            }elseif($filter == 'other') {
                $filter_exp = " AND (p.party <> 'democrat' AND p.party <> 'republican')";
            }else {
                $filter_exp = '';
            }
        }else {
            $filter_exp = '';
        }

        $sql = 'SELECT count(*) as row_count FROM people p INNER JOIN roles r ON person_id = p.id ';
        $sql = $sql.' INNER JOIN SESSION s ON s.start_date > r.startdate AND s.end_date < r.enddate';
        $sql = $sql.' WHERE s.session_identifier = ? AND role_type = "rep"';
        $sql = $sql.$filter_exp;


        $query = $this->db->query($sql, array($session));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_Representatives($session, $sort, $filter,$row) {

        if($filter) {
            if($filter == 'all') {
                $filter_exp = '';
            }elseif($filter == 'dem') {
                $filter_exp = " AND p.party = 'democrat'";
            }elseif($filter == 'repub') {
                $filter_exp = " AND p.party = 'republican'";
            }elseif($filter == 'other') {
                $filter_exp = " AND (p.party <> 'democrat' AND p.party <> 'republican')";
            }else {
                $filter_exp = '';
            }
        }else {
            $filter_exp = '';
        }

        if($sort) {
            if($sort == 'name') {
                $sort_exp = 'lastname asc, firstname asc';
            }elseif($sort == 'district') {
                $sort_exp = 'dist asc';
            }elseif($sort == 'viewed') {
                $sort_exp = 'page_view desc';
            }elseif($sort == 'popular') {
                $sort_exp = 'popularity_score desc';
            }else {
                $sort_exp = 'lastname asc, firstname asc';
            }
        }else {
            $sort_exp = 'lastname asc, firstname asc';
        }

        $sql = 'SELECT Get_person_popularity(p.id) AS popularity_score, Get_person_page_view_count(p.id) AS page_view,p.*,convert(p.district,signed) as dist, r.startdate, r.enddate, r.url,r.address,r.phone,';
        $sql = $sql.' r.email, (SELECT SUM(rating)/COUNT(*) FROM person_ratings WHERE person_id = p.id)';
        $sql = $sql.'  AS PersonRating, (SELECT count(*) FROM bills_cosponsors bc ';
        $sql = $sql.' inner join bills b1 on b1.id = bc.bill_id WHERE person_id = p.id AND b1.session_identifier = ?) AS CoSponsoredTotal,';
        $sql = $sql.' (SELECT COUNT(*) FROM bills WHERE sponsor_id = p.id AND session_identifier = ?) AS SponsoredBillTotal FROM people p INNER JOIN roles r ON person_id = p.id ';
        $sql = $sql.' INNER JOIN SESSION s ON s.start_date > r.startdate AND s.end_date < r.enddate';
        $sql = $sql.' WHERE s.session_identifier = ? AND role_type = "rep"';
        $sql = $sql.$filter_exp;
        $sql = $sql.' ORDER BY '.$sort_exp.' LIMIT '.$row.',10';

        $query = $this->db->query($sql, array($session, $session, $session));

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

    function get_Sponsored_Bills($person_id, $session) {

        $sql = 'SELECT b.*, (select full_name from people where id = b.sponsor_id) as sponsor_name FROM bills b WHERE sponsor_id = ? AND session_identifier = ?';

        $query = $this->db->query($sql, array($person_id,$session));

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

    function get_CoSponsored_Bills($person_id, $session) {

        $sql = 'SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name FROM bills b INNER JOIN bills_cosponsors bc ON ';
        $sql = $sql.' bc.bill_id = b.id WHERE bc.person_id = ? AND b.session_identifier = ?';

        $query = $this->db->query($sql, array($person_id,$session));

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

    function get_person_committees($person_id,$session) {
        $sql = 'SELECT c.id,c.committee_name,c.subcommittee_name,cp.role ';
        $sql = $sql.' FROM committees c INNER JOIN committees_people cp ON ';
        $sql = $sql.' cp.committee_id = c.id WHERE session_identifier = ? ';
        $sql = $sql.' AND cp.person_id = ? order by 2, 3';

        $query = $this->db->query($sql, array($session, $person_id));

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

    function get_Person_Comments($person_id) {
        $sql = "SELECT * from comments where person_id = ?";

        $query = $this->db->query($sql, array($person_id));

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


    function get_page_view_stats($person_id) {
        $sql = 'SELECT DISTINCT (SELECT COUNT(*) FROM page_views p1 WHERE p1.person_id';
        $sql = $sql.' = p.person_id) AS TotalAll, (SELECT COUNT(*) FROM page_views p1 ';
        $sql = $sql.' WHERE p1.person_id = p.person_id AND DATE(viewed_on) = CURRENT_DATE';
        $sql = $sql.') AS TotalToday, (SELECT COUNT(*) FROM page_views p1 WHERE p1.person_id';
        $sql = $sql.' = p.person_id AND DATE(viewed_on) = CURRENT_DATE - 7 ) AS TotalSevenDays';
        $sql = $sql.' FROM page_views p WHERE p.person_id = ?';

        $query = $this->db->query($sql, array($person_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function insert_person_comment($person_id,$user_id,$comment,$user_name) {

        $sql = "INSERT INTO comments (person_id, user_id, comment, ";
        $sql = $sql." created_on,username) VALUES (?, ?, ?, CURRENT_TIMESTAMP, ?)";

        $this->db->query($sql,array($person_id,$user_id,$comment,$user_name));
    }

    function insert_person_rating($person_id,$user_id,$rating) {
        $sql = "INSERT INTO person_ratings (person_id, user_id, rating, created_on ";
        $sql = $sql.") VALUES (?, ?, ?, CURRENT_TIMESTAMP)";

        $this->db->query($sql,array($person_id,$user_id,$rating));

    }

    function get_user_person_rating($person_id,$user_id) {
        $sql = 'SELECT * FROM person_ratings where person_id = ? and user_id = ?';

        $query = $this->db->query($sql, array($person_id, $user_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function insert_person_view($ip,$person_id) {

        $sql = "INSERT INTO page_views (ip, person_id, viewed_on) VALUES (?, ?, CURRENT_TIMESTAMP)";

        $this->db->query($sql,array($ip,$person_id));

    //echo $this->db->affected_rows();
    }

    function update_person_rating($person_id,$user_id,$rating) {

        $sql = "Update person_ratings SET rating = ?, updated_on = CURRENT_TIMESTAMP WHERE person_id = ? and user_id = ?";

        $this->db->query($sql,array($rating,$person_id,$user_id));

        if ($this->db->affected_rows() == 0){
            $this->insert_person_rating($person_id,$user_id,$rating);
        }
    }

    function get_person_rating($person_id) {

        $sql = 'SELECT SUM(rating)/COUNT(*) AS person_rating, count(*) AS num_rated FROM person_ratings';
        $sql = $sql.' WHERE person_id = ?';

        $query = $this->db->query($sql, array($person_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }

    }

    function get_person_vote_stats($person_id) {
    //TODO: OpenBama - finish get_person_vote_stats
    }

    function get_person_terms($person_id) {
        $sql = 'SELECT * FROM roles WHERE person_id = ?';

        $query = $this->db->query($sql, array($person_id));

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

/* End of file person_model.php */
/* Location: ./system/application/models/person_model.php */