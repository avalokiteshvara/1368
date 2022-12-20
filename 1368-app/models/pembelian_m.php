<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian_m extends CI_Model
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
        $this->db->select("a.*,
                           b.nama as supplier,
                           IFNULL(c.tgl_masuk,'-') as tgl_masuk,
                           IFNULL(c.kode_masuk,'-') as kode_masuk",FALSE);
        $rs = null;

        if($cari)
        {
            $this->db->where("( a.kode_pembelian LIKE '%$cari%' OR
                                a.status LIKE '%$cari%' OR
                                b.nama LIKE '%$cari%' OR                                                             
                                a.catatan_pembelian LIKE '%$cari%') ");           
        }
       
        $this->db->join('tbl_supplier b','a.id_supplier = b.id','left');
        $this->db->join('(SELECT kode_masuk,kode_pembelian,tgl as tgl_masuk
                         FROM tbl_brg_masuk) c','a.kode_pembelian = c.kode_pembelian','left');
        $this->db->where('a.terhapus','N');
        
        if($mode === 'numrows'){

            $rs = $this->db->get('tbl_pembelian a')->num_rows();  

        }elseif($mode === 'pagging'){

            $this->db->order_by($this->sort,$this->order);
            $this->db->limit($this->limit,$this->offset);   
            $rs = $this->db->get('tbl_pembelian a');      

        }elseif($mode === 'showall'){

            $this->db->order_by($this->sort,$this->order);       
            $rs = $this->db->get('tbl_pembelian a');     

        }

        return $rs;
    }
    
    function get_details_trans($id_pembelian){
        //kode_bahan,deskripsi,qty,satuan,harga,subtotal
        $this->db->select('b.kode_bahan,b.deskripsi,a.kuantitas,
                          c.nama as satuan,
                          a.harga_per_item,(a.kuantitas * a.harga_per_item) as subtotal');
        $this->db->join('tbl_bahan_mentah b','a.id_bahan_mentah = b.id','left');
        $this->db->join('tbl_satuan c','b.id_satuan = c.id','left');
        $this->db->where('a.id_pembelian',$id_pembelian);
        return $this->db->get('tbl_pembelian_details a');
    }
    
    function insert_header($data){
        
        $this->db->insert('tbl_pembelian',$data);
        return $this->db->insert_id();
    }
    
    function get_kode_pembelian($cari,$status = null){
        
        $this->db->where("(kode_pembelian LIKE '%$cari%')");
        if($status != null){
            $this->db->where("(status = '$status')");
        }
        $this->db->select('kode_pembelian as value');
        return $this->db->get('tbl_pembelian');
    }
    
    function get_ukuran($jenis,$kode_pembelian = null){

        $rs = null;
        
        $this->db->select('DISTINCT b.ukuran as ukuran',FALSE);
        $this->db->join('tbl_pembelian_details b','a.id = b.id_pembelian','left');        
        $rs = $this->db->get_where('tbl_pembelian a',array('a.kode_pembelian'=> $kode_pembelian,
                                                            'b.jenis'=>$jenis));
        
        if($rs->num_rows() == 0){            
            $this->db->select('DISTINCT ukuran',FALSE);            
            $rs = $this->db->get_where('tbl_supplier_produk',array('jenis'=>$jenis));
        }
        
        return $rs;
    }
    
    function get_jenis($kode_pembelian){

        $this->db->select('DISTINCT b.jenis as jenis',FALSE);
        $this->db->join('tbl_pembelian_details b','a.id = b.id_pembelian','left');        
        return $this->db->get_where('tbl_pembelian a',array('a.kode_pembelian'=> $kode_pembelian));
        
    }
    
    function get_details($kode_pembelian){
        $this->db->select('a.*,b.nama as supplier');
        $this->db->join('tbl_supplier b','a.id_supplier = b.id','left');
        return $this->db->get_where('tbl_pembelian a',array('a.kode_pembelian'=> $kode_pembelian)
                                    );
    }
}