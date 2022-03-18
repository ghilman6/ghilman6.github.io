<?php
    class Model_menu_details extends CI_Model
    {
        public function getAllmenu_details($show=null, $start=null, $cari=null)
        {
            $this->db->select('a.id_menu_details, a.kd_menu_details, a.nm_menu_details, a.url, a.position, c.nm_menu_groups as nm_groups, c.id_menu_groups, a.active');
            $this->db->from('ref_menu_details a');
            $this->db->join('ref_menu_groups c', 'a.id_menu_groups = c.id_menu_groups');
            $this->db->order_by("id_menu_groups", "asc");
            $this->db->order_by("id_menu_details", "asc");
            $this->db->order_by("position", "asc");
            $this->db->where("(a.nm_menu_details  LIKE '%".$cari."%' OR  a.position  LIKE '%".$cari."%' OR  c.nm_menu_groups  LIKE '%".$cari."%') ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

        public function Insertmenu_details($data)
        {
            $this->db->insert('ref_menu_details', $data);
        }

        public function Deletetmenu_details($id_menu_details)
        {
            $this->db->where('id_menu_details', $id_menu_details);
            $this->db->delete('ref_menu_details');
        }

        public function getAllmenu_detailsselect($id_menu_details)
        {
            $this->db->from("ref_menu_details");
            $this->db->where('id_menu_details', $id_menu_details);
            return $this->db->get();
        }

        public function Updatemenu_details($id_menu_details, $data)
        {
            $this->db->where('id_menu_details', $id_menu_details);
            $this->db->update('ref_menu_details', $data);
        }

        public function combobox_menu_groups()
        {
            $this->db->from("ref_menu_groups");
            $this->db->where('active', 1);
            return $this->db->get();
        }
    }
