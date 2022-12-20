<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - masuk()
* - keluar()
* Classes list:
* - Pesan extends MY_Controller
*/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends MY_Controller
{
    
    /**
     * [__construct description]
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * [_generate_page description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function _generate_page($data)
    {	
        $this->load->view('page', $data);
    }
    
    function index()
    {
      
        $this->load->model(array('basecrud_m','menu_m'));
		$data = array('page_name'	=>	'home',
					  'include_back' => 'TRUE',
					  'menu_bawah'  =>  $this->menu_m->menu_bawah(17)
					  );
		$this->_generate_page($data);
	}
    
    function pembelian(){
      
    }
    
    function penjualan(){
      
    }
    
    public function stok()
    {
        
        $this->load->model(array('basecrud_m','stok_m'));
        
        $data['page_name'] = 'laporan/l_stok';
        $data['page_title'] = 'Laporan Stok';
        $data['data'] = $this->stok_m->get();
        
        $this->_generate_page($data);

    }
}