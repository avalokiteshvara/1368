<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu_m extends CI_Model
{
    
    public $limit;
    public $offset;
    public $sort;
    public $order;
    //public $tbl_name;

    function __construct()
    {
        parent::__construct();
    }
    
    function menu_bawah($param){
      
        $menu_level = explode(',',$this->session->userdata('akses_menu'));
        $this->db->where('id_parent',$param);
        $this->db->where_in('id',$menu_level);
        $this->db->order_by('id');
        return $this->db->get('tbl_menu');
        
    }
    
    
}