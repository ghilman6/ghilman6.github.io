<?php

    class Model_user extends CI_Model
    {
        

        public function update_token($id, $token, $refresh)
        {
            $data = array(
            'access_token'        => $token,
            'refresh_token'        => $refresh
        );
            $this->db->where('id_user', $id);
            return $this->db->update('ref_user', $data);
        }

        public function combobox_atasan()
        {
            $this->db->from("ref_user");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }


        public function combobox_level()
        {
			$session = $this->session->userdata('login');
			$lvl = $session['id_level'];
			$this->db->from("ref_level");
			$this->db->where('active', 1);
			if($lvl <> '1'){
				$this->db->where('id_level <> 1');
				$this->db->where('id_level <> 7');
			}

            return $this->db->get();
        }

         public function combobox_bu()
        {
            $this->db->from("ref_bu");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

        public function combobox_perusahaan()
        {
            $this->db->from("ref_perusahaan");
            $this->db->where('active', 1);
            return $this->db->get();
        }
		
		public function combobox_point()
        {
            $this->db->from("fms.ref_point");
            $this->db->where('active', 1);
            return $this->db->get();
        }


        public function InsertUser($data)
        {
            $this->db->insert('ref_user', $data);
        }

        public function DeletetUser($id_user)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_user', $id_user);
            $this->db->delete('ref_user');
        }

        public function getAllUserselect($id_user)
        {
            $this->db->from("ref_user");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_user', $id_user);
            return $this->db->get();
        }

        public function getAllUsers()
        {
            $session = $this->session->userdata('login');
            $this->db->from("ref_user");
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            return $this->db->get();
        }
		
        public function getAllUser($show=null, $start=null, $cari=null)
        {
            $this->db->select('a.id_user, a.nm_user, a.id_bu, f.nm_bu, a.username, a.password, b.nm_level, a.active');
            $this->db->from('ref_user a');
            $this->db->join('ref_level b', 'a.id_level = b.id_level', 'left');
            $this->db->join('ref_bu f', 'a.id_bu = f.id_bu', 'left');
            $session = $this->session->userdata('login');
            // $this->db->where('a.id_bu', $session['id_bu']);
            $this->db->where("(a.nm_user  LIKE '%".$cari."%' OR b.nm_level  LIKE '%".$cari."%') ");
            $this->db->where("a.active != 2 ");

            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

		public function get_count_user($search = null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(a.id_user) as recordsFiltered ");
			$this->db->from("ref_user a");
            $this->db->join('ref_level b', 'a.id_level = b.id_level', 'left');
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where("a.active != '2' ");
			$this->db->where(" (a.nm_user LIKE '%".$search."%' OR b.nm_level LIKE '%".$search."%') ", NULL, FALSE);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(a.id_user) as recordsTotal ");
			$this->db->from("ref_user a");
            $this->db->join('ref_level b', 'a.id_level = b.id_level', 'left');
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where("a.active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}

        public function UpdateUser($id_user, $data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_user', $id_user);
            $this->db->update('ref_user', $data);
        }
		
		public function insert_user($data)
        {
            $this->db->insert('ref_user', $data);
			return $this->db->insert_id();
        }

        public function delete_user($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_user', $data['id_user']);
            $this->db->update('ref_user', array('active' => '2'));
			return $data['id_user'];
        }
		
        public function update_user($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_user', $data['id_user']);
			$this->db->where("active != '2' ");
            $this->db->update('ref_user', $data);
			return $data['id_user'];
        }
		
		public function get_user_by_id($id_user)
		{
			if(empty($id_user))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->from("ref_user");
				$this->db->where('id_perusahaan', $session['id_perusahaan']);
				$this->db->where('id_user', $id_user);
				$this->db->where("active != '2' ");
				return $this->db->get()->row_array();
			}
		}
		
		
		
    }
