<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barang_m extends CI_Model
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
    
    function get($tipe = null,$mode = null){
        
        $cari = $this->session->userdata('cari');
        $rs = null;
        
        if($tipe === 'masuk'){
        
          if($cari){
             $this->db->where("(a.kode_pembelian LIKE '%$cari%')");         
          }
       
          $this->db->select('a.id,a.tgl as tgl_masuk,a.kode_pembelian,a.pemeriksa,a.keterangan');
          $this->db->where("a.terhapus = 'N'");
          //$rs = $this->db->get('tbl_brg_masuk a');

          if($mode === 'numrows'){

            $rs = $this->db->get('tbl_brg_masuk a')->num_rows();  

          }elseif($mode === 'pagging'){

            $this->db->order_by($this->sort,$this->order);
            $this->db->limit($this->limit,$this->offset);   
            $rs = $this->db->get('tbl_brg_masuk a');      

          }elseif($mode === 'showall'){

            $this->db->order_by($this->sort,$this->order);       
            $rs = $this->db->get('tbl_brg_masuk a');     

          }

          //return $rs;
          
        }else{

          if($cari){
             $this->db->where("(a.kode_penjualan LIKE '%$cari%' OR 
                                a.pemeriksa LIKE '%$cari%')");         
          }
       
          $this->db->select('a.id,a.tgl as tgl_keluar,a.kode_penjualan,a.pemeriksa,a.keterangan');
          $this->db->where("a.terhapus = 'N'");
          //$rs = $this->db->get('tbl_brg_keluar a');

          if($mode === 'numrows'){

            $rs = $this->db->get('tbl_brg_keluar a')->num_rows();  

          }elseif($mode === 'pagging'){

            $this->db->order_by($this->sort,$this->order);
            $this->db->limit($this->limit,$this->offset);   
            $rs = $this->db->get('tbl_brg_keluar a');      

          }elseif($mode === 'showall'){

            $this->db->order_by($this->sort,$this->order);       
            $rs = $this->db->get('tbl_brg_keluar a');     

          }

        }
        
        return $rs;        
    }
    
    function insert_header($tipe,$data){
        
        if($tipe === 'masuk'){
            $this->db->insert('tbl_brg_masuk',$data);    
        }else{
            $this->db->insert('tbl_brg_keluar',$data);
        }
        
        return $this->db->insert_id();
    }
    

}