<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_m extends CI_Model
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
       $q = "";

       if($cari){
        
          $q = " SELECT a.*, GROUP_CONCAT(b.kode_bahan ORDER BY b.id SEPARATOR ', ') as produk	    
                 FROM tbl_supplier a
                 INNER JOIN tbl_bahan_mentah b ON SUBSTRING(a.arr_bahan_mentah, FIND_IN_SET(b.id, a.arr_bahan_mentah) + (FIND_IN_SET(b.id, a.arr_bahan_mentah) - 1), 1) = b.id
                 WHERE (a.nama LIKE '%$cari%' OR a.alamat LIKE '%$cari%' OR a.cp_nama LIKE '%$cari%' OR
                        a.cp_jabatan LIKE '%$cari%' OR b.kode_bahan LIKE '%$cari%')
                 GROUP BY a.id ";
          
         
       }else{
          $q = " SELECT a.*, GROUP_CONCAT(b.kode_bahan ORDER BY b.id SEPARATOR ', ') as produk	    
                 FROM tbl_supplier a
                 INNER JOIN tbl_bahan_mentah b ON SUBSTRING(a.arr_bahan_mentah, FIND_IN_SET(b.id, a.arr_bahan_mentah) + (FIND_IN_SET(b.id, a.arr_bahan_mentah) - 1), 1) = b.id
                 GROUP BY a.id ";
       }       

      if($mode === 'numrows'){

        $rs = $this->db->query($q)->num_rows();  

      }elseif($mode === 'pagging'){

        $q .= "ORDER BY $this->sort $this->order 
               LIMIT $this->offset,$this->limit";
        $rs = $this->db->query($q);      

      }elseif($mode === 'showall'){

        $q .= "ORDER BY $this->sort $this->order";
        $rs = $this->db->query($q);      

      }

       return $rs;
    }
}