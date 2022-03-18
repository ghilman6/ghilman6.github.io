<?php
    class Model_kategori extends CI_Model
    {
        public function getAllkategori($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.id_kategori, a.nm_kategori, a.active");
            $this->db->from("ref_kategori a");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_kategori  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }
		
		public function get_count_kategori($search = null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_kategori) as recordsFiltered ");
			$this->db->from("ref_kategori");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$this->db->like("nm_kategori ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_kategori) as recordsTotal ");
			$this->db->from("ref_kategori");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}
		
		public function insert_kategori($data)
        {
            $this->db->insert('ref_kategori', $data);
			return $this->db->insert_id();
        }

        public function delete_kategori($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_kategori', $data['id_kategori']);
            $this->db->update('ref_kategori', array('active' => '2'));
			return $data['id_kategori'];
        }
		
        public function update_kategori($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_kategori', $data['id_kategori']);
			$this->db->where("active != '2' ");
            $this->db->update('ref_kategori', $data);
			return $data['id_kategori'];
        }
		
		public function get_kategori_by_id($id_kategori)
		{
			if(empty($id_kategori))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->from("ref_kategori a");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_kategori', $id_kategori);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		

    }
