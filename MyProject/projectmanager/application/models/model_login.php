<?php

    class Model_login extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function login($username, $password)
        {
            $this->load->database();
            $this -> db -> select('a.*, b.nm_perusahaan, b.language');
            $this -> db -> from('ref_user a');
            $this -> db -> join('ref_perusahaan b', ' a.id_perusahaan = b.id_perusahaan', 'left');
            $this -> db -> where('a.username', $username);
            $str = do_hash($password, 'md5');
            $this -> db -> where('a.password', $str);
            $this -> db -> where('a.active', 1);
            $this -> db -> limit(1);

            $query = $this -> db -> get();

            if ($query -> num_rows() == 1) {
                $result = $query->result();

                return $result;
            } else {
                return false;
            }
        }
    }
