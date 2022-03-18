<?php
class Model_inbox extends CI_Model
{
    public function getAllSurat($show = null, $start = null, $cari = null, $id_akun = null)
    {
        $this->db->select("a.id_surat, b.nm_type_surat, c.nm_klasifikasi, d.nm_kategori, a.perihal, a.isi_surat, a.active, a.cdate ,e.nm_user, a.tgl_surat");
        $this->db->from("tr_surat_internal aa");
        $this->db->join("tr_surat a", "aa.id_surat = a.id_surat", "left");
        $this->db->join("ref_type_surat b", "a.id_type_surat = b.id_type_surat", "left");
        $this->db->join("ref_klasifikasi c", "a.id_klasifikasi = c.id_klasifikasi", "left");
        $this->db->join("ref_kategori d", "a.id_kategori = d.id_kategori", "left");
        $this->db->join("ref_user e", "a.cuser = e.id_user", "left");

        $session = $this->session->userdata('login');
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where('aa.id_akun', $id_akun);
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
        $this->db->from("tr_surat_internal a");
        $this->db->join("tr_surat b", "a.id_surat = b.id_surat", "left");
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->where('a.id_akun', $id_akun);
        $this->db->where("b.active", 3);      
        $this->db->like("b.perihal ", $search);
        $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

        $this->db->select(" COUNT(id_surat) as recordsTotal ");
        $this->db->from("tr_surat_internal");
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
    public function combobox_penerima_internal()
    {
        $session = $this->session->userdata('login');
        $id_perusahaan = $session['id_perusahaan'];
        // $this->db->select("distinct x.id_bu,x.nm_bu,x.nm_akun,x.nm_user,x.nm_alias");
        // $query = "(select 
        // distinct 
        // d.id_bu,d.nm_bu,c.nm_akun,f.nm_user,b.nm_alias
        // from 
        // ref_alias_access a,
        // ref_alias b,
        // ref_akun c ,
        // ref_bu d,
        // ref_akun_access e,
        // ref_user f
        // where 
        // a.id_alias = b.id_alias and
        // a.id_akun = c.id_akun and
        // d.id_bu = c.id_bu and
        // e.id_user = f.id_user and
        // e.id_akun = a.id_akun
        // order by id_bu) x";
        // $this->db->from("(
        //                     select '' id_alias, id_bu, 'a' posisi, nm_bu nama, '' active, '' id_pegawai from ref_bu where id_perusahaan = '77' and active = 1 and
        //                     id_bu in (select id_bu from ref_akun) 
        //                     UNION ALL   
        //                     select a.id_alias, d.id_bu, 'b' posisi, 
        //                     case when left(a.nm_alias,4) = 'Para'
        //                                 then nm_alias
        //                             when left(a.nm_alias,7) = 'Direksi'
        //                                 then nm_alias
        //                             when left(a.nm_alias,7) = 'Seluruh'
        //                               then nm_alias
        //                             else CONCAT(a.nm_alias,' - ',nm_akun)
        //                                 end nama,
        //                     b.active, c.id_akun from ref_alias a
        //                     join ref_alias_access b on a.id_alias = b.id_alias
        //                     join ref_akun c on b.id_akun = c.id_akun
        //                     join ref_bu d on c.id_bu = d.id_bu
        //                     where (select count(id_alias) from ref_alias_access where id_alias = a.id_alias) != '0' and a.active = '1'
        //                 ) x");
        // $this->db->from($query);
        // $this->db->where("active != '2'");
        // $this->db->where("set_penerima != '0'");
        // $this->db->order_by("id_bu", "ASC");
        // $this->db->order_by("posisi", "ASC");


        $this->db->select("c.*");
        $this->db->from("ref_alias c");
        $this->db->join("ref_alias_access d", "c.id_alias = d.id_alias");
        $this->db->where('c.id_perusahaan', $session['id_perusahaan']);
        $this->db->where('c.active', 1);
        $this->db->group_by('c.id_alias');
        return $this->db->get();
    }

    public function insert_disposisi_head($data)
    {
        $this->db->insert('tr_disposisi', $data);
        return $this->db->insert_id();
    }
    public function insert_disposisi_note($data)
    {
        $this->db->insert('tr_disposisi_note', $data);
        return $this->db->insert_id();
    }
    public function insert_disposisi_int($data)
    {
        $this->db->insert('tr_disposisi_alias', $data);
        return $this->db->insert_id();
    }
    public function selectiddispo($id_surat)
    {
        $this->db->select('id_disposisi');
        $this->db->from('tr_disposisi');
        $this->db->where('id_surat', $id_surat);
        $this->db->where('active', 1);
        $this->db->order_by("id_disposisi","DESC");
        $this->db->limit(1);
        $query = $this -> db -> get();
        if ($query -> num_rows() == 1) {
            $result = $query->row_array();
            return $result;
        } else {
            return false;
        }
    }
    public function getAlldisposisi($id_surat = null)
    {
        $this->db->select("a.*, b.kd_surat, b.perihal, b.id_klasifikasi, c.nm_type_surat, f.kd_klasifikasi");
        $this->db->from("tr_disposisi a");
        $this->db->join("tr_surat b","a.id_surat = b.id_surat", 'left');
        $this->db->join("ref_type_surat c","b.id_type_surat = c.id_type_surat", 'left');
        // $this->db->join("tr_disposisi_int d","a.id_disposisi = d.id_disposisi", 'left');
        $this->db->join("ref_klasifikasi f","b.id_klasifikasi = f.id_klasifikasi", 'left');
        $session = $this->session->userdata('login');
        $this->db->where('a.id_surat', $id_surat);
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $this->db->order_by("a.id_surat","DESC");
        return $this->db->get();
    }

    
    public function get_count_disposisi($id_surat = null)
    {
        $count = array();
        $session = $this->session->userdata('login');
        
        $this->db->select(" COUNT(a.id_disposisi) as recordsFiltered ");
        $this->db->from("tr_disposisi a");
        $this->db->join("tr_surat b","a.id_surat = b.id_surat", 'left');
        // $this->db->join("tr_disposisi_int d","a.id_disposisi = d.id_disposisi", 'left');
        $session = $this->session->userdata('login');
        $this->db->where('a.id_surat', $id_surat);
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
        
        $this->db->select(" COUNT(a.id_disposisi) as recordsTotal ");
        $this->db->from("tr_disposisi a");
        $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
        $count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
        
        return $count;
    }
}
