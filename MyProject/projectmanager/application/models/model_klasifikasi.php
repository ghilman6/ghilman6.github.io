<?php
    class Model_klasifikasi extends CI_Model
    {
        public function getAllklasifikasi($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.*, b.nm_jenis");
            $this->db->from("ref_klasifikasi a");
            $this->db->join("ref_jenis b","a.id_jenis =  b.id_jenis", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_klasifikasi  LIKE '%".$cari."%' or b.nm_jenis  LIKE '%".$cari."%'  ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

        public function getAllklasifikasiaccess($show=null, $start=null, $cari=null, $id_klasifikasi)
        {
            $this->db->select("a.id_klasifikasi_access, a.id_user, b.nm_user, a.active");
            $this->db->from("ref_klasifikasi_access a");
            $this->db->join("ref_user b", "a.id_user = b.id_user", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_klasifikasi', $id_klasifikasi);
            $this->db->where("(b.nm_user  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }
        
        public function get_count_klasifikasi($search = null)
        {
            $count = array();
            $session = $this->session->userdata('login');
            
            $this->db->select(" COUNT(a.id_klasifikasi) as recordsFiltered ");
            $this->db->from("ref_klasifikasi a");
            $this->db->join("ref_jenis b","a.id_jenis =  b.id_jenis", "left");
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("a.active != '2' ");
            $this->db->where("(a.nm_klasifikasi  LIKE '%".$search."%' or b.nm_jenis  LIKE '%".$search."%'  ) ");
            $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
            
            $this->db->select(" COUNT(id_klasifikasi) as recordsTotal ");
            $this->db->from("ref_klasifikasi");
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where("active != '2' ");
            $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
            
            return $count;
        }
        
        public function insert_klasifikasi($data)
        {
            $this->db->insert('ref_klasifikasi', $data);
            return $this->db->insert_id();
        }

        public function insert_klasifikasi_access($data)
        {
            $this->db->insert('ref_klasifikasi_access', $data);
            return $this->db->insert_id();
        }

        public function delete_klasifikasi($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_klasifikasi', $data['id_klasifikasi']);
            $this->db->update('ref_klasifikasi', array('active' => '2'));
            return $data['id_klasifikasi'];
        }

        public function delete_klasifikasi_access($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_klasifikasi_access', $data['id_klasifikasi_access']);
            $this->db->delete('ref_klasifikasi_access');
            return $data['id_klasifikasi_access'];
        }
        
        public function update_klasifikasi($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_klasifikasi', $data['id_klasifikasi']);
            $this->db->where("active != '2' ");
            $this->db->update('ref_klasifikasi', $data);
            return $data['id_klasifikasi'];
        }

        public function update_klasifikasi_access($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_klasifikasi_access', $data['id_klasifikasi_access']);
            $this->db->where("active != '2' ");
            $this->db->update('ref_klasifikasi_access', $data);
            return $data['id_klasifikasi_access'];
        }
        
        public function get_klasifikasi_by_id($id_klasifikasi)
        {
            if(empty($id_klasifikasi))
            {
                return array();
            }
            else
            {
                $session = $this->session->userdata('login');
                $this->db->select(" a.*, b.nm_jenis");
                $this->db->from("ref_klasifikasi a");
                $this->db->join("ref_jenis b", "a.id_jenis = b.id_jenis", "left");
                $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
                $this->db->where('a.id_klasifikasi', $id_klasifikasi);
                $this->db->where("a.active != '2' ");
                return $this->db->get()->row_array();
            }
        }

        public function get_klasifikasi_access_by_id($id_klasifikasi_access)
        {
            if(empty($id_klasifikasi_access))
            {
                return array();
            }
            else
            {
                $session = $this->session->userdata('login');
                $this->db->select("a.id_klasifikasi_access, a.id_klasifikasi, a.id_user, b.nm_user, a.active");
                $this->db->from("ref_klasifikasi_access a");
                $this->db->join("ref_user b", "a.id_user = b.id_user", "left");
                $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
                $this->db->where('a.id_klasifikasi_access', $id_klasifikasi_access);
                $this->db->where("a.active != '2' ");
                return $this->db->get()->row_array();
            }
        }

        public function combobox_user()
        {
            $this->db->from("ref_user");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

        public function jenis_combobox()
        {
            $this->db->from("ref_jenis");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

    }
