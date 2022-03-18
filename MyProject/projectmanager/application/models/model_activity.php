<?php
    class Model_activity extends CI_Model
    {

		public function getAllStatus($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.id_status, a.nm_status, a.active");
            $this->db->from("ref_status a");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_status  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

		

        public function getAllprogram($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.id_program, a.nm_program, a.due, a.id_status, b.nm_status, a.active");
            $this->db->from("tr_program a");
			$this->db->join("ref_status b", "a.id_status = b.id_status", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_program  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

		
		
		public function getAllprogram_detail($show=null, $start=null, $cari=null, $id_program)
        {
            $this->db->select("a.id_program_detail, a.nm_program_detail, a.due, a.id_status, b.nm_status, a.active");
            $this->db->from("tr_program_detail a");
			$this->db->join("ref_status b", "a.id_status = b.id_status", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_program', $id_program);
            $this->db->where("(a.nm_program_detail  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

		public function getAllpic($show=null, $start=null, $cari=null, $id_program)
        {
            $this->db->select("a.id_pic, a.id_user, b.nm_user, a.id_bu, c.nm_bu, a.active");
            $this->db->from("tr_pic a");
			$this->db->join("ref_user b", "a.id_user = b.id_user", "left");
			$this->db->join("ref_bu c", "a.id_bu = c.id_bu", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_program', $id_program);
            $this->db->where("(b.nm_user LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

		public function getAllpic_detail($show=null, $start=null, $cari=null, $id_program_detail)
        {
            $this->db->select("a.id_pic, a.id_user, b.nm_user, a.id_bu, c.nm_bu, a.active");
            $this->db->from("tr_pic_detail a");
			$this->db->join("ref_user b", "a.id_user = b.id_user", "left");
			$this->db->join("ref_bu c", "a.id_bu = c.id_bu", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_program_detail', $id_program_detail);
            $this->db->where("(b.nm_user LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

		public function getAllactivity($show=null, $start=null, $cari=null, $tanggal = null)
        {
            $this->db->select("a.id_activity, a.nm_program_detail, c.nm_program, a.keterangan, a.cdate, a.cuser, a.active, b.nm_user, d.nm_status");
            $this->db->from("tr_activity a");
            $this->db->join("ref_user b", "a.cuser = b.id_user", "left");
			$this->db->join("tr_program c", "a.id_program = c.id_program", "left");
			$this->db->join("ref_status d", "a.id_status = d.id_status", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			if($tanggal != null){
				$this->db->where("DATE_FORMAT(a.cdate,'%Y-%m-%d') = '".$tanggal."'");

			}
            $this->db->where("(a.nm_program_detail LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

		public function getAllactivityatt($show=null, $start=null, $cari=null, $id_activity)
        {
            $this->db->select("a.id_activity, a.id_detail_activity, a.id_attachment , a.nm_file, b.nm_attachment");
            $this->db->from("tr_detail_activity a");
			$this->db->join("ref_attachment b", "a.id_attachment = b.id_attachment", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_activity', $id_activity);
            $this->db->where("(a.id_activity LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

		public function get_count_activityatt($search = null, $id_activity)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_detail_activity) as recordsFiltered ");
			$this->db->from("tr_detail_activity a");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_activity', $id_activity);
			$this->db->where("active != '2' ");
			$this->db->like("nm_file ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_detail_activity) as recordsTotal ");
			$this->db->from("tr_detail_activity");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where('id_activity', $id_activity);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}

		

		public function get_count_program($search = null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_program) as recordsFiltered ");
			$this->db->from("tr_program");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			
			$this->db->like("nm_program ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_program) as recordsTotal ");
			$this->db->from("tr_program");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}

		

		public function get_count_program_detail($search = null, $id_program)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_program_detail) as recordsFiltered ");
			$this->db->from("tr_program_detail a");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_program', $id_program);
			$this->db->where("active != '2' ");
			$this->db->like("nm_program_detail ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_program_detail) as recordsTotal ");
			$this->db->from("tr_program_detail");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where('id_program', $id_program);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}

		public function get_count_pic($search = null, $id_program)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_pic) as recordsFiltered ");
			$this->db->from("tr_pic a");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_program', $id_program);
			$this->db->where("active != '2' ");
			$this->db->like("id_pic ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_pic) as recordsTotal ");
			$this->db->from("tr_pic");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where('id_program', $id_program);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}
		
		public function get_count_pic_detail($search = null, $id_program_detail)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_pic) as recordsFiltered ");
			$this->db->from("tr_pic_detail a");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_program_detail', $id_program_detail);
			$this->db->where("active != '2' ");
			$this->db->like("id_pic ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_pic) as recordsTotal ");
			$this->db->from("tr_pic_detail");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where('id_program_detail', $id_program_detail);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}

		public function get_count_activity($search = null, $tanggal=null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_activity) as recordsFiltered ");
			$this->db->from("tr_activity a");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			if($tanggal != null){
				$this->db->where("DATE_FORMAT(cdate,'%Y-%m-%d') = '".$tanggal."'");

			}
			$this->db->like("id_activity ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_activity) as recordsTotal ");
			$this->db->from("tr_activity");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}

		public function data_tanggal_task($startDate = null)
	{
		$session = $this->session->userdata('login');

		$query = "SELECT b.nm_type_surat as name, count(a.id_surat) as y FROM tr_surat a LEFT JOIN ref_type_surat b ON a.id_type_surat = b.id_type_surat"; //SELECT

		if ($startDate == null || $endDate == null) { // WHERE
			$query .= " WHERE MONTH(cdate) = MONTH(CURRENT_DATE()) AND YEAR(cdate) = YEAR(CURRENT_DATE()) AND YEAR(cdate) = YEAR(CURRENT_DATE()) AND b.active = 1 ";
		} else {
			$query .= " WHERE (cdate BETWEEN ' " . $startDate . " ' AND ' " . $endDate . " ') AND b.active = 1 ";
		}
		$query .= "GROUP BY b.id_type_surat ORDER BY date(cdate) DESC"; // GROUP BY AND ORDER BY

		$get =  $this->db->query($query);

		// return
		$record = $get->result();

		return json_encode($record);
	}

		public function insert_program($data)
        {
            $this->db->insert('tr_program', $data);
			return $this->db->insert_id();
        }

		public function insert_program_detail($data)
        {
            $this->db->insert('tr_program_detail', $data);
			return $this->db->insert_id();
        }

		public function insert_pic($data)
        {
            $this->db->insert('tr_pic', $data);
			return $this->db->insert_id();
        }

		public function insert_pic_detail($data)
        {
            $this->db->insert('tr_pic_detail', $data);
			return $this->db->insert_id();
        }

		public function insert_activity($data)
        {
            $this->db->insert('tr_activity', $data);
			return $this->db->insert_id();
        }

        public function delete_program($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_program', $data['id_program']);
            $this->db->update('tr_program', array('active' => '2'));
			return $data['id_program'];
        }

		public function delete_program_detail($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_program_detail', $data['id_program_detail']);
            $this->db->update('tr_program_detail', array('active' => '2'));
			return $data['id_program_detail'];
        }
		
		public function delete_pic($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_pic', $data['id_pic']);
            $this->db->update('tr_pic', array('active' => '2'));
			return $data['id_pic'];
        }

		public function delete_pic_detail($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_pic', $data['id_pic']);
            $this->db->update('tr_pic_detail', array('active' => '2'));
			return $data['id_pic'];
        }

		public function delete_activity($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_activity', $data['id_activity']);
            $this->db->update('tr_activity', array('active' => '2'));
			return $data['id_activity'];
        }

		public function delete_activityatt($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_activity', $data['id_activity']);
            $this->db->delete('tr_detail_activity', array('active' => '1'));
			return $data['id_activity'];
        }

        public function update_program($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_program', $data['id_program']);
			$this->db->where("active != '2' ");
            $this->db->update('tr_program', $data);
			return $data['id_program'];
        }
		
		public function update_program_detail($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_program_detail', $data['id_program_detail']);
			$this->db->where("active != '2' ");
            $this->db->update('tr_program_detail', $data);
			return $data['id_program_detail'];
        }

		public function update_pic($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_pic', $data['id_pic']);
			$this->db->where("active != '2' ");
            $this->db->update('tr_pic', $data);
			return $data['id_pic'];
        }

		public function update_pic_detail($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_pic', $data['id_pic']);
			$this->db->where("active != '2' ");
            $this->db->update('tr_pic_detail', $data);
			return $data['id_pic'];
        }
		
		public function update_activity($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_activity', $data['id_activity']);
			$this->db->where("active != '2' ");
            $this->db->update('tr_activity', $data);
			return $data['id_activity'];
        }

		public function insert_attachment($data)
    {
        $this->db->insert('tr_detail_activity', $data);
        return $this->db->insert_id();
    }

		public function get_program_by_id($id_program)
		{
			if(empty($id_program))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->select("a.id_program, a.nm_program, a.due, a.id_status, b.nm_status, a.active");
            	$this->db->from("tr_program a");
				$this->db->join("ref_status b", "a.id_status = b.id_status", "left");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_program', $id_program);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		public function get_program_detail_by_id($id_program_detail)
		{
			if(empty($id_program_detail))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->select("a.id_program_detail, a.nm_program_detail, a.due, a.id_status, b.nm_status, a.active");
            	$this->db->from("tr_program_detail a");
				$this->db->join("ref_status b", "a.id_status = b.id_status", "left");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_program_detail', $id_program_detail);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		public function get_pic_by_id($id_pic)
		{
			if(empty($id_pic))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->select("a.id_pic, a.id_user, b.nm_user, a.id_bu, c.nm_bu, a.active");
				$this->db->from("tr_pic a");
				$this->db->join("ref_user b", "a.id_user = b.id_user", "left");
				$this->db->join("ref_bu c", "a.id_bu = c.id_bu", "left");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_pic', $id_pic);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		public function get_pic_detail_by_id($id_pic)
		{
			if(empty($id_pic))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->select("a.id_pic, a.id_user, b.nm_user, a.id_bu, c.nm_bu, a.active");
				$this->db->from("tr_pic_detail a");
				$this->db->join("ref_user b", "a.id_user = b.id_user", "left");
				$this->db->join("ref_bu c", "a.id_bu = c.id_bu", "left");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_pic', $id_pic);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		public function get_activity_by_id($id_activity)
		{
			if(empty($id_activity))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->select("a.id_activity, a.activity, a.keterangan, a.cdate, a.active");
            	$this->db->from("tr_activity a");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_activity', $id_activity);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		public function get_activityatt_by_id($id_activity)
		{
			if(empty($id_activity))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				
				$this->db->select("a.id_activity, a.id_detail_activity, a.id_attachment , a.nm_file, b.nm_attachment");
				$this->db->from("tr_detail_activity a");
				$this->db->join("ref_attachment b", "a.id_attachment = b.id_attachment", "left");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_activity', $id_activity);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		public function combobox_status()
        {
            $this->db->from("ref_status");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

		public function combobox_program_detail()
        {
            $this->db->from("tr_program_detail");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }
		public function get_detail_by_program($id_program = null)
        {
            $this->db->from("tr_program_detail");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where('id_program', $id_program);
            $this->db->where('active', 1);
            return $this->db->get();
        }
		public function combobox_nm_program()
        {
            $this->db->from("tr_program");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

		public function combobox_user()
        {
            $this->db->from("ref_user");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

		public function combobox_attachment()
        {
            $this->db->from("ref_attachment");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

    }
