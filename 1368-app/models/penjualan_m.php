<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan_m extends CI_Model
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
    
    function get($mode = null)
    {
        
        $cari = $this->session->userdata('cari');       
        $this->db->select("a.*,b.nama as buyer,
                           IFNULL(c.tgl_keluar,'-') as tgl_keluar,
                           IFNULL(c.kode_keluar,'-') as kode_keluar",FALSE);
        $rs = null;

        if($cari)
        {
            $this->db->where("( a.status LIKE '%$cari%' OR
                                b.nama LIKE '%$cari%' OR
                                a.sp_nama LIKE '%$cari%' OR
                                a.sp_email LIKE '%$cari%' OR
                                a.sp_telp LIKE '%$cari%' OR                                
                                a.keterangan LIKE '%$cari%' OR
                                a.kode_penjualan LIKE '%$cari%') ");           
        }
       
        $this->db->join('tbl_konsumen b','a.id_konsumen = b.id','left');
        $this->db->join('(SELECT kode_keluar,kode_penjualan,tgl as tgl_keluar
                         FROM tbl_brg_keluar) c','a.kode_penjualan = c.kode_penjualan','left');
        $this->db->where('a.terhapus','N');
        
        if($mode === 'numrows'){

            $rs = $this->db->get('tbl_penjualan a')->num_rows();  

        }elseif($mode === 'pagging'){

            $this->db->order_by($this->sort,$this->order);
            $this->db->limit($this->limit,$this->offset);   
            $rs = $this->db->get('tbl_penjualan a');      

        }elseif($mode === 'showall'){

            $this->db->order_by($this->sort,$this->order);       
            $rs = $this->db->get('tbl_penjualan a');     

        }

        return $rs;
    }
    
    function insert_header($data){
        
        $this->db->insert('tbl_penjualan',$data);
        return $this->db->insert_id();
    }
    
    function get_kode_penjualan($cari,$status = null){
        
        $this->db->where("(kode_penjualan LIKE '%$cari%')");
        if($status != null){
            $this->db->where("(status = '$status')");
        }
        $this->db->select('kode_penjualan as value');
        return $this->db->get('tbl_penjualan');
    }
    
    function get_details($kode_penjualan){
        $this->db->select('a.*,b.nama as konsumen');
        $this->db->join('tbl_konsumen b','a.id_konsumen = b.id','left');
        return $this->db->get_where('tbl_penjualan a',array('a.kode_penjualan'=> $kode_penjualan));
    }
}