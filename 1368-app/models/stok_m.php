<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stok_m extends CI_Model
{
    public $limit;
    public $offset;
    public $sort;
    public $order;
    

    function __construct()
    {
        parent::__construct();
    }
    
    function get(){
      
      /*
      
      SELECT a.id,a.kode_bahan,a.deskripsi,id_satuan,IFNULL(b.stok,0) as stok
      FROM tbl_bahan_mentah a
      LEFT JOIN tbl_stok b ON a.id = b.id_bahan_mentah
      WHERE a.terhapus = 'N'
      ORDER BY a.kode_bahan
      
      */
      
        $this->db->select('a.id,a.kode_bahan,a.deskripsi,a.updated_at,IFNULL(b.stok,0) as stok,c.nama as satuan',FALSE);
        $this->db->join('tbl_stok b','a.id = b.id_bahan_mentah','left');
        $this->db->join('tbl_satuan c','a.id_satuan = c.id','left');
        $this->db->where('a.terhapus = \'N\'');
        $this->db->order_by('a.kode_bahan','ASC');
        return $this->db->get('tbl_bahan_mentah a');
      
    }
    
    function opname($mode = null){
      
        $cari = $this->session->userdata('cari');      
        $rs = null;

        $this->db->select('a.stok_lama,a.stok_baru,a.keterangan,a.updated_at,
                           b.nama_lengkap,
                           c.kode_bahan,c.deskripsi,
                           d.nama as satuan');

        if($cari)
        {
            $this->db->where("( a.keterangan LIKE '%$cari%' OR
                                b.nama_lengkap LIKE '%$cari%' OR
                                c.kode_bahan LIKE '%$cari%') ");           
        }

        $this->db->join('tbl_user b','a.id_user = b.id','left');
        $this->db->join('tbl_bahan_mentah c','a.id_bahan_mentah = c.id','left');
        $this->db->join('tbl_satuan d','c.id_satuan = d.id','left');
        
        //$this->db->order_by('a.updated_at','DESC');
        //return $this->db->get('tbl_stok_opname a');

        if($mode === 'numrows'){

            $rs = $this->db->get('tbl_stok_opname a')->num_rows();  

        }elseif($mode === 'pagging'){

            $this->db->order_by($this->sort,$this->order);
            $this->db->limit($this->limit,$this->offset);   
            $rs = $this->db->get('tbl_stok_opname a');      

        }elseif($mode === 'showall'){

            $this->db->order_by($this->sort,$this->order);       
            $rs = $this->db->get('tbl_stok_opname a');     

        }

        return $rs;
        
    }
}