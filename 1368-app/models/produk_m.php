<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Produk_m extends CI_Model
{
    
    public $limit;
    public $offset;
    public $sort;
    public $order;
    

    function __construct()
    {
        parent::__construct();
    }
    
    function get($mode = null){
       
       $cari = $this->session->userdata('cari');
       $rs = null;

       if($cari)
       {
          $this->db->where("(a.kode_produk LIKE '%$cari%' OR
                             a.deskripsi LIKE '%$cari%') ");
       }
       
       $this->db->where('a.terhapus','N');    

       if($mode === 'numrows'){

        $rs = $this->db->get('tbl_produk a')->num_rows();  

      }elseif($mode === 'pagging'){

        $this->db->order_by($this->sort,$this->order);
        $this->db->limit($this->limit,$this->offset);   
        $rs = $this->db->get('tbl_produk a');      

      }elseif($mode === 'showall'){

        $this->db->order_by($this->sort,$this->order);       
        $rs = $this->db->get('tbl_produk a');     

      }
      
      return $rs;
    }
    
    function insert_header($data){
        
        $this->db->insert('tbl_produk',$data);
        return $this->db->insert_id();
    }
}