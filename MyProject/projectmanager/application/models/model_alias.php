<?php
    class Model_alias extends CI_Model
    {
        public function getAllalias($show=null, $start=null, $cari=null)
        {
            // $this->db->select("a.id_alias, a.nm_alias, b.nm_bu, c.nm_pegawai, a.active");
            $this->db->select("a.id_alias, a.nm_alias, a.active");
            $this->db->from("ref_alias a");
            // $this->db->join("ref_bu b", "a.id_bu = b.id_bu", "left");
            // $this->db->join("ref_pegawai c", "a.id_pegawai = c.id_pegawai", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_alias  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }
		
		public function get_count_alias($search = null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_alias) as recordsFiltered ");
			$this->db->from("ref_alias");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$this->db->like("nm_alias ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_alias) as recordsTotal ");
			$this->db->from("ref_alias");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}
		
		public function getAllaliasaccess($show=null, $start=null, $cari=null, $id_alias)
        {
            $this->db->select("a.id_alias_access, a.id_akun, b.nm_akun, a.active");
            $this->db->from("ref_alias_access a");
            $this->db->join("ref_akun b", "a.id_akun = b.id_akun", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_alias', $id_alias);
            $this->db->where("(b.nm_akun  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

		public function insert_alias($data)
        {
            $this->db->insert('ref_alias', $data);
			return $this->db->insert_id();
        }

		public function insert_alias_access($data)
        {
            $this->db->insert('ref_alias_access', $data);
            return $this->db->insert_id();
        }

        public function delete_alias($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_alias', $data['id_alias']);
            $this->db->update('ref_alias', array('active' => '2'));
			return $data['id_alias'];
        }

		public function delete_alias_access($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_alias_access', $data['id_alias_access']);
            $this->db->delete('ref_alias_access');
            return $data['id_alias_access'];
        }
		
        public function update_alias($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_alias', $data['id_alias']);
			$this->db->where("active != '2' ");
            $this->db->update('ref_alias', $data);
			return $data['id_alias'];
        }
		
		public function update_alias_access($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_alias_access', $data['id_alias_access']);
            $this->db->where("active != '2' ");
            $this->db->update('ref_alias_access', $data);
            return $data['id_alias_access'];
        }

		public function get_alias_by_id($id_alias)
		{
			if(empty($id_alias))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->select("a.id_alias, a.nm_alias, a.id_pegawai, a.active");
                $this->db->from("ref_alias a");
                // $this->db->join("ref_akun b", "a.id_akun = b.id_akun", "left");
                // $this->db->join("ref_pegawai c", "a.id_pegawai = c.id_pegawai", "left");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_alias', $id_alias);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		public function get_alias_access_by_id($id_alias_access)
        {
            if(empty($id_alias_access))
            {
                return array();
            }
            else
            {
                $session = $this->session->userdata('login');
                $this->db->select("a.id_alias_access, a.id_alias, a.id_akun, b.nm_akun, a.active");
                $this->db->from("ref_alias_access a");
                $this->db->join("ref_akun b", "a.id_akun = b.id_akun", "left");
                $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
                $this->db->where('a.id_alias_access', $id_alias_access);
                $this->db->where("a.active != '2' ");
                return $this->db->get()->row_array();
            }
        }

        public function combobox_bu()
        {
            $this->db->from("ref_bu");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

		public function combobox_pegawai()
        {
            $this->db->from("ref_pegawai");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

        public function combobox_akun()
        {
            $this->db->from("ref_akun");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

    }
