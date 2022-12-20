<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_m extends CI_Model
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
    
    function get($mode = null){
       
      $cari = $this->session->userdata('cari');
      $rs = null;

      if($cari)
      {
        $this->db->where("(nama_lengkap LIKE '%$cari%' OR
                           username LIKE '%$cari%' OR
                           email LIKE '%$cari%' OR
                           level LIKE '%$cari%') ");

      }

       $this->db->where('terhapus','N');

      if($mode === 'numrows'){
        
        $rs = $this->db->get('tbl_user')->num_rows();  

      }elseif ($mode === 'pagging'){
        
        $this->db->order_by($this->sort,$this->order);
        $this->db->limit($this->limit,$this->offset);
        $rs = $this->db->get('tbl_user'); 

      }elseif ($mode === 'showall'){

        $this->db->order_by($this->sort,$this->order);        
        $rs = $this->db->get('tbl_user'); 

      } 

     
      return $rs;
     
    }
}