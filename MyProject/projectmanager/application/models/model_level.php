<?php
    class Model_level extends CI_Model
    {
        public function getAlllevel($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.id_level, a.nm_level, a.active");
            $this->db->from("ref_level a");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_level  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }
		
		public function get_count_level($search = null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_level) as recordsFiltered ");
			$this->db->from("ref_level");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$this->db->like("nm_level ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_level) as recordsTotal ");
			$this->db->from("ref_level");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}

		public function getMenuDetail($id_level, $show=null, $start=null, $cari=null)
        {
            $this->db->select('a.id_menu_details, a.nm_menu_details, b.id_menu_details_access, b.active, c.nm_menu_groups');
            $this->db->from("ref_menu_details a");
            $session = $this->session->userdata('login');
            $this->db->join("ref_menu_details_access b", "a.id_menu_details = b.id_menu_details  ", "left");
            $this->db->join("ref_menu_groups c", "c.id_menu_groups = a.id_menu_groups", "left");
            $this->db->where('b.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_menu_details  LIKE '%".$cari."%' or c.nm_menu_groups  LIKE '%".$cari."%') ");
            $this->db->where("b.id_level", $id_level);
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

        public function getGroupDetail($id_level, $show=null, $start=null, $cari=null)
        {
            $this->db->select(' a.* , b.nm_menu_groups');
            $this->db->from("ref_menu_groups_access a");
            $this->db->join("ref_menu_groups b", "a.id_menu_groups = b.id_menu_groups");
            $session = $this->session->userdata('login');
            $this->db->where("(b.nm_menu_groups  LIKE '%".$cari."%') ");
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("a.id_level", $id_level);
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }
		
		public function insert_level($data)
        {
            $this->db->insert('ref_level', $data);
			return $this->db->insert_id();
        }

        public function delete_level($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_level', $data['id_level']);
            $this->db->update('ref_level', array('active' => '2'));
			return $data['id_level'];
        }
		
        public function update_level($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_level', $data['id_level']);
			$this->db->where("active != '2' ");
            $this->db->update('ref_level', $data);
			return $data['id_level'];
        }

		public function getAlllevelselect($id_level)
        {
            $this->db->from("ref_level");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_level', $id_level);
            return $this->db->get();
        }

        public function getAlllevelselects($id_level)
        {
            $this->db->select('b.active, a.id_menu_details, a.nm_menu_details');
            $this->db->from("ref_menu_details a");
            $this->db->join("ref_menu_details_access b", 'a.id_menu_details = b.id_menu_details', 'left');
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('b.id_level', $id_level);
            return $this->db->get();
        }
		
		public function get_level_by_id($id_level)
		{
			if(empty($id_level))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->from("ref_level a");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_level', $id_level);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		public function Updatelevel($id_level, $data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_level', $id_level);
            $this->db->update('ref_level', $data);
        }

        public function Updatemenu_group_access($id_menu_details_access, $data)
        {
            $this->db->where('id_menu_groups_access', $id_menu_details_access);
            $this->db->update('ref_menu_groups_access', $data);
        }

        public function Updatemenu_details_access($id_menu_details_access, $data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_menu_details_access', $id_menu_details_access);
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->update('ref_menu_details_access', $data);
        }

		

    }
