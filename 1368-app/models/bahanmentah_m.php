<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bahanmentah_m extends CI_Model
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
    
    //tipe : pagging, numrows, showall
    function get($mode = null){
        
      $cari = $this->session->userdata('cari');
      $this->db->select('a.id,a.kode_bahan,a.deskripsi,a.hrg_terakhir, b.nama as satuan');
      
      $rs = null;
      
      if($cari){
         
         $this->db->where("(a.kode_bahan LIKE '%$cari%' OR a.deskripsi LIKE '%$cari%')");         
         
      }
      
      $this->db->where('a.terhapus','N');
      $this->db->join('tbl_satuan b','a.id_satuan = b.id','left');

      if($mode === 'numrows'){

        $rs = $this->db->get('tbl_bahan_mentah a')->num_rows();  

      }elseif($mode === 'pagging'){

        $this->db->order_by($this->sort,$this->order);
        $this->db->limit($this->limit,$this->offset);   
        $rs = $this->db->get('tbl_bahan_mentah a');      

      }elseif($mode === 'showall'){

        $this->db->order_by($this->sort,$this->order);       
        $rs = $this->db->get('tbl_bahan_mentah a');     

      }
      
      return $rs;
    }
}