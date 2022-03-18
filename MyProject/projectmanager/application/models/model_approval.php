<?php
class Model_approval extends CI_Model
{
    public function getAllSurat($show = null, $start = null, $cari = null, $id_akun = null)
    {
        $session = $this->session->userdata('login');

        $this->db->select("a.id_surat, b.nm_type_surat, c.nm_klasifikasi, d.nm_kategori, a.perihal, a.isi_surat, a.active, e.status");
        $this->db->from("tr_surat a");
        $this->db->join("ref_type_surat b", "a.id_type_surat = b.id_type_surat", "left");
        $this->db->join("ref_klasifikasi c", "a.id_klasifikasi = c.id_klasifikasi", "left");
        $this->db->join("ref_kategori d", "a.id_kategori = d.id_kategori", "left");
        $this->db->join("tr_approval e", "a.id_surat = e.id_surat", "left");
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where("(b.nm_type_surat  LIKE '%" . $cari . "%' ) ");
        // $this->db->where('e.id_akun', $id_akun);
        // $this->db->where('e.status', 2);
        $this->db->where("a.active IN (0, 1) ");
        if ($show == null && $start == null) {
        } else {
            $this->db->limit($show, $start);
        }

        return $this->db->get();
    }
    public function getAllSuratByAkunApproval($show = null, $start = null, $cari = null, $id_akun = null, $status = null)
    {
        $session = $this->session->userdata('login');

        $this->db->select("a.id_surat, a.id_akun, a.status, c.nm_type_surat, d.nm_klasifikasi, e.nm_kategori, b.perihal,a.type_approval ");
        $this->db->from("tr_approval a");
        $this->db->join("tr_surat b", "a.id_surat = b.id_surat", "left");
        $this->db->join("ref_type_surat c", "b.id_type_surat = c.id_type_surat", "left");
        $this->db->join("ref_klasifikasi d", "b.id_klasifikasi = d.id_klasifikasi", "left");
        $this->db->join("ref_kategori e", "b.id_kategori = e.id_kategori", "left");
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where('a.id_akun', $id_akun);
        if($status == null){
            $this->db->where('a.status', 2);
        }else{
            $this->db->where('a.status', $status);
        }
        $this->db->where('a.active', 1);

        $this->db->where("(c.nm_type_surat  LIKE '%" . $cari . "%' ) ");
 
        // $this->db->where('e.id_akun', $id_akun);
        // $this->db->where('e.status', 2);
        // $this->db->where("a.active IN (0, 1) ");
        if ($show == null && $start == null) {
        } else {
            $this->db->limit($show, $start);
        }

        return $this->db->get();
    }
    public function get_count_surat($search = null , $id_akun = null)
    {
        $count = array();
        $session = $this->session->userdata('login');

        $this->db->select(" COUNT(a.id_approval) as recordsFiltered ");
        $this->db->from("tr_approval a");
        $this->db->join("tr_surat e", "a.id_surat = e.id_surat", "left");
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        // $this->db->where("a.active != '2' ");
        $this->db->where('a.id_akun', $id_akun);
        $this->db->where('a.status', 2);
        $this->db->like("e.perihal", $search);
        $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

        $this->db->select(" COUNT(a.id_approval) as recordsTotal ");
        $this->db->from("tr_approval a");
        // $this->db->join("tr_surat e", "a.id_surat = e.id_surat", "left");
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        // $this->db->where("a.active != '2' ");
        $this->db->where('a.id_akun', $id_akun);
        $this->db->where('a.status', 2);

        $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

        return $count;
    }
    public function reject_surat_approval($data)
    {
        // reset status surat menjadi draft
        $session = $this->session->userdata('login');
        $this->db->where('id_surat', $data['id_surat']);
        $this->db->update('tr_surat', array('active' => '1'));
        return $data['id_surat'];
    }
    public function reject_surat_reset_approval($data){
        // reset status approval menjadi waiting
        $session = $this->session->userdata('login');
        $this->db->where('id_surat', $data['id_surat']);
        $this->db->update('tr_approval', array('status' => '1'));
        return $data['id_surat'];

    }   

