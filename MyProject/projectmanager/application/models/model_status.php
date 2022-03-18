<?php
    class Model_status extends CI_Model
    {
        public function getAllstatus($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.id_status, a.nm_status,  a.active");
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
		
		public function get_count_status($search = null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_status) as recordsFiltered ");
			$this->db->from("ref_status");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$this->db->like("nm_status ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_status) as recordsTotal ");
			$this->db->from("ref_status");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}
		
		public function insert_jenis($data)
        {
            $this->db->insert('ref_jenis', $data);
			return $this->db->insert_id();
        }

        public function delete_jenis($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_jenis', $data['id_jenis']);
            $this->db->update('ref_jenis', array('active' => '2'));
			return $data['id_jenis'];
        }
		
        public function update_jenis($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_jenis', $data['id_jenis']);
			$this->db->where("active != '2' ");
            $this->db->update('ref_jenis', $data);
			return $data['id_jenis'];
        }
		
		public function get_jenis_by_id($id_status)
		{
			if(empty($id_status))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->from("ref_status a");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_status', $id_status);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		

    }
