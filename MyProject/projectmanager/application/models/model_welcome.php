<?php 
    if (! defined('BASEPATH')) {
        exit('No direct script access allowed');
    }
    class Model_welcome extends CI_Model
    {
        public function getperusahaan()
        {
            return $this->db->get('ref_perusahaan');
        }

        public function create_user($data1)
        {
            $this->db->insert('ref_user', $data1);
            return $this->db->insert_id();
        }

        public function create_subsribe($data4)
        {
            $this->db->insert('tr_subscribe', $data4);
        }

        public function create_perusahaan($data2)
        {
            $this->db->insert('ref_perusahaan', $data2);
            return $this->db->insert_id();
        }

        public function create_level($data3)
        {
            $this->db->insert('ref_level', $data3);
            return $this->db->insert_id();
        }

        public function idmax()
        {
            $this->db->select_max('id_perusahaan');
            return $this->db->get('ref_perusahaan');
        }

        public function getbarcode($getlastid)
        {
            $this->db->from('ref_user');
            $this->db->where('id_user', $getlastid);
            return $this->db->get();
        }

        public function cekuser($username, $email)
        {
            $this->db->from('ref_user');
            $this->db->where('username', $username);
            $this->db->OR_where('email', $email);
            return $this->db->get()->num_rows();
        }

        public function checkcode($verification_code)
        {
            $this->db->from('ref_user');
            $this->db->where('verification_code', $verification_code);
            return $this->db->get()->num_rows();
        }

        public function Update_state($verification_code, $data)
        {
            $this->db->where('verification_code', $verification_code);
            $this->db->update('ref_user', $data);
        }

        public function update_levelmenugroup_akses($getidlevel, $status)
        {
            $this->db->where('id_level', $getidlevel);
            $this->db->update('ref_menu_groups_access', $status);
        }

        public function update_levelmenudetails_akses($getidlevel, $status)
        {
            $this->db->where('id_level', $getidlevel);
            $this->db->update('ref_menu_details_access', $status);
        }
		
		function jmlpaketmasuk(){
			$idbu = $this->session->userdata('id_bu');

			$this->db->select('count(id_logistics) paketmasuk');
			$this->db->from('tr_logistics');
			$this->db->where('date(date_package) = CURDATE()');
			$this->db->where('id_bu',$idbu);
		
			$query = $this->db->get();
			$total = $query->num_rows();
			return $total;
		}
		
		function jmlbelumdikirim(){
			$idbu = $this->session->userdata('id_bu');

			$this->db->select('count(id_logistics) paketmasuk');
			$this->db->from('tr_logistics');
			$this->db->where('date(date_package) = CURDATE()');
			$this->db->where('id_bu',$idbu);
		
			$query = $this->db->get();
			$total = $query->num_rows();
			return $total;
		}
		
		function jmlbulanini(){
			$idbu = $this->session->userdata('id_bu');

			$this->db->select('count(id_logistics) paketmasuk');
			$this->db->from('tr_logistics');
			$this->db->where('date(date_package) = CURDATE()');
			$this->db->where('id_bu',$idbu);
		
			$query = $this->db->get();
			$total = $query->num_rows();
			return $total;
		}
		
		function jmltahunini(){
			$idbu = $this->session->userdata('id_bu');

			$this->db->select('count(id_logistics) paketmasuk');
			$this->db->from('tr_logistics');
			$this->db->where('date(date_package) = CURDATE()');
			$this->db->where('id_bu',$idbu);
		
			$query = $this->db->get();
			$total = $query->num_rows();
			return $total;
		}
		
		function detailresi($resi){
			$this->db->select('c.nm_bu asal, sender, receiver, address, d.nm_point tujuan, datetime_in');
			$this->db->from('tr_logistics a');
			$this->db->join('tr_history_logistics b','a.id_logistics = b.id_logistics');
			$this->db->join('fms.ref_bu c','a.origin = c.id_bu');
			$this->db->join('fms.ref_point d','a.destination = d.id_point');
			$this->db->where('resi',$resi);
			#$this->db->where('status_history_logistics', '2');
			$this->db->group_by('a.id_logistics');
			$query = $this->db->get();
			return $query;
		}
		
		function timelineresi($resi){
			$this->db->select('e.nm_point posisipaket, b.status_history_logistics, name_status_history, datetime_in');
			$this->db->from('tr_logistics a');
			$this->db->join('tr_history_logistics b','a.id_logistics = b.id_logistics');
			$this->db->join('fms.ref_bu c','a.origin = c.id_bu');
			$this->db->join('ref_status_history_logistics d','b.status_history_logistics = d.id_status_history');
			$this->db->join('fms.ref_point e','b.destination = e.id_point');
			$this->db->where('resi',$resi);
			$this->db->order_by('datetime_in ASC');
			$query = $this->db->get();
			return $query;
			
		}
		
		function counter($resi){
			$this->db->select('b.nm_bu asal, sender, receiver, address, c.nm_point tujuan, date_package');
			$this->db->from('tr_logistics a');
			$this->db->join('fms.ref_bu b','a.origin = b.id_bu');
			$this->db->join('fms.ref_point c','a.destination = c.id_point');
			$this->db->where('resi',$resi);
			$query = $this->db->get();
			return $query;
			
		}
		
    }
