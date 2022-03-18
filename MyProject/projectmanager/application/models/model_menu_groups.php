<?php
    class Model_menu_groups extends CI_Model
    {
        public function getAllmenu_groups($show=null, $start=null, $cari=null)
        {
            $this->db->from("ref_menu_groups");
            $this->db->like('nm_menu_groups', $cari);
            $this->db->where("(nm_menu_groups  LIKE '%".$cari."%') ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }

        public function Insertmenu_groups($data)
        {
            $this->db->insert('ref_menu_groups', $data);
        }

        public function Deletetmenu_groups($id_menu_groups)
        {
            $this->db->where('id_menu_groups', $id_menu_groups);
            $this->db->delete('ref_menu_groups');
        }

        public function getAllmenu_groupsselect($id_menu_groups)
        {
            $this->db->from("ref_menu_groups");
            $this->db->where('id_menu_groups', $id_menu_groups);
            return $this->db->get();
        }

        public function Updatemenu_groups($id_menu_groups, $data)
        {
            $this->db->where('id_menu_groups', $id_menu_groups);
            $this->db->update('ref_menu_groups', $data);
        }

        public function combobox_menu_groups()
        {
            $this->db->from("ref_menu_groups");
            $this->db->where('active', 1);
            return $this->db->get();
        }
    }
