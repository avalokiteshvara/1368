<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Konsumen_m extends CI_Model
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

      if($cari){
        $this->db->where("(nama LIKE '%$cari%' OR
                            kantor LIKE '%$cari%' OR
                            cp_nama LIKE '%$cari%') ");         
      }

      $this->db->where('terhapus','N');
      //$this->db->order_by('nama','ASC');
      //return $this->db->get('tbl_konsumen');

      if($mode === 'numrows'){

        $rs = $this->db->get('tbl_konsumen')->num_rows();  

      }elseif($mode === 'pagging'){

        $this->db->order_by($this->sort,$this->order);
        $this->db->limit($this->limit,$this->offset);   
        $rs = $this->db->get('tbl_konsumen');      

      }elseif($mode === 'showall'){

        $this->db->order_by($this->sort,$this->order);       
        $rs = $this->db->get('tbl_konsumen');     

      }

      return $rs;

    }
}