<?php
class Model_home extends CI_Model
{
	public function UpdateUser($id_user, $data)
	{
		$this->db->where('id_user', $id_user);
		$this->db->update('ref_user', $data);
	}

	public function datapaketchartweek()
	{
		$session = $this->session->userdata('login');
		$get =  $this->db->query("SELECT date(datetime_in) waktu,count(id_logistics) totalpaket
										FROM tr_masuk_logistics
										WHERE origin = " . $this->db->escape($session['id_point']) . " and
										datetime_in >= (CURDATE() - INTERVAL 7 DAY)
										GROUP BY
											date(datetime_in)
										ORDER BY date(datetime_in) DESC
										LIMIT 7
										");

		$record = $get->result();

		return json_encode($record);
	}
	public function data_grafik_tipe_surat($startDate = null, $endDate = null)
	{
		$session = $this->session->userdata('login');

		$query = "SELECT b.nm_type_surat as name, count(a.id_surat) as y FROM tr_surat a LEFT JOIN ref_type_surat b ON a.id_type_surat = b.id_type_surat"; //SELECT

		if ($startDate == null || $endDate == null) { // WHERE
			$query .= " WHERE MONTH(cdate) = MONTH(CURRENT_DATE()) AND YEAR(cdate) = YEAR(CURRENT_DATE()) AND YEAR(cdate) = YEAR(CURRENT_DATE()) AND b.active = 1 ";
		} else {
			$query .= " WHERE (cdate BETWEEN ' " . $startDate . " ' AND ' " . $endDate . " ') AND b.active = 1 ";
		}
		$query .= "GROUP BY b.id_type_surat ORDER BY date(cdate) DESC"; // GROUP BY AND ORDER BY

		$get =  $this->db->query($query);

		// return
		$record = $get->result();

		return json_encode($record);
	}
	public function datarevenuechartmonth()
	{
		$session = $this->session->userdata('login');
		$get =  $this->db->query("SELECT date(cdate) wakturevenue,sum(nilai_revenue) totalrevenue
										FROM tr_rekonsiliasi
										WHERE id_bu = " . $this->db->escape($session['id_bu']) . " and
										cdate >= (CURDATE() - INTERVAL 7 DAY)
										GROUP BY
											date(cdate)
										ORDER BY date(cdate) DESC
										LIMIT 7
										");

		$record = $get->result();

		return json_encode($record);
	}
}
