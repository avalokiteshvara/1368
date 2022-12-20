<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pesan_m extends CI_Model
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
    

    function get($tipe = null,$mode = null,$param = null){
      
        $id = $this->session->userdata('userid');
        $cari = $this->session->userdata('cari');
        $rs = null;
        
        $this->db->select('a.*,b.nama_lengkap as pengirim ,c.nama_lengkap as penerima',FALSE);
        $this->db->join('tbl_user b','a.id_pengirim = b.id','left');
        $this->db->join('tbl_user c','a.id_penerima = c.id','left');
        
        if($tipe === 'keluar'){

          $this->db->where('b.id',$id);
          $this->db->where('a.terhapus_pengirim','N');

        }else{

          $this->db->where('c.id',$id);
          $this->db->where('a.terhapus_penerima','N');

        }
               
        
        if($cari)
        {
           $this->db->where("(b.nama_lengkap LIKE '%$cari%' OR
                              c.nama_lengkap LIKE '%$cari%' OR
                              a.status LIKE '%$cari%' OR
                              a.isi LIKE '%$cari%')
                            "); 
        }
        
        
       
        if($mode === 'numrows'){

            $rs = $this->db->get('tbl_pesan a')->num_rows();  

        }elseif($mode === 'pagging'){

          $this->db->order_by($this->sort,$this->order);
          $this->db->limit($this->limit,$this->offset);   
          $rs = $this->db->get('tbl_pesan a');      

        }elseif($mode === 'showall'){

          $this->db->order_by($this->sort,$this->order);       
          $rs = $this->db->get('tbl_pesan a');     

        }elseif($mode === 'read'){
          $this->db->where('a.id',$param);
          $rs = $this->db->get('tbl_pesan a');    
        }

        return $rs;
    }
    
    
    
}