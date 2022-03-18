<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('lang')) {
    function lang($en, $id=null) { // {{{
        
        $mode = 'view';
        if(empty($en)) return '';
        $local = (!empty($_COOKIE['languages'])) ? $_COOKIE['languages'] : 'english';
		
        // 영어, 인도네시아어 같이 들어올 경우 번역안타기
        if(!empty($en) && !empty($id)) {
            if(!empty($id) && $local == 'indonesian') {
                return $id;
            } else {
                return $en;
            }
        }

        if($local === 'translate-e'){
            $local = 'english';
            $mode = 'translate';
        }

        // 가져와서 memcache 로?
        $CI =& get_instance();
        $CI->load->driver('cache');
        //$CI->cache->memcached->clean();
        $res = $CI->cache->memcached->get('langs');

        if(empty($res)) {
            $sql = "SELECT * FROM langs";
            $langs = $CI->load->database('default', TRUE);
            $result = $langs->query($sql);
            $return = $result->result_array();
            foreach($return as $k => $v) {
                $res['english'][strtolower($v['inkomaro'])] = $v['english'];
                $res['korean'][strtolower($v['inkomaro'])] = $v['korean'];
                $res['indonesian'][strtolower($v['inkomaro'])] = $v['indonesian'];
            }
            $CI->cache->memcached->save('langs', $res, 60*30);
        }
		
        if(!array_key_exists(strtolower($en), $res[$local])) { // 없는 경우
            // DB에 저장
            $lang_prm['inkomaro'] = $en;
            if(ENVIRONMENT !== 'development') {
                $langs = $CI->load->database('default', TRUE);
                $query = $langs->insert_string('langs', $lang_prm);
                $query = str_replace("INSERT INTO", "INSERT IGNORE INTO", $query);
                $langs->query($query);
            }
            if($mode == 'translate'){
                return '<code>['.$en.']</code> : ';
            }
            else{
                return $en;
            }
        } else {
            if($mode == 'translate'){
                return (empty($res[$local][strtolower($en)])) ? '<code>['.$en.']</code> : ' : '<code>['.$en.']</code> : '.$res[$local][strtolower($en)];
            }
            else{
                return (empty($res[$local][strtolower($en)])) ? $en : $res[$local][strtolower($en)];
            }
        }
    } // }}}

}