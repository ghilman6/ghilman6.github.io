<?php
    class Model_perusahaan extends CI_Model
    {


    /* function getAllperusahaan($show=null, $start=null, $cari=null)
    {
        $session = $this->session->userdata('login');
        $this->db->from("ref_perusahaan");
        $this->db->like('nm_perusahaan', $cari);
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("(nm_perusahaan  LIKE '%".$cari."%') ");
        if ($show == null && $start == null){

        }else{
        $this->db->limit($show, $start);}
        return $this->db->get();
    }

    function Insertperusahaan($data)
    {
        $this->db->insert('ref_perusahaan', $data);
    }

     function Deletetperusahaan($id_perusahaan)
    {
        $this->db->where('id_perusahaan', $id_perusahaan);
        $this->db->delete('ref_perusahaan');
    } */

        public function getAllperusahaanselect($p)
        {
            $this->db->from("ref_perusahaan");
            $this->db->where('id_perusahaan', $p);
            return $this->db->get();
        }

        public function Updateperusahaan($id_perusahaan, $data)
        {
            $this->db->where('id_perusahaan', $id_perusahaan);
            $this->db->update('ref_perusahaan', $data);
        }
		
    }
