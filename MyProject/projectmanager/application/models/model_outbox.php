<?php
class Model_outbox extends CI_Model
{
    public function getAllSurat($show = null, $start = null, $cari = null, $id_akun = null)
    {
        $this->db->select("a.id_surat, b.nm_type_surat, c.nm_klasifikasi, d.nm_kategori, a.perihal, a.isi_surat, a.active, a.cdate ,e.nm_user, a.tgl_surat");
        $this->db->from("tr_surat a");
        $this->db->join("ref_type_surat b", "a.id_type_surat = b.id_type_surat", "left");
        $this->db->join("ref_klasifikasi c", "a.id_klasifikasi = c.id_klasifikasi", "left");
        $this->db->join("ref_kategori d", "a.id_kategori = d.id_kategori", "left");
        $this->db->join("ref_user e", "a.cuser = e.id_user", "left");

        $session = $this->session->userdata('login');
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where('a.id_akun', $id_akun);
        $this->db->where("(a.perihal  LIKE '%" . $cari . "%' ) ");
        $this->db->where("a.active", 3);
        if ($show == null && $start == null) {
        } else {
            $this->db->limit($show, $start);
        }

        return $this->db->get();
    }

    public function get_count_surat($search = null, $id_akun)
    {
        $count = array();
        $session = $this->session->userdata('login');

        $this->db->select(" COUNT(a.id_surat) as recordsFiltered ");
        $this->db->from("tr_surat a");
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where('a.id_akun', $id_akun);
        $this->db->where("a.active", 3);      
        $this->db->like("a.perihal ", $search);
        $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

        $this->db->select(" COUNT(id_surat) as recordsTotal ");
        $this->db->from("tr_surat");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('id_akun', $id_akun);
        $this->db->where("active", 3);
        $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

        return $count;
    }

    public function get_surat_by_id($id_surat)
    {
        if (empty($id_surat)) {
            return array();
        } else {
            // (select e.nm_posisi from tr_approval_transact d where d.ttd = 1 and d.id_surat = a.id_surat limit 1) as nm_posisi
            $session = $this->session->userdata('login');
            $this->db->select("a.id_surat, b.nm_type_surat, c.nm_klasifikasi, d.id_kategori, a.perihal, a.isi_surat, a.active, a.id_type_surat, a.id_klasifikasi, e.id_akun, f.nm_akun, g.nm_pegawai ");
            $this->db->from("tr_surat a");
            $this->db->join("ref_type_surat b", "a.id_type_surat = b.id_type_surat", "left");
            $this->db->join("ref_klasifikasi c", "a.id_klasifikasi = c.id_klasifikasi", "left");
            $this->db->join("ref_kategori d", "a.id_kategori = d.id_kategori", "left");
            $this->db->join("tr_approval e", "a.id_surat = e.id_surat", "left");
            $this->db->join("ref_akun f", "e.id_akun = f.id_akun", "left");
            $this->db->join("ref_pegawai g", "f.id_pegawai = g.id_pegawai", "left");

            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_surat', $id_surat);
            // $this->db->where("a.active != '2' ");
            return $this->db->get()->row_array();
        }
    }

    // approval
    public function getAllapproval($id_surat = null, $show = null, $start = null, $cari = null)
    {
        $this->db->select("a.id_surat, a.id_approval, a.status, c.nm_akun, a.type_approval, c.id_pegawai, d.nm_pegawai  , a.active");
        $this->db->from("tr_approval a");
        $this->db->join("ref_akun c", "a.id_akun = c.id_akun", "left");
        $this->db->join("ref_pegawai d", "c.id_pegawai = d.id_pegawai", "left");
        $session = $this->session->userdata('login');
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where("(c.nm_akun  LIKE '%" . $cari . "%' ) ");
        $this->db->where("a.active IN (0, 1) ");
        $this->db->where("a.id_surat", $id_surat);
        $this->db->group_by('id_approval');
        $this->db->order_by("a.type_approval", "ASC");
        if ($show == null && $start == null) {
        } else {
            $this->db->limit($show, $start);
        }

        return $this->db->get();
    }
    public function get_count_approval($id_surat, $search = null)
    {
        $count = array();
        $session = $this->session->userdata('login');

        $this->db->select(" COUNT(id_approval) as recordsFiltered ");
        $this->db->from("tr_approval");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $this->db->where("id_surat", $id_surat);
        $this->db->like("type_approval", $search);
        $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

        $this->db->select(" COUNT(id_approval) as recordsTotal ");
        $this->db->from("tr_approval");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $this->db->where("id_surat", $id_surat);
        $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

        return $count;
    }

    public function getAllattachment($id_surat = null, $show = null, $start = null, $cari = null)
    {
        $this->db->select("a.id_surat_attachment, a.id_surat, a.nm_attachment, a.attachment, a.active");
        $this->db->from("tr_surat_attachment a");
        $session = $this->session->userdata('login');
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where("(a.nm_attachment  LIKE '%" . $cari . "%' ) ");
        $this->db->where("a.active IN (0, 1) ");
        $this->db->where("a.id_surat", $id_surat);

        if ($show == null && $start == null) {
        } else {
            $this->db->limit($show, $start);
        }

        return $this->db->get();
    }

    public function get_count_attachment($id_surat, $search = null)
    {
        $count = array();
        $session = $this->session->userdata('login');

        $this->db->select(" COUNT(id_surat_attachment) as recordsFiltered ");
        $this->db->from("tr_surat_attachment");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("id_surat", $id_surat);
        $this->db->where("active != '2' ");
        $this->db->like("nm_attachment ", $search);
        $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

        $this->db->select(" COUNT(id_surat_attachment) as recordsTotal ");
        $this->db->from("tr_surat_attachment");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("id_surat", $id_surat);
        $this->db->where("active != '2' ");
        $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

        return $count;
    }

    public function combobox_akses_akun()
    {
        $session = $this->session->userdata('login');
        $this->db->select("a.id_akun, c.id_pegawai, c.nm_akun");
        $this->db->from("ref_akun_access a");
        $this->db->join("ref_akun c", "a.id_akun = c.id_akun", "left");
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where('a.id_user', $session['id_user']);
        $this->db->where("a.active != '2' ");
        return $this->db->get();
    }

    
}
