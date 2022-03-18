<?php
class Model_surat_internal extends CI_Model
{
    public function getAllsurat_internal($id_surat = null, $show = null, $start = null, $cari = null)
    {
        $this->db->select("a.id_surat, a.id_surat_internal, c.nm_akun, a.type_penerima, a.active, ");
        $this->db->from("tr_surat_internal a");
        $this->db->join("ref_akun c", "a.id_akun = c.id_akun", "left");
        $session = $this->session->userdata('login');
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where("(c.nm_akun  LIKE '%" . $cari . "%' ) ");
        $this->db->where("a.active IN (0, 1) ");
        $this->db->where("a.id_surat", $id_surat);
        if ($show == null && $start == null) {
        } else {
            $this->db->limit($show, $start);
        }

        return $this->db->get();
    }

    public function get_count_surat_internal($search = null)
    {
        $count = array();
        $session = $this->session->userdata('login');

        $this->db->select(" COUNT(id_surat_internal) as recordsFiltered ");
        $this->db->from("tr_surat_internal");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $this->db->like("type_penerima", $search);
        $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

        $this->db->select(" COUNT(id_surat_internal) as recordsTotal ");
        $this->db->from("tr_surat_internal");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

        return $count;
    }

    public function insert_surat_internal($data)
    {
        $this->db->insert('tr_surat_internal', $data);
        return $this->db->insert_id();
    }

    public function delete_surat_internal($data)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('id_surat_internal', $data['id_surat_internal']);
        $this->db->update('tr_surat_internal', array('active' => '2'));
        return $data['id_surat_internal'];
    }

    public function update_surat_internal($data)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('id_surat_internal', $data['id_surat_internal']);
        $this->db->where("active != '2' ");
        $this->db->update('tr_surat_internal', $data);
        return $data['id_surat_internal'];
    }

    public function get_surat_internal_by_id($id_surat_internal)
    {
        if (empty($id_surat_internal)) {
            return array();
        } else {
            $session = $this->session->userdata('login');
            $this->db->select("a.id_surat_internal, c.nm_akun, a.id_akun, a.type_penerima, a.active");
            $this->db->from("tr_surat_internal a");
            $this->db->join("ref_akun c", "a.id_akun = c.id_akun", "left");
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_surat_internal', $id_surat_internal);
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

    public function combobox_user()
    {
        $this->db->from("ref_user");
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('active', 1);
        return $this->db->get();
    }

    public function combobox_akun()
    {
        $this->db->from("ref_akun");
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('active', 1);
        return $this->db->get();
    }
}
