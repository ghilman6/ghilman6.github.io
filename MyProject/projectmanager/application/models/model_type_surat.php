<?php
    class Model_type_surat extends CI_Model
    {
        public function getAllTypeSurat($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.id_type_surat,a.kd_type_surat, a.nm_type_surat, a.jenis_ttd, a.active");
            $this->db->from("ref_type_surat a");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_type_surat  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }
		
		public function get_count_type_surat($search = null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_type_surat) as recordsFiltered ");
			$this->db->from("ref_type_surat");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$this->db->like("nm_type_surat ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_type_surat) as recordsTotal ");
			$this->db->from("ref_type_surat");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}
		
		public function insert_type_surat($data)
        {
            $this->db->insert('ref_type_surat', $data);
			return $this->db->insert_id();
        }

        public function delete_type_surat($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_type_surat', $data['id_type_surat']);
            $this->db->update('ref_type_surat', array('active' => '2'));
			return $data['id_type_surat'];
        }
		
        public function update_type_surat($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_type_surat', $data['id_type_surat']);
			$this->db->where("active != '2' ");
            $this->db->update('ref_type_surat', $data);
			return $data['id_type_surat'];
        }
		
		public function get_type_surat_by_id($id_type_surat)
		{
			if(empty($id_type_surat))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->select("a.id_type_surat,a.kd_type_surat, a.nm_type_surat, a.jenis_ttd, a.active");
				$this->db->from("ref_type_surat a");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_type_surat', $id_type_surat);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		

    }