    public function get_approval_akun()
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
    public function get_approval_surat_login($id_akun = null)
    {
        $session = $this->session->userdata('login');
        $this->db->select("a.id_surat, a.id_approval");
        $this->db->from("tr_approval a");
        $this->db->where('a.id_akun', $id_akun);
        $this->db->where('a.status', 2);
        $this->db->where("a.active != '2' ");
        return $this->db->get();
    }
    // SURAT MODEL 
    public function update_status_approval_pertama($id_approval = null, $data = null)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_approval', $id_approval);
        $this->db->where("active != '2' ");
        $this->db->update('tr_approval', $data);
        return $id_approval;
    }
    public function update_status_approval_kedua($id_approval = null, $data = null)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_approval', $id_approval);
        $this->db->where("active != '2' ");
        $this->db->update('tr_approval', $data);
        return $id_approval;
    }
    public function update_surat_approval($id_surat = null, $data = null)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_surat', $id_surat);
        $this->db->where("active != '2' ");
        $this->db->update('tr_surat', $data);
        return $id_surat;
    }
    public function insert_surat($data)
    {
        $this->db->insert('tr_surat', $data);
        return $this->db->insert_id();
    }

    public function update_surat($data)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_surat', $data['id_surat']);
        // $this->db->where("active != '2' ");
        $this->db->update('tr_surat', $data);
        return $data['id_surat'];
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

    public function getpenerimaeks($show = null, $start = null, $cari = null, $id_surat, $type_penerima = null)
    {
        $this->db->select("*");
        $this->db->from("tr_surat_external a");
        $session = $this->session->userdata('login');
        $this->db->where('a.id_surat', $id_surat);
        $this->db->where('a.type_penerima', $type_penerima);
        // $this->db->where("(a.nm_surat_external  LIKE '%" . $cari . "%' ) ");
        // $this->db->where("a.active IN (0, 1) ");
        $this->db->order_by("a.id_surat_external", "asc");
        if ($show == null && $start == null) {
        } else {
            $this->db->limit($show, $start);
        }

        return $this->db->get();
    }

    public function getpenerimaalias($id_surat, $type_penerima)
    {
        $this->db->select("a.*, b.nm_alias  ");
        $this->db->from("tr_surat_alias a");
        $this->db->join("ref_alias b", "a.id_alias = b.id_alias", 'left');
        $this->db->where('a.id_surat', $id_surat);
        $this->db->where('a.type_penerima', $type_penerima);
        $this->db->group_by('id_alias');
        $this->db->order_by("a.id_surat_alias", "asc");

        return $this->db->get();
    }
    public function get_count_attacment($cari = null, $id_surat)
    {
        $count = array();
        $session = $this->session->userdata('login');

        $this->db->select(" COUNT(a.id_surat_attachment) as recordsFiltered ");
        $this->db->from("tr_surat_attachment a");
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where('a.id_surat', $id_surat);
        $this->db->where('a.active', 1);
        $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

        $this->db->select(" COUNT(a.id_surat_attachment) as recordsTotal ");
        $this->db->from("tr_surat_attachment a");
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where('a.id_surat', $id_surat);
        $this->db->where('a.active', 1);

        $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

        return $count;
    }
    // attachment
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

    public function get_count_attachment($search = null)
    {
        $count = array();
        $session = $this->session->userdata('login');

        $this->db->select(" COUNT(id_surat_attachment) as recordsFiltered ");
        $this->db->from("tr_surat_attachment");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $this->db->like("nm_attachment ", $search);
        $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

        $this->db->select(" COUNT(id_surat_attachment) as recordsTotal ");
        $this->db->from("tr_surat_attachment");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

        return $count;
    }

    public function insert_attachment($data)
    {
        $this->db->insert('tr_surat_attachment', $data);
        return $this->db->insert_id();
    }

    public function delete_attachment($data)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('id_surat_attachment', $data['id_surat_attachment']);
        return $this->db->delete('tr_surat_attachment');
    }

    public function update_attachment($data)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('id_surat_attachment', $data['id_surat_attachment']);
        $this->db->where("active != '2' ");
        $this->db->update('tr_surat_attachment', $data);
        return $data['id_surat_attachment'];
    }

    public function get_attachment_by_id($id_surat_attachment)
    {
        if (empty($id_surat_attachment)) {
            return array();
        } else {
            $session = $this->session->userdata('login');
            $this->db->from("tr_surat_attachment a");
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_surat_attachment', $id_surat_attachment);
            $this->db->where("a.active != '2' ");
            return $this->db->get()->row_array();
        }
    }

    // end attachment

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
        $this->db->group_by('a.id_approval');
        $this->db->order_by("a.type_approval", "ASC");
        $this->db->order_by("a.id_approval", "ASC");

        if ($show == null && $start == null) {
        } else {
            $this->db->limit($show, $start);
        }

        return $this->db->get();
    }
    public function getAllProsesApproval($id_surat = null)
    {
        $this->db->select("a.id_surat, a.id_approval, a.status, c.nm_akun, a.type_approval, c.id_pegawai, d.nm_pegawai  , a.active");
        $this->db->from("tr_approval a");
        $this->db->join("ref_akun c", "a.id_akun = c.id_akun", "left");
        $this->db->join("ref_pegawai d", "c.id_pegawai = d.id_pegawai", "left");
        $session = $this->session->userdata('login');
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where("a.active IN (0, 1) ");
        $this->db->where("a.id_surat", $id_surat);
        $this->db->where("a.status != '2' ");
        $this->db->group_by('id_approval');
        $this->db->order_by("a.type_approval", "ASC");

        return $this->db->get();
    }

    public function getApprovalOnProses($id_surat = null)
    {
        $session = $this->session->userdata('login');

        $this->db->select("id_approval , type_approval");
        $this->db->from("tr_approval");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $this->db->where("status", 2);
        $this->db->where("id_surat", $id_surat);
        $this->db->group_by('id_approval');
        $this->db->order_by("type_approval", "ASC");

        return $this->db->get();
    }
    public function get_count_approval($search = null)
    {
        $count = array();
        $session = $this->session->userdata('login');

        $this->db->select(" COUNT(id_approval) as recordsFiltered ");
        $this->db->from("tr_approval");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $this->db->like("type_approval", $search);
        $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

        $this->db->select(" COUNT(id_approval) as recordsTotal ");
        $this->db->from("tr_approval");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

        return $count;
    }
    public function check_count_paraf($id_surat = null)
    {
        $session = $this->session->userdata('login');

        $this->db->select(" COUNT(id_approval) as recordsParaf ");
        $this->db->from("tr_approval");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $this->db->where("type_approval", 1);
        $this->db->where("id_surat", $id_surat);


        return $this->db->get();
    }
    public function check_count_approval($id_surat = null)
    {
        $session = $this->session->userdata('login');

        $this->db->select(" COUNT(id_approval) as recordsApproval ");
        $this->db->from("tr_approval");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $this->db->where("type_approval", 2);
        $this->db->where("id_surat", $id_surat);


        return $this->db->get();
    }
    public function get_waiting_approval($id_surat = null)
    {
        $session = $this->session->userdata('login');

        $this->db->select("id_approval , type_approval, id_akun, status");
        $this->db->from("tr_approval");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $this->db->where("status", 1);
        $this->db->where("id_surat", $id_surat);
        $this->db->where("type_approval", 2); // check apakah ada type approval 2 (Approval)
        $this->db->group_by('id_approval');
        $this->db->order_by("type_approval", "ASC");
        $this->db->order_by("id_approval", "ASC");

        $this->db->limit(1);

        return $this->db->get();
    }
    public function insert_approval($data)
    {
        $this->db->insert('tr_approval', $data);
        return $this->db->insert_id();
    }
    public function delete_approval($data)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('id_approval', $data['id_approval']);
        $this->db->update('tr_approval', array('active' => '2'));
        return $data['id_approval'];
    }

    public function update_approval($data)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('id_approval', $data['id_approval']);
        $this->db->where("active != '2' ");
        $this->db->update('tr_approval', $data);
        return $data['id_approval'];
    }

    public function get_approval_by_id($id_approval)
    {
        if (empty($id_approval)) {
            return array();
        } else {
            $session = $this->session->userdata('login');
            $this->db->select("a.id_approval, a.status, c.nm_akun, a.id_akun, c.id_pegawai, d.nm_pegawai,  a.type_approval, a.active");
            $this->db->from("tr_approval a");
            $this->db->join("ref_akun c", "a.id_akun = c.id_akun", "left");
            $this->db->join("ref_pegawai d", "c.id_pegawai = d.id_pegawai", "left");
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_approval', $id_approval);
            $this->db->where("a.active != '2' ");
            return $this->db->get()->row_array();
        }
    }
    // end approval

    // ========================== model surat internal ================================
    public function getAllsurat_internal($id_surat = null, $show = null, $start = null, $cari = null)
    {
        $this->db->select("a.id_surat, a.id_surat_alias, c.nm_alias, a.active, a.id_alias, a.type_penerima ");
        $this->db->from("tr_surat_alias a");
        $this->db->join("ref_alias c", "a.id_alias = c.id_alias", "left");
        $session = $this->session->userdata('login');
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where("(c.nm_alias  LIKE '%" . $cari . "%' ) ");
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

        $this->db->select(" COUNT(a.id_surat_alias) as recordsFiltered ");
        $this->db->from("tr_surat_alias a");
        $this->db->join("ref_alias c", "a.id_alias = c.id_alias", "left");
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where("a.active != '2' ");
        $this->db->like("c.nm_alias", $search);
        $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

        $this->db->select(" COUNT(id_surat_alias) as recordsTotal ");
        $this->db->from("tr_surat_alias");
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where("active != '2' ");
        $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

        return $count;
    }

    public function insert_surat_internal($data)
    {
        $this->db->insert('tr_surat_alias', $data);
        return $this->db->insert_id();
    }

    public function delete_surat_internal($data)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('id_surat_alias', $data['id_surat_alias']);
        $this->db->delete('tr_surat_alias');
        return $data['id_surat_alias'];
    }

    public function update_surat_internal($data)
    {
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('id_surat_alias', $data['id_surat_alias']);
        $this->db->where("active != '2' ");
        $this->db->update('tr_surat_alias', $data);
        return $data['id_surat_alias'];
    }

    public function get_surat_internal_by_id($id_surat_alias)
    {
        if (empty($id_surat_alias)) {
            return array();
        } else {
            $session = $this->session->userdata('login');
            $this->db->select("a.id_surat_alias, c.nm_alias, a.id_alias, a.type_penerima, a.active");
            $this->db->from("tr_surat_alias a");
            $this->db->join("ref_alias c", "a.id_alias = c.id_alias", "left");
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where('a.id_surat_alias', $id_surat_alias);
            $this->db->where("a.active != '2' ");
            return $this->db->get()->row_array();
        }
    }
    // end model surat internal

    // model surat external

	public function getAllsurat_external($id_surat = null, $show = null, $start = null, $cari = null)
	{
		$this->db->select("a.id_surat_external, a.id_surat, a.nm_surat_external, a.email_surat_external, a.type_penerima, a.active");
		$this->db->from("tr_surat_external a");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("(a.nm_surat_external  LIKE '%" . $cari . "%' ) ");
		$this->db->where("a.active IN (0, 1) ");
		$this->db->where("a.id_surat", $id_surat);
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_surat_external($search = null)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(id_surat_external) as recordsFiltered ");
		$this->db->from("tr_surat_external");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$this->db->like("nm_surat_external ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_surat_external) as recordsTotal ");
		$this->db->from("tr_surat_external");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function insert_surat_external($data)
	{
		$this->db->insert('tr_surat_external', $data);
		return $this->db->insert_id();
	}

	public function delete_surat_external($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_surat_external', $data['id_surat_external']);
		$this->db->delete('tr_surat_external');
		return $data['id_surat_external'];
	}

	public function update_surat_external($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_surat_external', $data['id_surat_external']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_surat_external', $data);
		return $data['id_surat_external'];
	}

	public function get_surat_external_by_id($id_surat_external)
	{
		if (empty($id_surat_external)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->select("a.id_surat_external, a.nm_surat_external, a.email_surat_external, a.type_penerima, a.active");
			$this->db->from("tr_surat_external a");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_surat_external', $id_surat_external);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
	}

    // end Model surat external

    public function combobox_type_surat()
    {
        $this->db->from("ref_type_surat");
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('active', 1);
        return $this->db->get();
    }

    public function combobox_klasifikasi()
    {
        $this->db->from("ref_klasifikasi");
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('active', 1);
        return $this->db->get();
    }

    public function combobox_kategori()
    {
        $this->db->from("ref_kategori");
        $session = $this->session->userdata('login');
        $this->db->where('id_perusahaan', $session['id_perusahaan']);
        $this->db->where('active', 1);
        return $this->db->get();
    }
    // END SURAT MODEL


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
    public function combobox_alias()
    {
        $this->db->select("c.*");
        $this->db->from("ref_alias c");
        $this->db->join("ref_alias_access d", "c.id_alias = d.id_alias");
        $session = $this->session->userdata('login');
        $this->db->where('c.id_perusahaan', $session['id_perusahaan']);
        $this->db->where('c.active', 1);
        $this->db->group_by('c.id_alias');
        // $this->db->order_by("a.id_surat_alias", "asc");
        return $this->db->get();
    }
    public function combobox_akun()
    {
        $this->db->select("c.*, d.nm_pegawai");
        $this->db->from("ref_akun c");
        $this->db->join("ref_pegawai d", "c.id_pegawai = d.id_pegawai", "left");
        $session = $this->session->userdata('login');
        $this->db->where('c.id_perusahaan', $session['id_perusahaan']);
        $this->db->where('c.active', 1);
        return $this->db->get();
    }
    
    // model surat

    
}
