<?php

class Committee_model extends Model {

    function Committee_model() {
        parent::Model();
    }

    function get_committee_by_id($id) {

        $this->db->where('id', $id);
        $query = $this->db->get('committees');


        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function insert_committee_view($ip,$committee_id) {

        $sql = "UPDATE page_views SET viewed_on = CURRENT_TIMESTAMP WHERE ip = ? AND committee_id = ?";

        $this->db->query($sql,array($ip,$committee_id));

        if ($this->db->affected_rows() == 0) {
            $sql = "INSERT INTO page_views (ip, committee_id, viewed_on) VALUES (?, ?, CURRENT_TIMESTAMP)";
            $this->db->query($sql,array($ip,$committee_id));
        }
    }

    function get_all_committees($sort,$row_num) {

        if($sort) {
            if($sort == 'name') {
                $sort_exp = 'committee_name ASC, subcommittee_name ASC';
            }elseif($sort == 'viewed') {
                $sort_exp = 'page_views DESC, committee_name ASC, subcommittee_name ASC';
            }else {
                $sort_exp = 'committee_name ASC, subcommittee_name ASC';
            }
        }else {
            $sort_exp = '';
        }

        $sql = 'SELECT c.*,Get_committee_page_view_count(c.id) AS page_views,
            (SELECT COUNT(*)
                FROM committees c1
                WHERE c1.committee_name = c.committee_name
                AND c1.subcommittee_name IS NOT null) AS subcommittee_count
                FROM committees c
                WHERE c.active = TRUE
                ORDER BY '.$sort_exp;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {

            $row_count = 0;

            $row_max = $row_num + 10;

            foreach ($query->result() as $row) {

                if($sort == 'viewed') {
                    $data[] = $row;
                }else {
                    if(!$row->subcommittee_name) {
                        $row_count += 1;
                    }

                    if($row_count > $row_max && !$row->subcommittee_name) break;

                    if($row_count > $row_num) {
                        $data[] = $row;
                    }
                }


            }

            return $data;
        }
        else {
            return false;
        }
    }

    function get_all_committees_count() {

        $sql = 'SELECT Count(*) as row_count
                FROM committees c
                WHERE c.active = TRUE AND subcommittee_name IS NULL';

        $query = $this->db->query($sql);

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_committee_members($committee_id,$session) {


        $sql = "SELECT (CASE role WHEN 'Chair' THEN 1 WHEN 'Vice Chair' THEN 2 WHEN 'Vice Chair and Ranking Minority Member' THEN 2
                WHEN 'Vice Chair, Majority Leader Designee' THEN 2 WHEN 'Member' THEN 10 ELSE 3 END) AS ranking,cp.person_id, p.full_name, cp.role, p.district,p.party
                FROM committees_people cp
                INNER JOIN people p ON p.id = cp.person_id
                WHERE committee_id = ?
                AND session_identifier = ?
                ORDER BY ranking";

        $query = $this->db->query($sql,array($committee_id,$session));

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

    function get_committee_members_contact_info($committee_id,$session) {


        $sql = "SELECT (CASE role WHEN 'Chair' THEN 1 WHEN 'Vice Chair' THEN 2 WHEN 'Vice Chair and Ranking Minority Member' THEN 2
                WHEN 'Vice Chair, Majority Leader Designee' THEN 2 WHEN 'Member' THEN 10 ELSE 3 END) AS ranking,cp.person_id, p.full_name, cp.role, p.district,p.party,
                address_type,address_street,address_city,address_state,address_zip,phone1,phone2,fax1,fax2,toll_free,ttyd
                FROM committees_people cp
                INNER JOIN people p ON p.id = cp.person_id
                INNER JOIN addresses a ON a.person_id = p.id
                WHERE committee_id = ?
                AND session_identifier = ?
                ORDER BY ranking,p.full_name,address_type";

        $query = $this->db->query($sql,array($committee_id,$session));

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

    function get_committee_members_email_addresses($committee_id,$session) {


        $sql = "SELECT DISTINCT a.web_address
                FROM committees_people cp
                INNER JOIN people p ON p.id = cp.person_id
                INNER JOIN web_addresses a ON a.person_id = p.id
                WHERE committee_id = ?
                AND session_identifier = ?
                AND web_address_type = 'Email'";

        $query = $this->db->query($sql,array($committee_id,$session));

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

    function get_committee_subcommittees($committee_id) {


        $sql = 'SELECT *
                FROM committees
                WHERE subcommittee_name IS NOT NULL
                AND committee_name =
                (SELECT committee_name FROM committees c WHERE c.id = ?
                AND c.subcommittee_name IS NULL)';

        $query = $this->db->query($sql,array($committee_id));

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

    function get_committee_bills($committee_id, $session) {


        $sql = 'SELECT b.*,(select full_name from people where id = b.sponsor_id) as sponsor_name
                FROM bills b
                WHERE session_identifier = ?
                AND current_committee_id = ?';

        $query = $this->db->query($sql,array($session, $committee_id));

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

    function get_most_viewed_committee($session) {

        $sql = 'SELECT c.*,openbama.get_committee_page_view_count(c.id) AS page_view_count
                FROM committees c
                INNER JOIN committees_people cp ON cp.committee_id = c.id
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

    function get_committee_meetings($committee_id) {

        $sql = 'SELECT c.committee_name, cm.*
                FROM committee_meetings cm
                INNER JOIN committees c ON c.id = cm.committee_id
                WHERE cm.committee_id = ?
                order by cm.meeting_date asc ';

        $query = $this->db->query($sql, array($committee_id));

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

    function get_all_committee_meetings_for_house() {

        $sql = "SELECT c.committee_name, cm.*
                FROM committee_meetings cm
                INNER JOIN committees c ON c.id = cm.committee_id
                WHERE c.house = 'h'
                order by cm.meeting_date asc ";

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

    function get_all_committee_meetings_for_senate() {

        $sql = "SELECT c.committee_name, cm.*
                FROM committee_meetings cm
                INNER JOIN committees c ON c.id = cm.committee_id
                WHERE c.house = 's'
                order by cm.meeting_date asc ";

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

    function get_committee_meeting_detail($meeting_id) {

        $sql = 'select cm.*,c.committee_name from committee_meetings cm inner join committees c on c.id = cm.committee_id where cm.id = ?';

        $query = $this->db->query($sql, array($meeting_id));

        if($query->num_rows()== 1) {
            return $query->row();
        }
        else {
            return false;
        }
    }

    function get_committee_meeting_bills($meeting_id) {

        $sql = 'SELECT UPPER(CONCAT(b.bill_type,b.number)) AS label,cmb.*
                FROM committee_meetings_bills cmb
                INNER JOIN bills b ON b.id = cmb.bill_id
                WHERE cmb.committee_meetings_id = ?';

        $query = $this->db->query($sql, array($meeting_id));

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

/* End of file committee_model.php */
/* Location: ./system/application/models/committee_model.php */