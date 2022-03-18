<?php
    class Model_akun extends CI_Model
    {
        public function getAllakun($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.id_akun, a.nm_akun, b.nm_bu, c.nm_pegawai, d.nm_divisi, a.active");
            $this->db->from("ref_akun a");
            $this->db->join("ref_bu b", "a.id_bu = b.id_bu", "left");
            $this->db->join("ref_divisi d", "a.id_divisi = d.id_divisi", "left");
            $this->db->join("ref_pegawai c", "a.id_pegawai = c.id_pegawai", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_akun  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }
		
		public function get_count_akun($search = null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_akun) as recordsFiltered ");
			$this->db->from("ref_akun");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$this->db->like("nm_akun ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_akun) as recordsTotal ");
			$this->db->from("ref_akun");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}
		
		public function getAllakunaccess($show=null, $start=null, $cari=null, $id_akun)
        {
            $this->db->select("a.id_akun_access, a.id_user, b.nm_user, a.active");
            $this->db->from("ref_akun_access a");
            $this->db->join("ref_user b", "a.id_user = b.id_user", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_akun', $id_akun);
            $this->db->where("(b.nm_user  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

		public function insert_akun($data)
        {
            $this->db->insert('ref_akun', $data);
			return $this->db->insert_id();
        }

		public function insert_akun_access($data)
        {
            $this->db->insert('ref_akun_access', $data);
            return $this->db->insert_id();
        }

        public function delete_akun($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_akun', $data['id_akun']);
            $this->db->update('ref_akun', array('active' => '2'));
			return $data['id_akun'];
        }

		public function delete_akun_access($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_akun_access', $data['id_akun_access']);
            $this->db->delete('ref_akun_access');
            return $data['id_akun_access'];
        }
		
        public function update_akun($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_akun', $data['id_akun']);
			$this->db->where("active != '2' ");
            $this->db->update('ref_akun', $data);
			return $data['id_akun'];
        }
		
		public function update_akun_access($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_akun_access', $data['id_akun_access']);
            $this->db->where("active != '2' ");
            $this->db->update('ref_akun_access', $data);
            return $data['id_akun_access'];
        }

		public function get_akun_by_id($id_akun)
		{
			if(empty($id_akun))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->select("a.id_akun, a.nm_akun, a.id_pegawai, a.id_bu, b.nm_bu, c.nm_pegawai, a.id_divisi, d.nm_divisi, a.active");
                $this->db->from("ref_akun a");
                $this->db->join("ref_bu b", "a.id_bu = b.id_bu", "left");
                $this->db->join("ref_divisi d", "a.id_divisi = d.id_divisi", "left");
                $this->db->join("ref_pegawai c", "a.id_pegawai = c.id_pegawai", "left");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_akun', $id_akun);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		public function get_akun_access_by_id($id_akun_access)
        {
            if(empty($id_akun_access))
            {
                return array();
            }
            else
            {
                $session = $this->session->userdata('login');
                $this->db->select("a.id_akun_access, a.id_akun, a.id_user, b.nm_user, a.active");
                $this->db->from("ref_akun_access a");
                $this->db->join("ref_user b", "a.id_user = b.id_user", "left");
                $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
                $this->db->where('a.id_akun_access', $id_akun_access);
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

        public function combobox_divisi()
        {
            $this->db->from("ref_divisi");
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

        public function combobox_user()
        {
            $this->db->from("ref_user");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

    }
