<?php
    class Model_divre extends CI_Model
    {
        public function getAlldivre($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.id_divre, a.nm_divre, a.active");
            $this->db->from("ref_divre a");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_divre  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }
		
		public function get_count_divre($search = null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_divre) as recordsFiltered ");
			$this->db->from("ref_divre");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$this->db->like("nm_divre ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_divre) as recordsTotal ");
			$this->db->from("ref_divre");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}
		
		public function insert_divre($data)
        {
            $this->db->insert('ref_divre', $data);
			return $this->db->insert_id();
        }

        public function delete_divre($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_divre', $data['id_divre']);
            $this->db->update('ref_divre', array('active' => '2'));
			return $data['id_divre'];
        }
		
        public function update_divre($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_divre', $data['id_divre']);
			$this->db->where("active != '2' ");
            $this->db->update('ref_divre', $data);
			return $data['id_divre'];
        }
		
		public function get_divre_by_id($id_divre)
		{
			if(empty($id_divre))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->from("ref_divre a");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_divre', $id_divre);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		

    }
