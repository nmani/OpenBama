<?php

class Bill_model extends Model {

    function Bill_model() {
        parent::Model();
    }

    function bill_search($search_string = NULL) {
        $this->load->library('sphinx');
		$this->sphinx->SetServer(FULL_TEXT_SERVER,FULL_TEXT_SERVER_PORT);
        $this->sphinx->SetArrayResult(TRUE);
        $result = $this->sphinx->Query($search_string);

        $where = ' where id in (';
        if ( $result['total'] > 0) {
            foreach ($result['matches'] as $row) {

                $where = $where.$row['id'].',';
            //$this->db->or_where('id', $row['id']);
            }
        }else {
            return false;
        }

        $where = $where.'-1) and disabled = false';

        //$this->db->select('(select full_name from people where id = bills.sponsor_id) as sponsor_name', FALSE);

        //$query = $this->db->get('bills');

        $sql = 'select b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name from bills b '.$where;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }


    }


    /**
     * Gets all bills for the given session.
     *
     * @return void
     * @author Stephen Jackson
     **/
    function get_All($session, $sort, $filter, $row) {

        if($sort) {
            if($sort == 'intro') {
                $sort_exp = 'introduced desc';
            }elseif($sort == 'recent') {
                $sort_exp = 'last_action_date desc';
            }elseif($sort == 'viewed') {
                $sort_exp = 'page_views desc';
            }elseif($sort == 'popular') {
                $sort_exp = 'bill_popularity desc';
            }elseif($sort == 'most') {
                $sort_exp = 'sponsor_count desc';
            }else {
                $sort_exp = 'introduced desc';
            }
        }else {
            $sort_exp = 'introduced desc';
        }

        if($filter) {
            if($filter == 'all') {
                $filter_exp = '';
            }elseif($filter == 'house') {
                $filter_exp = " AND bill_type like 'h%'";
            }elseif($filter == 'senate') {
                $filter_exp = " AND bill_type like 's%'";
            }elseif($filter == 'bills') {
                $filter_exp = " AND bill_type not like '%r%'";
            }elseif($filter == 'resolutions') {
                $filter_exp = " AND bill_type like '%r%'";
            }else {
                $filter_exp = '';
            }
        }else {
            $filter_exp = '';
        }

        $sql = 'SELECT id,session_identifier,
	bill_type,
	number,
	introduced,
	sponsor_id,
        (select full_name from people where id = b.sponsor_id) as sponsor_name,
	last_action,
	last_vote_date,
	last_vote_where,
	last_vote_roll,
	togovernor_date,
	description,
	updated,
	last_action_date,
	subject,
	current_alison_status,
	current_committee_id,
        Get_bill_page_view_count(b.id) AS page_views,
        Get_bill_popularity(b.id) AS bill_popularity,
        Get_bill_sponsor_count(b.id) AS sponsor_count';

        $sql = $sql.' FROM bills b where ifnull(disabled,false) = false and session_identifier = ? '.$filter_exp;
        $sql = $sql.' order by '.$sort_exp.' LIMIT '.$row.',50';

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

    function get_all_count($session, $filter) {

        if($filter) {
            if($filter == 'all') {
                $filter_exp = '';
            }elseif($filter == 'house') {
                $filter_exp = " AND bill_type like 'h%'";
            }elseif($filter == 'senate') {
                $filter_exp = " AND bill_type like 's%'";
            }elseif($filter == 'bills') {
                $filter_exp = " AND bill_type not like '%r%'";
            }elseif($filter == 'resolutions') {
                $filter_exp = " AND bill_type like '%r%'";
            }else {
                $filter_exp = '';
            }
        }else {
            $filter_exp = '';
        }

        $sql = 'SELECT count(*) as row_count';

        $sql = $sql.' FROM bills b where ifnull(disabled,false) = false and session_identifier = ? '.$filter_exp;

        $query = $this->db->query($sql, array($session));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_bill_dem_support($bill_id) {

        $sql = "SELECT Count(* ) AS party_support
                FROM   (SELECT p.party
        FROM   bills b
               INNER JOIN people p
                 ON p.id = b.sponsor_id
        WHERE  b.id = ?
               AND p.party = 'Democrat'
        UNION ALL
        SELECT p.party AS party
        FROM   bills_cosponsors b
               INNER JOIN people p
                 ON p.id = b.person_id
               INNER JOIN bills b1
                 ON b1.id = b.bill_id
        WHERE  b1.id = ?
               AND p.party = 'Democrat') party_dem";

        $query = $this->db->query($sql, array($bill_id,$bill_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }

    }

    function get_bill_repub_support($bill_id) {

        $sql = "SELECT Count(* ) AS party_support
FROM   (SELECT p.party
        FROM   bills b
               INNER JOIN people p
                 ON p.id = b.sponsor_id
        WHERE  b.id = ?
               AND p.party = 'Republican'
        UNION ALL
        SELECT p.party AS party
        FROM   bills_cosponsors b
               INNER JOIN people p
                 ON p.id = b.person_id
               INNER JOIN bills b1
                 ON b1.id = b.bill_id
        WHERE  b1.id = ?
               AND p.party = 'Republican') party_repub";

        $query = $this->db->query($sql, array($bill_id,$bill_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }

    }

    /**
     * Gets all bills for House of Reps for the given session.
     *
     * @return void
     * @author Stephen Jackson
     **/
    function get_All_House($session, $sort) {

        if($sort) {
            if($sort == 'intro') {
                $sort_exp = 'introduced desc';
            }elseif($sort == 'recent') {
                $sort_exp = 'last_action_date desc';
            }elseif($sort == 'viewed') {
                $sort_exp = 'page_views desc';
            }elseif($sort == 'popular') {
                $sort_exp = 'bill_popularity desc';
            }elseif($sort == 'most') {
                $sort_exp = 'sponsor_count desc';
            }else {
                $sort_exp = 'introduced desc';
            }
        }else {
            return false;
        }

        $sql = 'SELECT id,session_identifier,
	bill_type,
	number,
	introduced,
	sponsor_id,
        (select full_name from people where id = b.sponsor_id) as sponsor_name,
	last_action,
	last_vote_date,
	last_vote_where,
	last_vote_roll,
	togovernor_date,
	description,
	updated,
	last_action_date,
	subject,
	current_alison_status,
	current_committee_id,
        Get_bill_page_view_count(b.id) AS page_views,
        Get_bill_popularity(b.id) AS bill_popularity,
        Get_bill_sponsor_count(b.id) AS sponsor_count';

        $sql = $sql.' FROM bills b where disabled = false and bill_type like ? and session_identifier = ? order by '.$sort_exp;

        $query = $this->db->query($sql, array('h%',$session));

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }
    }

    function get_All_Recent($session) {

        $this->db->where('session_identifier', $session);

        $this->db->where('last_action_date >', now());
        $this->db->where('disabled =', false);
        $this->db->order_by('introduced','desc');
        $query = $this->db->get('bills');


        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }
    }

    function get_Only_Bills($session) {
        $types = array('sb', 'hb');

        $this->db->where('session_identifier', $session);
        $this->db->where_in('bill_type', $types);
        $this->db->where('disabled =', false);
        $this->db->order_by('introduced','desc');
        $query = $this->db->get('bills');


        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }
    }

    function get_Only_Resolutions($session) {
        $types = array('sb', 'hb');

        $this->db->where('session_identifier', $session);
        $this->db->where('ifnull(disabled,false)', false);
        $this->db->where_not_in('bill_type', $types);
        $this->db->order_by('introduced','desc');
        $query = $this->db->get('bills');


        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }

    }

    function get_All_Senate($session, $sort) {

        if($sort) {
            if($sort == 'intro') {
                $sort_exp = 'introduced desc';
            }elseif($sort == 'recent') {
                $sort_exp = 'last_action_date desc';
            }elseif($sort == 'viewed') {
                $sort_exp = 'page_views desc';
            }elseif($sort == 'popular') {
                $sort_exp = 'bill_popularity desc';
            }elseif($sort == 'most') {
                $sort_exp = 'sponsor_count desc';
            }else {
                $sort_exp = 'introduced desc';
            }
        }else {
            return false;
        }

        $sql = 'SELECT id,session_identifier,
	bill_type,
	number,
	introduced,
	sponsor_id,
        (select full_name from people where id = b.sponsor_id) as sponsor_name,
	last_action,
	last_vote_date,
	last_vote_where,
	last_vote_roll,
	togovernor_date,
	description,
	updated,
	last_action_date,
	subject,
	current_alison_status,
	current_committee_id,
        Get_bill_page_view_count(b.id) AS page_views,
        Get_bill_popularity(b.id) AS bill_popularity,
        Get_bill_sponsor_count(b.id) AS sponsor_count';

        $sql = $sql.' FROM bills b where disabled = false and bill_type like ? and session_identifier = ? order by '.$sort_exp;

        $query = $this->db->query($sql, array('s%',$session));

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

    function get_Bill_Detail_By_ID($id) {
        $sql = "SELECT (select raw_html from fiscal_notes where bill_id = b.id) as fiscal_note,b.*,ifnull(p.full_name,'No Sponsor') AS sponsor,p.party,p.district,
(SELECT   action_type
        FROM     actions a
        WHERE    deleteddate is null and action_type IS NOT NULL
        AND a.bill_id = b.id
                 AND action_type IN ('introduced','vote1','vote2','togovernor',
                                     'veto','override','enacted')
        ORDER BY action_date DESC,
                 (CASE action_type
                    WHEN 'introduced'
                    THEN 1
                    WHEN 'vote1'
                    THEN 2
                    WHEN 'vote2'
                    THEN 3
                    WHEN 'togovernor'
                    THEN 4
                    WHEN 'veto'
                    THEN 5
                    WHEN 'override'
                    THEN 6
                    WHEN 'enacted'
                    THEN 7
                    ELSE 0
                  END) DESC
        LIMIT    1) AS bill_status
         FROM bills b LEFT OUTER JOIN people p ";
        $sql = $sql.' ON p.id = b.sponsor_id WHERE b.id = ?';

        $query = $this->db->query($sql, array($id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_most_viewed_bill($session) {

        $sql = 'SELECT b.*,p.page_view_count AS page_view_count
                FROM page_view_counts p
                INNER JOIN bills b ON b.id = p.bill_id
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

    function get_most_popular_bill($session) {

        $sql = 'SELECT b.*
                FROM bills b
                WHERE b.id = (select bill_id from most_popular where id = 1)';

        $query = $this->db->query($sql, array($session));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_popular_bill($session) {

        $sql = 'SELECT b.*,Get_bill_popularity(b.id) AS bill_popularity
                FROM bills b
                WHERE session_identifier = ?
                ORDER BY bill_popularity DESC
                LIMIT 1';

        $query = $this->db->query($sql, array($session));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_bill_status_list_by_id($bill_id) {

        $sql = "SELECT action_type, result,action_date
                FROM actions a
                WHERE deleteddate is null and action_type IS NOT NULL
                AND bill_id = ?
                ORDER BY (CASE action_type WHEN 'introduced' THEN 1 WHEN 'vote1'
                THEN 2 WHEN 'vote2' THEN 3 WHEN 'togovernor' THEN 4 WHEN 'veto'
                THEN 5 WHEN 'override' THEN 6 WHEN 'enacted' THEN 7 ELSE 0 END)
                ASC ";

        $query = $this->db->query($sql, array($bill_id));

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

    function get_bills_by_subject_id($subject_id,$session) {

        $sql = 'SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name FROM bills b WHERE b.id IN (SELECT bill_id FROM ';
        $sql = $sql.' bills_subjects WHERE subject_id = ?) ';
        $sql = $sql.' AND session_identifier = ? and disabled = false order by b.bill_type,b.number';

        $query = $this->db->query($sql, array($subject_id,$session));

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

    function get_committee_meetings_for_bill($bill_id) {

        $sql = 'SELECT cmb.bill_id,c.committee_name, cm.*
                FROM committee_meetings cm
                INNER JOIN committees c ON c.id = cm.committee_id
                INNER JOIN committee_meetings_bills cmb ON cmb.committee_meetings_id = cm.id
                WHERE cmb.bill_id = ?';

        $query = $this->db->query($sql, array($bill_id));

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

    function get_Bills_By_Number($bill_number, $session) {

        $sql = 'SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name FROM bills b WHERE ifnull(disabled,false) = false and CONCAT(bill_type,number) = lower(?) AND session_identifier = ? order by b.bill_type,b.number';

        $query = $this->db->query($sql, array($bill_number,$session));

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

    function get_Bills_By_CoSponsor($sponsor_id,$session) {

        $sql = 'SELECT b.*,bc.sponsor_date,(select full_name from people where id = b.sponsor_id) as sponsor_name FROM bills b ';
        $sql = $sql.'INNER JOIN bills_cosponsors bc ON bc.bill_id = b.id WHERE ';
        $sql = $sql.'b.session_identifier = ? AND bc.person_id = ? and ifnull(disabled,false) = false order by b.bill_type,b.number';

        $query = $this->db->query($sql, array($session,$sponsor_id));

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

    function get_Bills_By_Sponsor($sponsor_id,$session) {

        $sql = 'SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name FROM bills b WHERE session_identifier = ? AND ';
        $sql = $sql.'sponsor_id = ? and ifnull(disabled,false) = false order by b.bill_type,b.number';

        $query = $this->db->query($sql, array($session,$sponsor_id));

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

    function get_All_Bill_CoSponsors($bill_id) {

        $sql = 'SELECT p.full_name,p.id,sponsor_date,p.party,p.district FROM bills_cosponsors bc ';

        $sql = $sql.'INNER JOIN people p ON p.id = bc.person_id WHERE bill_id = ?';

        $query = $this->db->query($sql, array($bill_id));

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

    function get_bills_by_action_date($action_date,$session){

        $sql = "SELECT DISTINCT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name
                FROM bills b inner join actions a on b.id = a.bill_id WHERE ifnull(disabled,false) = false and action_date BETWEEN STR_TO_DATE(?, '%m-%d-%Y') AND DATE_ADD(STR_TO_DATE(?, '%m-%d-%Y'),INTERVAL 1 DAY) AND session_identifier = ? order by b.bill_type,b.number";

        $query = $this->db->query($sql, array($action_date,$action_date,$session));

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

    function get_Bills_By_Introduced_Date($from_date,$to_date,$session) {

        $sql = "SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name
FROM bills b WHERE ifnull(disabled,false) = false and introduced BETWEEN STR_TO_DATE(?, '%m/%d/%Y') AND DATE_ADD(STR_TO_DATE(?, '%m/%d/%Y'),INTERVAL 1 DAY) AND session_identifier = ? order by b.bill_type,b.number";

        $query = $this->db->query($sql, array($from_date,$to_date,$session));

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

    function get_Bills_By_Last_Action_Date($from_date,$to_date,$session) {

        $sql = "SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name FROM bills b WHERE ifnull(disabled,false) = false and last_action_date BETWEEN STR_TO_DATE(?, '%m/%d/%Y') AND DATE_ADD(STR_TO_DATE(?, '%m/%d/%Y'),INTERVAL 1 DAY) AND session_identifier = ? order by b.bill_type,b.number";

        $query = $this->db->query($sql, array($from_date,$to_date,$session));

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

    function get_Bills_By_Last_Vote_Date($from_date,$to_date,$session) {

        $sql = "SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name";
        $sql = $sql." FROM bills b WHERE ifnull(disabled,false) = false and last_vote_date BETWEEN STR_TO_DATE(?, '%m/%d/%Y') AND DATE_ADD(STR_TO_DATE(?, '%m/%d/%Y'),INTERVAL 1 DAY) AND session_identifier = ? order by b.bill_type,b.number";

        $query = $this->db->query($sql, array($from_date,$to_date,$session));

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

    function get_Bills_By_Enacted_Date($from_date,$to_date,$session) {

        $sql = "SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name
FROM bills b WHERE ifnull(disabled,false) = false and session_identifier = ? AND EXISTS (SELECT * FROM actions a
WHERE deleteddate is null and a.bill_id = b.id AND action_date BETWEEN STR_TO_DATE(?, '%m/%d/%Y') AND DATE_ADD(STR_TO_DATE(?, '%m/%d/%Y'),INTERVAL 1 DAY) AND action_type = 'enacted') order by b.bill_type,b.number";

        $query = $this->db->query($sql, array($session,$from_date,$to_date));

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

    function get_Bills_By_Sponsor_Added_Date($from_date,$to_date,$session) {

        $sql = "SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name FROM bills b WHERE ifnull(disabled,false) = false and session_identifier = ? AND EXISTS (SELECT * FROM bills_cosponsors cs WHERE cs.bill_id = b.id AND sponsor_date BETWEEN STR_TO_DATE(?, '%m/%d/%Y') AND DATE_ADD(STR_TO_DATE(?, '%m/%d/%Y'),INTERVAL 1 DAY)) order by b.bill_type,b.number";

        $query = $this->db->query($sql, array($session,$from_date,$to_date));

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

    function get_bill_text($bill_id, $version_type) {
        $sql = 'SELECT n.id,n.node_text FROM bills_text_nodes n ';
        $sql = $sql.'INNER JOIN bills_text_versions v ON v.id = ';
        $sql = $sql.'n.bills_text_versions_id WHERE v.bill_id = ? AND ';
        $sql = $sql.'version_type = ? ORDER BY n.id ASC ';

        $query = $this->db->query($sql, array($bill_id,$version_type));

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

    function get_bill_actions($bill_id) {
        $sql = 'SELECT a.*, ba.amendmentidentifier FROM actions a left outer join bills_amendments ba on ba.id = a.amendment_id';
        $sql = $sql.' WHERE deleteddate is null and a.bill_id = ? ORDER BY action_date ASC, a.id';

        $query = $this->db->query($sql, array($bill_id));

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

    function get_related_bills($bill_id) {

        $sql ='SELECT * FROM bills WHERE disabled = false and id IN (SELECT related_bill_id FROM bills_relations';
        $sql = $sql.' WHERE bill_id = ? UNION SELECT bill_id FROM bills_relations WHERE related_bill_id = ?)';

        $query = $this->db->query($sql, array($bill_id,$bill_id));

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

    function get_bills_by_status($status, $session) {

        $sql = "SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name,
       (SELECT   action_type
        FROM     actions a
        WHERE    deleteddate is null and action_type IS NOT NULL
        AND a.bill_id = b.id
                 AND action_type IN ('introduced','vote1','vote2','togovernor',
                                     'veto','override','enacted')
        ORDER BY action_date DESC,
                 (CASE action_type
                    WHEN 'introduced'
                    THEN 1
                    WHEN 'vote1'
                    THEN 2
                    WHEN 'vote2'
                    THEN 3
                    WHEN 'togovernor'
                    THEN 4
                    WHEN 'veto'
                    THEN 5
                    WHEN 'override'
                    THEN 6
                    WHEN 'enacted'
                    THEN 7
                    ELSE 0
                  END) DESC
        LIMIT    1) AS bill_status
FROM   bills b
WHERE  b.session_identifier = ?
and ifnull(b.disabled,false) = false
HAVING bill_status = ?
order by b.bill_type, b.number";

        $query = $this->db->query($sql, array($session,$status));

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

    function get_bill_version_types($bill_id) {

        $sql = "SELECT DISTINCT version_type, CASE WHEN version_type = 'int' ";
        $sql = $sql."THEN 'Introduced' WHEN version_type = 'eng' THEN 'Engrosed' ELSE 'Enrolled' END AS version_type_desc ";
        $sql = $sql.", CASE WHEN version_type = 'int' THEN 1 WHEN version_type = 'eng' THEN 2 ELSE 3 END AS order_num FROM bills_text_versions WHERE ";
        $sql = $sql.'bill_id = ? order by 3';

        $query = $this->db->query($sql, array($bill_id));

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

    function get_bill_committees($bill_id) {
        $sql = 'SELECT ? AS bill_id, c.id AS id,c.committee_name AS committee_name,c.subcommittee_name, house,bc.activity';
        $sql = $sql.' FROM bills_committees bc INNER JOIN committees c ON ';
        $sql = $sql.' c.id = bc.committee_id WHERE bc.bill_id = ?';

        $query = $this->db->query($sql, array($bill_id,$bill_id));

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

    function insert_bill_view($ip,$bill_id) {

        $sql = "UPDATE page_views SET viewed_on = CURRENT_TIMESTAMP WHERE ip = ? AND bill_id = ?";

        $this->db->query($sql,array($ip,$bill_id));

        if ($this->db->affected_rows() == 0) {
            $sql = "INSERT INTO page_views (ip, bill_id, viewed_on) VALUES (?, ?, CURRENT_TIMESTAMP)";
            $this->db->query($sql,array($ip,$bill_id));
        }

    }

    function get_bill_user_vote($bill_id,$user_id) {
        $sql = 'SELECT * FROM bill_votes where bill_id = ? and user_id = ?';

        $query = $this->db->query($sql, array($bill_id, $user_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function insert_bill_vote($bill_id,$user_id,$vote) {

        $sql = "INSERT INTO bill_votes (bill_id, user_id, support, vote_date) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";

        $this->db->query($sql,array($bill_id,$user_id,$vote));
    }

    function update_bill_vote($bill_votes_id, $vote) {

        $sql = "Update bill_votes SET support = ?, vote_date = CURRENT_TIMESTAMP WHERE id = ?";

        $this->db->query($sql,array($vote,$bill_votes_id));
    }

    function get_bill_support_status_for_user($bill_id,$user_id) {

        $sql = 'select support from bill_votes where user_id = ? and bill_id = ?';

        $query = $this->db->query($sql, array($user_id,$bill_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_bill_comments($bill_id) {
        $sql = "SELECT c.id,c.comment,c.bill_id,c.created_on,u.username
 from comments c inner join users u on u.id = c.user_id where c.bill_id = ?";

        $query = $this->db->query($sql, array($bill_id));

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

    function insert_bill_comment($bill_id,$user_id,$comment,$user_name) {

        $sql = "INSERT INTO comments (bill_id, user_id, comment, ";
        $sql = $sql." created_on,username) VALUES (?, ?, ?, CURRENT_TIMESTAMP, ?)";

        $this->db->query($sql,array($bill_id,$user_id,$comment,$user_name));
    }

    function get_page_view_stats($bill_id) {

        $sql = 'SELECT (SELECT COUNT(DISTINCT ip) FROM page_views pl WHERE pl.bill_id = b.id AND CAST(viewed_on AS DATE) = CURRENT_DATE) AS TotalToday,';
        $sql = $sql.'(SELECT COUNT(DISTINCT ip) FROM page_views pl WHERE pl.bill_id = b.id AND (CAST(viewed_on AS DATE) > CURRENT_DATE - 7 OR CAST(viewed_on AS DATE) = CURRENT_DATE - 7)) AS Total7Days,';
        $sql = $sql.'(SELECT COUNT(DISTINCT ip) FROM page_views pl WHERE pl.bill_id = b.id) AS TotalAll';
        $sql = $sql.' FROM bills b';
        $sql = $sql.' WHERE b.id = ?';

        //$sql = 'SELECT DISTINCT (SELECT COUNT(*) FROM page_views p1 WHERE p1.bill_id';
        //$sql = $sql.' = p.bill_id) AS TotalAll, (SELECT COUNT(*) FROM page_views p1 ';
        //$sql = $sql.' WHERE p1.bill_id = p.bill_id AND DATE(viewed_on) = CURRENT_DATE';
        //$sql = $sql.') AS TotalToday, (SELECT COUNT(*) FROM page_views p1 WHERE p1.bill_id';
        //$sql = $sql.' = p.bill_id AND DATE(viewed_on) > CURRENT_DATE - 7 ) AS TotalSevenDays';
        //$sql = $sql.' FROM page_views p WHERE p.bill_id = ?';

        $query = $this->db->query($sql, array($bill_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_html_repository_for_session($session) {
        $sql = 'select * from session where session_identifier = ?';


        $query = $this->db->query($sql, array($session));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_bill_rating($bill_id) {

    //Columns returned: bill_id,TotalVote,TotalSupport,TotalNotSupport,
    //and PercentSupport
        $sql = 'SELECT DISTINCT bv.bill_id, (SELECT COUNT(*) FROM bill_votes bv1 ';
        $sql = $sql.'WHERE bv1.bill_id = bv.bill_id) AS TotalVote,(SELECT COUNT(*)FROM ';
        $sql = $sql.'bill_votes bv1 WHERE bv1.bill_id = bv.bill_id AND support = TRUE) ';
        $sql = $sql.'AS TotalSupport, (SELECT COUNT(*) FROM bill_votes bv1 WHERE ';
        $sql = $sql.'bv1.bill_id = bv.bill_id AND support = FALSE) AS TotalNotSupport, ';
        $sql = $sql.'( (SELECT COUNT(*) FROM bill_votes bv1 WHERE bv1.bill_id = bv.bill_id AND ';
        $sql = $sql.' support = TRUE)/ (SELECT COUNT(*) FROM bill_votes bv1 WHERE ';
        $sql = $sql.' bv1.bill_id = bv.bill_id)) * 100 AS PercentSupport FROM bill_votes bv';
        $sql = $sql.' WHERE bill_id = ?';


        $query = $this->db->query($sql, array($bill_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

}

/* End of file bill_model.php */
/* Location: ./system/application/models/bill_model.php */