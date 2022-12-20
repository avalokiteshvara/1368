<?php

    function _get_menu($id_parent,$tipe = 'menu')
    {
        $CI =& get_instance();
        
        $menu_level = explode(',',$CI->session->userdata('akses_menu'));
        
        $data = array();
        $CI->db->from('tbl_menu');
        $CI->db->where('id_parent',$id_parent);
        
        if($tipe === 'menu'){
            $CI->db->where_in('id',$menu_level);    
        }
        
        
        $CI->db->order_by('id','ASC');
        $result = $CI->db->get();
        
        foreach($result->result() as $row)
        {
            $data[] = array(
                'id_parent' =>  $row->id_parent,
                'id'        =>  $row->id,
                'nama'     =>  $row->nama,
                'url'      =>  $row->url,
                'icon'      =>  $row->icon,                
                'child'     =>  _get_menu($row->id)
            );
          
        }
        
        return $data;
        
    }
    
    function _print_submenu($data_menu,$tipe)
    {
        $str = "";
        $result = "";
        

        foreach($data_menu as $r)
        {
            if($tipe === 'menu'){                                
                $str .= '<li><a tabindex="-1" href="' . base_url() . $r['url'] .'"><i class="fa '.$r['icon'].'"> </i> <titleid id="menu_'. $r['id'] .'">' .$r['nama'].'</titleid></a></li>' . PHP_EOL;
            }else{
                
                $str .= '<li><input type="checkbox" kode="' . $r['id'] . '" id="cb_' . $r['id']. '"><label style="font-size:10pt;font-weight:400">' . $r['nama'] . '</label>' . PHP_EOL;                
            }
            
            
            $str .= _print_submenu($r['child'],$tipe);    
            
        }        
        
        $result .= $str . PHP_EOL;
        //echo 'result' . $result;
        return $result;

    }
    
    function build_menu($tipe = 'menu')
    {
        $CI =& get_instance();        
        $menu_item  = _get_menu(0,$tipe);
        
        $menu = "";
        
        foreach($menu_item as $r)
        {
            if($tipe === 'menu'){
                if($r['url'] !== '#')
                {
                  /*
                  
                  <li>
                    <a data-original-title=" Klik disini untuk melihat data S. Keluar" href="http://localhost/persuratan/surat/surat_keluar"><i class="fa fa-folder"> </i> S. Keluar { 0 }</a></li>
                  
                  */
                    $menu .= '<li><a data-original-title="Klik disini untuk melihat data ' . $r['nama'] . '" href="' . base_url() .  $r['url'] . '"><i class="fa '. $r['icon'] . '"></i> '.$r['nama'].'</a></li>' . PHP_EOL;
                    
                }else{
                    
                    $menu .= '<li class="dropdown">' .PHP_EOL;
                    $menu .= '  <a data-original-title="Klik disini untuk melihat data ' . $r['nama'] . '"  class="dropdown-toggle" data-toggle="dropdown" href="#">' ;
                    $menu .= '    <i class="fa ' . $r['icon'] .'"></i> <titleid id="menu_'. $r['id'] .'">' . $r['nama']. '</titleid> <i class="fa fa-caret-down"></i>';
                    $menu .= '  </a>';
                    $menu .= '  <ul style="left:0px;right:auto;min-width:260px" class="dropdown-menu dropdown-user">';
                    $menu .=        _print_submenu($r['child'] , $tipe);
                    $menu .= '  </ul>';
                    $menu .= '</li>';
                }    
            }else{
                //build level
                if($r['url'] !== '#')
                {
                    $menu .= '<li><input type="checkbox" kode="' . $r['id'] . '" id="cb_' . $r['id']. '"><label style="font-size:10pt;font-weight:400">' . $r['nama'] . '</label>' . PHP_EOL;
                    
                }else{
                    
                    $menu .= '<li><input type="checkbox" kode="' . $r['id'] . '" id="cb_' . $r['id']. '"><label style="font-size:10pt;font-weight:400">' . $r['nama'] . '</label>' . PHP_EOL;
                    $menu .= '<ul>';
                    $menu .= _print_submenu($r['child'] , $tipe);                                        
                    $menu .= '</ul>';    
                }
            }
            
        }
        
        return $menu;

                
    }