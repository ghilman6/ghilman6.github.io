<?php
class Model_surat_external extends CI_Model
{
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
		$this->db->update('tr_surat_external', array('active' => '2'));
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
}
