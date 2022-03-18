<?php
    class Model_menu extends CI_Model
    {
        public function getAllMenugroups($level)
        {
            $active = 1;
            $this->db->from("ref_menu_groups_access a");
            $this->db->join('ref_menu_groups b', 'a.id_menu_groups = b.id_menu_groups', 'left');
            $this->db->where('a.id_level', $level);
            $this->db->where('a.active', $active);
            $this->db->where('b.active', $active);
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->order_by("b.position", "asc");

            return $this->db->get();
        }

        public function getAllMenudetails($id, $level)
        {
            $active = 1;
            $this->db->from("ref_menu_details_access a");
            $this->db->join('ref_menu_details b', 'a.id_menu_details = b.id_menu_details', 'left');
            $this->db->where('a.id_level', $level);
            $this->db->where('a.active', $active);
            $this->db->where('b.active', $active);
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->order_by("b.position", "asc");
            if ($id == 0) {
            } else {
                $this->db->where('b.id_menu_groups', $id);
            }
            return $this->db->get();
        }

        public function selectaccess($id_level, $kd_menu_details)
        {
            $this->db->from('ref_menu_details_access a');
            $this->db->join('ref_menu_details b', 'a.id_menu_details = b.id_menu_details', 'left');
            $this->db->where('a.id_level', $id_level);
            $this->db->where('b.kd_menu_details', $kd_menu_details);
            $this->db->where('a.active', 1);
            $this -> db -> limit(1);
            $query = $this -> db -> get();
            if ($query -> num_rows() == 1) {
                $result = $query->row_array();
                return $result;
            } else {
                return false;
            }
        }


        public function selectperusahaan($id_perusahaan)
        {
            $this->db->from('ref_perusahaan');
            $this->db->where('id_perusahaan', $id_perusahaan);
            $this -> db -> limit(1);
            $query = $this -> db -> get();
            if ($query -> num_rows() == 1) {
                $result = $query->row_array();
                return $result;
            } else {
                return false;
            }
        }

        public function selectusername($id_user)
        {
            $this->db->from('ref_user');
            $this->db->where('id_user', $id_user);
            $this -> db -> limit(1);
            $query = $this -> db -> get();
            if ($query -> num_rows() == 1) {
                $result = $query->row_array();
                return $result;
            } else {
                return false;
            }
        }
    }
