<?php
    class Model_bu extends CI_Model
    {
        public function getAllbu($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.*, b.nm_divre");
            $this->db->from("ref_bu a");
            $this->db->join("ref_divre b","a.id_divre =  b.id_divre", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_bu  LIKE '%".$cari."%' or b.nm_divre  LIKE '%".$cari."%'  ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

        public function getAllbuaccess($show=null, $start=null, $cari=null, $id_bu)
        {
            $this->db->select("a.id_bu_access, a.id_user, b.nm_user, a.active");
            $this->db->from("ref_bu_access a");
            $this->db->join("ref_user b", "a.id_user = b.id_user", "left");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_bu', $id_bu);
            $this->db->where("(b.nm_user  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }
        
        public function get_count_bu($search = null)
        {
            $count = array();
            $session = $this->session->userdata('login');
            
            $this->db->select(" COUNT(a.id_bu) as recordsFiltered ");
            $this->db->from("ref_bu a");
            $this->db->join("ref_divre b","a.id_divre =  b.id_divre", "left");
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("a.active != '2' ");
            $this->db->where("(a.nm_bu  LIKE '%".$search."%' or b.nm_divre  LIKE '%".$search."%'  ) ");
            $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
            
            $this->db->select(" COUNT(id_bu) as recordsTotal ");
            $this->db->from("ref_bu");
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where("active != '2' ");
            $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
            
            return $count;
        }
        
        public function insert_bu($data)
        {
            $this->db->insert('ref_bu', $data);
            return $this->db->insert_id();
        }

        public function insert_bu_access($data)
        {
            $this->db->insert('ref_bu_access', $data);
            return $this->db->insert_id();
        }

        public function delete_bu($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_bu', $data['id_bu']);
            $this->db->update('ref_bu', array('active' => '2'));
            return $data['id_bu'];
        }

        public function delete_bu_access($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_bu_access', $data['id_bu_access']);
            $this->db->delete('ref_bu_access');
            return $data['id_bu_access'];
        }
        
        public function update_bu($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_bu', $data['id_bu']);
            $this->db->where("active != '2' ");
            $this->db->update('ref_bu', $data);
            return $data['id_bu'];
        }

        public function update_bu_access($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_bu_access', $data['id_bu_access']);
            $this->db->where("active != '2' ");
            $this->db->update('ref_bu_access', $data);
            return $data['id_bu_access'];
        }
        
        public function get_bu_by_id($id_bu)
        {
            if(empty($id_bu))
            {
                return array();
            }
            else
            {
                $session = $this->session->userdata('login');
                $this->db->select(" a.*, b.nm_divre");
                $this->db->from("ref_bu a");
                $this->db->join("ref_divre b", "a.id_divre = b.id_divre", "left");
                $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
                $this->db->where('a.id_bu', $id_bu);
                $this->db->where("a.active != '2' ");
                return $this->db->get()->row_array();
            }
        }

        public function get_bu_access_by_id($id_bu_access)
        {
            if(empty($id_bu_access))
            {
                return array();
            }
            else
            {
                $session = $this->session->userdata('login');
                $this->db->select("a.id_bu_access, a.id_bu, a.id_user, b.nm_user, a.active");
                $this->db->from("ref_bu_access a");
                $this->db->join("ref_user b", "a.id_user = b.id_user", "left");
                $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
                $this->db->where('a.id_bu_access', $id_bu_access);
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

        public function divre_combobox()
        {
            $this->db->from("ref_divre");
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('active', 1);
            return $this->db->get();
        }

    }
