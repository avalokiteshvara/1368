<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MY_Controller
{    
    function __construct()
    {
        parent::__construct();
    }
    
    function _generate_page($data)
    {		
        $this->load->view('page', $data);
    }
    
    function index(){
      
		$this->load->model(array('basecrud_m','menu_m'));
		$data = array('page_name'	=>	'home',
					  'include_back' => 'TRUE',
					  'menu_bawah'  =>  $this->menu_m->menu_bawah(1)
					  );
		$this->_generate_page($data);
        
	}
    
    /**********************************************************************************/
    function konsumen($cmd = null,$param = null){
		
		$this->load->model(array('basecrud_m','konsumen_m'));
		$data = array();
		
		if($cmd === 'cari'){			
			
			$this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');
			 
			if ($this->form_validation->run() == TRUE) {
				
				$this->session->set_userdata('cari',$this->input->post('cari'));
			}
			 
			redirect('data/konsumen','reload');
			 
		}elseif($cmd === 'clear_search'){
			
			$this->session->unset_userdata('cari');
			redirect('data/konsumen','reload');
			
		}elseif($cmd === 'add'){
			
			$data['page_name'] = 'data/f_konsumen';
			$data['page_title'] = 'Tambah Data Konsumen';
			
		}elseif($cmd === 'add_act'){
			
			$this->form_validation->set_rules('nama', 'Nama', 'xss_clean|required|is_unique[tbl_konsumen.nama]');
			$this->form_validation->set_rules('kantor', 'Alamat Kantor', 'xss_clean|required');
			$this->form_validation->set_rules('gudang', 'Alamat Gudang', 'xss_clean|required');
			$this->form_validation->set_rules('cp_nama', 'CP Nama', 'xss_clean');
			$this->form_validation->set_rules('cp_telp', 'CP Telp', 'xss_clean');
			$this->form_validation->set_rules('cp_email', 'CP Email', 'xss_clean|valid_email');
			$this->form_validation->set_rules('cp_jabatan', 'CP Jabatan', 'xss_clean');
			 
			if ($this->form_validation->run() == TRUE) {
				
				//$this->session->set_userdata('cari',$this->input->post('cari'));
				$in = array('nama'			=> $this->input->post('nama'),
							'kantor'  		=> $this->input->post('kantor'),
						    'gudang'		=> $this->input->post('gudang'),
					        'cp_nama'		=> $this->input->post('cp_nama'),
							'cp_telp'		=> $this->input->post('cp_telp'),
							'cp_email'		=> $this->input->post('cp_email'),
							'cp_jabatan'	=> $this->input->post('cp_jabatan')
							);
				$this->basecrud_m->insert('tbl_konsumen',$in);
				redirect('data/konsumen','reload');
                
			}else{
				
				$data['msg'] 		= validation_errors();
				$data['page_name'] 	= 'data/f_konsumen';
				$data['page_title'] = 'Tambah Data Konsumen';
							  
				//$this->_generate_page($data);
			}
			
		}elseif($cmd === 'edt'){
			
			$data['page_name'] 	= 'data/f_konsumen';
			$data['page_title'] = 'Edit Data Konsumen';
			$data['data'] 		= $this->basecrud_m->get_where('tbl_konsumen',array('id'=>$param))->row();
						  
			//$this->_generate_page($data);
			
		}elseif($cmd === 'edt_act'){
			
			
			$this->form_validation->set_rules('nama', 'Nama', 'xss_clean|required');
			$this->form_validation->set_rules('kantor', 'Alamat Kantor', 'xss_clean|required');
			$this->form_validation->set_rules('gudang', 'Alamat Gudang', 'xss_clean|required');
			$this->form_validation->set_rules('cp_nama', 'CP Nama', 'xss_clean');
			$this->form_validation->set_rules('cp_telp', 'CP Telp', 'xss_clean');
			$this->form_validation->set_rules('cp_email', 'CP Email', 'xss_clean|valid_email');
			$this->form_validation->set_rules('cp_jabatan', 'CP Jabatan', 'xss_clean');
			 
			if ($this->form_validation->run() == TRUE) {
				
				//$this->session->set_userdata('cari',$this->input->post('cari'));
				$in = array('nama'	=> $this->input->post('nama'),
							'kantor'  => $this->input->post('kantor'),
						    'gudang'	=> $this->input->post('gudang'),
					        'cp_nama'	=> $this->input->post('cp_nama'),
							'cp_telp'	=> $this->input->post('cp_telp'),
							'cp_email'	=> $this->input->post('cp_email'),
							'cp_jabatan'	=> $this->input->post('cp_jabatan')
							);
				$this->basecrud_m->update('tbl_konsumen',$param,$in);
				redirect('data/konsumen','reload');
				
			}else{
				
				$data['msg'] 		= validation_errors();
			    $data['page_name'] 	= 'data/f_konsumen';
				$data['page_title'] = 'Edit Data Konsumen';
				$data['data'] 		= $this->basecrud_m->get_where('tbl_konsumen',array('id'=>$param))->row();
				
			}
			
		}elseif($cmd === 'del'){
			
			$this->basecrud_m->update('tbl_konsumen',$param,array('terhapus'=>'Y'));
			redirect('data/konsumen','reload');
			
		}else{
			
			//pagination
			$url = base_url() . 'data/konsumen/';
			$res = $this->konsumen_m->get('numrows');
			$per_page = 10;
			$config = paginate($url,$res,$per_page,3);
			
			$this->pagination->initialize($config);

			$this->konsumen_m->limit = $per_page;
			if($this->uri->segment(3) == TRUE){
            	$this->konsumen_m->offset = $this->uri->segment(3);
	        }else{
	            $this->konsumen_m->offset = 0;
	        }	

			$this->konsumen_m->sort = 'nama';
        	$this->konsumen_m->order = 'ASC';
        	//end pagination

			$data['page_name']	= 'data/l_konsumen';
			$data['page_title']	= 'Data Konsumen';
			$data['data']		=	$this->konsumen_m->get('pagging');			
						  
		}
		
		$this->_generate_page($data);
	}
	
	/********************************************************************************/
	
	function user($cmd=null,$param = null){
		
		$this->load->model(array('basecrud_m','user_m'));
		
		if($cmd === 'cari'){			
			
			$this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');
			 
			if ($this->form_validation->run() == TRUE) {
				
				$this->session->set_userdata('cari',$this->input->post('cari'));
			}
			 
			redirect('data/user','reload');
			 
		}elseif($cmd === 'clear_search'){
			
			$this->session->unset_userdata('cari');
			redirect('data/user','reload');
			
		}elseif($cmd === 'add'){
			
			$data = array('page_name'	=> 'data/f_user',
						  'page_title'	=> 'Tambah Data User');					      
			$this->_generate_page($data);
			
		}elseif($cmd === 'add_act'){
			
			$this->form_validation->set_rules('level', 'Level', 'xss_clean|required');
			$this->form_validation->set_rules('username', 'User Name', 'xss_clean|required|is_unique[tbl_user.username]');
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'xss_clean|required|is_unique[tbl_user.nama_lengkap]');
			$this->form_validation->set_rules('email', 'Email', 'xss_clean|valid_email');
			$this->form_validation->set_rules('telp', 'Telp', 'xss_clean');
			 
			if ($this->form_validation->run() == TRUE) {
				
				//$this->session->set_userdata('cari',$this->input->post('cari'));
				$in = array();
				$in['username'] = $this->input->post('username');
				$in['userpass'] = md5($this->input->post('username'));
				$in['nama_lengkap']	= $this->input->post('nama_lengkap');
				$in['email'] = $this->input->post('email');
				$in['telp']	= $this->input->post('telp');
				$in['level'] = $this->input->post('level');
				$in['otorisasi_trans'] = $this->input->post('otorisasi_trans');

				$level = $this->input->post('level');
				if($level === 'custom'){
					$in['akses_menu'] = $this->input->post('akses_menu');
				}else{
					$am = $this->basecrud_m->get_where('tbl_template_akses_menu',array('level'=>$level))->row();
					$akses_menu = $am->akses_menu;
					$in['akses_menu'] = $akses_menu;
				}

				$this->basecrud_m->insert('tbl_user',$in);
				redirect('data/user','reload');
			}else{
				$data = array('msg' => validation_errors(),
							  'page_name' => 'data/f_user',
							  'page_title' => 'Tambah Data User'
							  );
				$this->_generate_page($data);
			}
			
		}elseif($cmd === 'edt'){
			
			$data = array('page_name' => 'data/f_user',
						  'page_title' => 'Edit Data User',
						  'data' => $this->basecrud_m->get_where('tbl_user',array('id'=>$param))->row()
						  );
			$this->_generate_page($data);
			
		}elseif($cmd === 'edt_act'){
			
			$this->form_validation->set_rules('level', 'Level', 'xss_clean|required');
			$this->form_validation->set_rules('username', 'User Name', 'xss_clean|required');
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'xss_clean|required');
			$this->form_validation->set_rules('email', 'Email', 'xss_clean|valid_email');			
			$this->form_validation->set_rules('telp', 'Telp', 'xss_clean');
			 
			if ($this->form_validation->run() == TRUE) {
				
				$up = array();
				$up['username'] = $this->input->post('username');
				$up['userpass'] = md5($this->input->post('username'));
				$up['nama_lengkap']	= $this->input->post('nama_lengkap');
				$up['email'] = $this->input->post('email');
				$up['telp']	= $this->input->post('telp');
				$up['level'] = $this->input->post('level');
				$up['otorisasi_trans'] = $this->input->post('otorisasi_trans');

				$level = $this->input->post('level');
				if($level === 'custom'){
					$up['akses_menu'] = $this->input->post('akses_menu');
				}else{
					$am = $this->basecrud_m->get_where('tbl_template_akses_menu',array('level'=>$level))->row();
					$akses_menu = $am->akses_menu;
					$up['akses_menu'] = $akses_menu;
				}

				$this->basecrud_m->update('tbl_user',$param,$up);
				redirect('data/user','reload');
                
			}else{
				$data = array('msg' => validation_errors(),
							  'page_name' => 'data/f_user',
							  'page_title' => 'Edit Data User',
							  'data' => $this->basecrud_m->get_where('tbl_user',array('id'=>$param))->row()
							  );
				$this->_generate_page($data);
			}
			
			
		}elseif($cmd === 'del'){
			
			$this->basecrud_m->update('tbl_user',$param,array('terhapus'=>'Y'));
			redirect('data/user','reload');
			
		}else{
			
			
			//pagination
			$url = base_url() . 'data/user/';
			$res = $this->user_m->get('numrows');
			$per_page = 10;
			$config = paginate($url,$res,$per_page,3);
			$this->pagination->initialize($config);

			$this->user_m->limit = $per_page;
			if($this->uri->segment(3) == TRUE){
            	$this->user_m->offset = $this->uri->segment(3);
	        }else{
	            $this->user_m->offset = 0;
	        }	

			$this->user_m->sort = 'username';
        	$this->user_m->order = 'ASC';
        	//end pagination

			$data = array('page_name'	=> 'data/l_user',
						  'page_title'	=> 'Data User',
					      'data'		=>	$this->user_m->get('pagging'));
			$this->_generate_page($data);
			
		}
	}
	
	/****************************************************************************/
	function supplier($cmd=null,$param=null){
		
		$data = array();		
		$this->load->model(array('basecrud_m','supplier_m'));
		
		if($cmd === 'cari'){			
			
			$this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');
			 
			if ($this->form_validation->run() == TRUE) {
				
				$this->session->set_userdata('cari',$this->input->post('cari'));				
			}

			redirect('data/supplier','reload');
			 
		}elseif($cmd === 'clear_search'){
			
			$this->session->unset_userdata('cari');
			redirect('data/supplier','reload');
			
		}elseif($cmd === 'set-raw-material'){
			
			$id = $_GET['id'];
			$arr_bahan_mentah = $_GET['arr_bahan_mentah'];
			
			$this->basecrud_m->update('tbl_supplier',$id,array('arr_bahan_mentah'=>$arr_bahan_mentah));
			exit(0);
			
		}elseif($cmd === 'add'){
			
			$data['page_name'] =  'data/f_supplier';
			$data['page_title']	= 'Tambah Data Supplier';
			
			
		}elseif($cmd === 'add_act'){
			
			$this->form_validation->set_rules('nama', 'Nama', 'xss_clean|required|is_unique[tbl_supplier.nama]');
			$this->form_validation->set_rules('alamat', 'Alamat Kantor', 'xss_clean|required');			
			$this->form_validation->set_rules('cp_nama', 'CP Nama', 'xss_clean');
			$this->form_validation->set_rules('cp_telp', 'CP Telp', 'xss_clean');
			$this->form_validation->set_rules('cp_email', 'CP Email', 'xss_clean|valid_email');
			$this->form_validation->set_rules('cp_jabatan', 'CP Jabatan', 'xss_clean');
			 
			if ($this->form_validation->run() == TRUE) {				
				
				$in = array('nama'	=> $this->input->post('nama'),
							'alamat'  => $this->input->post('alamat'),						    
					        'cp_nama'	=> $this->input->post('cp_nama'),
							'cp_telp'	=> $this->input->post('cp_telp'),
							'cp_email'	=> $this->input->post('cp_email'),
							'cp_jabatan'	=> $this->input->post('cp_jabatan')
							);
				$this->basecrud_m->insert('tbl_supplier',$in);
				redirect('data/supplier','reload');
			}else{
				
				$data['msg'] = validation_errors();
				$data['page_name'] = 'data/f_supplier';
				$data['page_title'] = 'Tambah Data Supplier';
			
			}
			
		}elseif($cmd === 'edt'){
			
			$data['page_name']   = 'data/f_supplier';
			$data['page_title']  = 'Edit Data Supplier';
			$data['data']  = $this->basecrud_m->get_where('tbl_supplier',array('id'=>$param))->row();
						  
			
			
		}elseif($cmd === 'edt_act'){
			
			$this->form_validation->set_rules('nama', 'Nama', 'xss_clean|required');
			$this->form_validation->set_rules('alamat', 'Alamat Kantor', 'xss_clean|required');			
			$this->form_validation->set_rules('cp_nama', 'CP Nama', 'xss_clean');
			$this->form_validation->set_rules('cp_telp', 'CP Telp', 'xss_clean');
			$this->form_validation->set_rules('cp_email', 'CP Email', 'xss_clean|valid_email');
			$this->form_validation->set_rules('cp_jabatan', 'CP Jabatan', 'xss_clean');
			 
			if ($this->form_validation->run() == TRUE) {
				
				
				$in = array('nama'	=> $this->input->post('nama'),
							'alamat'  => $this->input->post('alamat'),						    
					        'cp_nama'	=> $this->input->post('cp_nama'),
							'cp_telp'	=> $this->input->post('cp_telp'),
							'cp_email'	=> $this->input->post('cp_email'),
							'cp_jabatan'	=> $this->input->post('cp_jabatan')
							);
				$this->basecrud_m->update('tbl_supplier',$param,$in);
				redirect('data/supplier','reload');
				
			}else{
				
				$data['msg'] = validation_errors();
				$data['page_name']   = 'data/f_supplier';
				$data['page_title']  = 'Edit Data Supplier';
				$data['data']  = $this->basecrud_m->get_where('tbl_supplier',array('id'=>$param))->row();
				
			}
			
		}elseif($cmd === 'del'){
			
			$this->basecrud_m->update('tbl_supplier',$param,array('terhapus'=>'Y'));
			redirect('data/supplier','reload');
			
		}else{
			
			
			//pagination
			$url = base_url() . 'data/supplier/';
			$res = $this->supplier_m->get('numrows');
			$per_page = 10;
			$config = paginate($url,$res,$per_page,3);
			$this->pagination->initialize($config);

			$this->supplier_m->limit = $per_page;
			if($this->uri->segment(3) == TRUE){
            	$this->supplier_m->offset = $this->uri->segment(3);
	        }else{
	            $this->supplier_m->offset = 0;
	        }	

			$this->supplier_m->sort = 'nama';
        	$this->supplier_m->order = 'ASC';
        	//end pagination


			$data['page_name']	= 'data/l_supplier';
			$data['page_title']	= 'Data Supplier';
			$data['data']		= $this->supplier_m->get('pagging');
			$data['raw_mat']	= $this->basecrud_m->get('tbl_bahan_mentah');
						  
		}
		
		$this->_generate_page($data);
	}
	
	/************************************************************************************/
	function bahan_mentah($cmd=null,$param=null){
		
		$data = array();		
		$this->load->model(array('basecrud_m','bahanmentah_m'));
		
		if($cmd === 'cari'){		
			$this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');
			 
			if ($this->form_validation->run() == TRUE) {
				
				$this->session->set_userdata('cari',$this->input->post('cari'));
			}

			redirect('data/bahan_mentah','reload');

		}elseif($cmd === 'clear_search'){
			
			$this->session->unset_userdata('cari');
			redirect('data/bahan_mentah','reload');
			
		}elseif($cmd === 'add'){
			
			$data['page_name'] = 'data/f_bahanmentah';
			$data['page_title'] = 'Tambah Data Bahan Mentah';
			$data['satuan'] = $this->basecrud_m->get('tbl_satuan');
			
		}elseif($cmd === 'add_act'){
			
			$this->form_validation->set_rules('kode_bahan', 'Kode Bahan', 'xss_clean|required|is_unique[tbl_bahan_mentah.kode_bahan]');
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'xss_clean|required');	
			 
			if ($this->form_validation->run() == TRUE) {				
				
				$in = array('kode_bahan'	=> $this->input->post('kode_bahan'),
							'deskripsi'  	=> $this->input->post('deskripsi'),
							'id_satuan'		=> $this->input->post('id_satuan')
							);
				
				$this->basecrud_m->insert('tbl_bahan_mentah',$in);
				redirect('data/bahan_mentah','reload');
				
			}else{
				
				$data['msg'] = validation_errors();
				$data['page_name'] = 'data/f_bahanmentah';
				$data['page_title'] = 'Tambah Data Bahan Mentah';
				$data['satuan'] = $this->basecrud_m->get('tbl_satuan');
			
			}
			
		}elseif($cmd === 'edt'){
			
			$data['page_name']   = 'data/f_bahanmentah';
			$data['page_title']  = 'Edit Data Bahan Mentah';
			$data['data']  = $this->basecrud_m->get_where('tbl_bahan_mentah',array('id'=>$param))->row();
			$data['satuan'] = $this->basecrud_m->get('tbl_satuan');
			
		}elseif($cmd === 'edt_act'){
			
			$this->form_validation->set_rules('kode_bahan', 'Kode Bahan', 'xss_clean|required');
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'xss_clean|required');			
			 
			if ($this->form_validation->run() == TRUE) {				
				
				$in = array('kode_bahan'	=> $this->input->post('kode_bahan'),
							'deskripsi'  => $this->input->post('deskripsi'),							
							'id_satuan'		=> $this->input->post('id_satuan')
							);
				
				$this->basecrud_m->update('tbl_bahan_mentah',$param,$in);
				redirect('data/bahan_mentah','reload');
				
			}else{
				
				$data['msg'] = validation_errors();
				$data['page_name']   = 'data/f_bahanmentah';
				$data['page_title']  = 'Edit Data Bahan Mentah';
				$data['data']  = $this->basecrud_m->get_where('tbl_bahan_mentah',array('id'=>$param))->row();
				$data['satuan'] = $this->basecrud_m->get('tbl_satuan');
			}
			
		}elseif($cmd === 'del'){
			
			$this->basecrud_m->update('tbl_bahan_mentah',$param,array('terhapus'=>'Y'));
			redirect('data/bahan_mentah','reload');
			
		}else{

			
			//pagination
			$url = base_url() . 'data/bahan_mentah/';
			$res = $this->bahanmentah_m->get('numrows');
			$per_page = 10;
			$config = paginate($url,$res,$per_page,3);
			$this->pagination->initialize($config);

			$this->bahanmentah_m->limit = $per_page;
			if($this->uri->segment(3) == TRUE){
            	$this->bahanmentah_m->offset = $this->uri->segment(3);
	        }else{
	            $this->bahanmentah_m->offset = 0;
	        }	

			$this->bahanmentah_m->sort = 'kode_bahan';
        	$this->bahanmentah_m->order = 'ASC';
        	//end pagination

			$data['page_name']	= 'data/l_bahanmentah';
			$data['page_title']	= 'Data Bahan Mentah';
			$data['data']		= $this->bahanmentah_m->get('pagging');
			
		}
		
		$this->_generate_page($data);
	}
	
	/*************************************************************************/
	function produk($cmd = null,$param = null){
		/*
		
		KODE PRODUK    KODE BAHAN   DESKRIPSI     QTY
		001            UD 001       UDANG SUPER   10
		               PLASTIK 001  PLASTIK       10
		               DUS 10KG     DUS 10 KG     1
		
		
		
		*/
		$data = array();		
		$this->load->model(array('basecrud_m','produk_m'));
		$this->load->library('cart');
		
		if($cmd === 'cari'){
			
			$this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');
			 
			if ($this->form_validation->run() == TRUE) {
				
				$this->session->set_userdata('cari',$this->input->post('cari'));				
			}

			redirect('data/produk','reload');
			
		}elseif($cmd === 'clear_search'){
			
			$this->session->unset_userdata('cari');
			redirect('data/produk','reload');
			
		}elseif($cmd === 'get-bahan-details'){
			
			$id = $_GET['id'];
			if($id == null) exit(0);
            $b = $this->basecrud_m->get_where('tbl_bahan_mentah',array('id'=>$id));
            $c = $this->basecrud_m->get_where('tbl_satuan',array('id'=>$b->row()->id_satuan));
			
            $deskripsi = $b->num_rows() > 0 ? $b->row()->deskripsi : '';
			$satuan = $c->num_rows() > 0 ? $c->row()->nama : '';
            header("content-type: application/json");
			echo json_encode(array('deskripsi'	=>	$deskripsi,
								   'satuan' => $satuan)
							 );
			exit(0);
			
		}elseif($cmd === 'add'){
			
			$data['page_name'] = 'data/f_produk';
			$data['page_title'] = 'Tambah Data Produk';
			$data['bahan_mentah'] = $this->basecrud_m->get_where('tbl_bahan_mentah',array('terhapus'=>'N'));
			
		}elseif($cmd === 'add_detail'){
			
			$ses = array(
						 'id' => uniqid(),
						 'name' => $this->input->post('id_bahan_mentah'),
						 'qty'=>  $this->input->post('kuantitas'),
						 'price'=> 666
						 );
			
			$this->cart->insert($ses);
			$row = "";
			foreach($this->cart->contents() as $item){
				$r = $this->basecrud_m->get_where('tbl_bahan_mentah',array('id'=>$item['name']))->row();
				$row .= '<tr id="row_' . $item['rowid'] .'">
							<td>' . $r->kode_bahan . '</td>
                            <td>' . $r->deskripsi . '</td>
							<td>' . $item['qty'] . '</td>															                         
							<td class="ctr">
								<div class="btn-group">                                                                         
									<button type="button" class="btn btn-danger btn-sm" onclick="del(\''. $item['rowid'] . '\')"><i class="fa fa-trash-o "></i>Hapus</button>                                         
								</div>
							</td>
						</tr>';
			}
			
			echo $row;
			exit(0);
			
		}elseif($cmd === 'del_detail'){
			
			$ses = array(
				'rowid' => $param,
				'qty'   => 0);

			$this->cart->update($ses);
			
		}elseif($cmd === 'add_act'){			
			
			$this->form_validation->set_rules('kode_produk', 'Kode Produk', 'xss_clean|required|is_unique[tbl_produk.kode_produk]');			
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'xss_clean');			
			
			if ($this->form_validation->run() == TRUE) {
				
				$in = array('kode_produk'	=>	$this->input->post('kode_produk'),							
							'deskripsi'		=> 	$this->input->post('deskripsi')
							);
				
				$id_produk = $this->produk_m->insert_header($in);
				
				foreach ($this->cart->contents() as $item){
					$ses = array(
									'id_produk'		=> $id_produk,
                                    'id_bahan_mentah'   => $item['name'],                                    
									'kuantitas'    		=> $item['qty']
								);
					
					$this->basecrud_m->insert('tbl_produk_assemble',$ses);
				}
				
				$this->cart->destroy();
				redirect('data/produk','reload');
				
			}else{
				
				$data['msg'] = validation_errors();
				$data['page_name'] = 'data/f_produk';
				$data['page_title'] = 'Tambah Data Produk';
				$data['bahan_mentah'] = $this->basecrud_m->get_where('tbl_bahan_mentah',array('terhapus'=>'N'));
				
			}
			
		}elseif($cmd === 'edt'){
			
			$this->cart->destroy();
			
			$det = $this->basecrud_m->get_where('tbl_produk_assemble',array('id_produk'=>$param));
			$head = $this->basecrud_m->get_where('tbl_produk',array('id'=>$param))->row();
			
			$data['page_title'] = 'Edit Data Produk';
			$data['page_name'] = 'data/f_produk';
			$data['bahan_mentah'] = $this->basecrud_m->get_where('tbl_bahan_mentah',array('terhapus'=>'N'));
			$data['data'] = $head;
			
			foreach($det->result() as $d){
				$dt_det = array(
					'id'				=> uniqid(),	
					'name'     			=> $d->id_bahan_mentah,
                    'qty'    			=> $d->kuantitas,
					'price'  			=> 666
				);
			
				$this->cart->insert($dt_det);
			}
			
		}elseif($cmd === 'edt_act'){
			
			$this->form_validation->set_rules('kode_produk', 'Kode Produk', 'xss_clean|required');			
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'xss_clean');			
			
			if ($this->form_validation->run() == TRUE) {
				
				$in = array('kode_produk'	=>	$this->input->post('kode_produk'),							
							'deskripsi'		=> 	$this->input->post('deskripsi')
							);
				
				$this->basecrud_m->update('tbl_produk',$param,$in);
				$this->basecrud_m->delete('tbl_produk_assemble',array('id_produk'=>$param));
				
				foreach ($this->cart->contents() as $item){
					$ses = array(
									'id_produk'			=> $param,
                                    'id_bahan_mentah'   => $item['name'],                                    
									'kuantitas'    		=> $item['qty']
								);
					
					$this->basecrud_m->insert('tbl_produk_assemble',$ses);
				}
				
				$this->cart->destroy();
				redirect('data/produk','reload');
				
			}else{
				
				$data['msg'] = validation_errors();
				$data['page_name'] = 'data/f_produk';
				$data['page_title'] = 'Tambah Data Produk';
				$data['data'] =  $this->basecrud_m->get_where('tbl_produk',array('id'=>$param))->row();
				$data['bahan_mentah'] = $this->basecrud_m->get_where('tbl_bahan_mentah',array('terhapus'=>'N'));
			}
			
		}elseif($cmd === 'del'){
			
			$this->basecrud_m->update('tbl_produk',$param,array('terhapus'=>'Y'));
			$det = $this->basecrud_m->get_where('tbl_produk_assemble',array('id_produk'=>$param));
			
			foreach($det->result() as $d){
				$id = $d->id;
				$this->basecrud_m->update('tbl_produk_assemble',$id,array('terhapus'=>'Y'));	
			}
			
			redirect('data/produk','reload');
			
		
		}else{
			
			$this->cart->destroy();
			
			//pagination
			$url = base_url() . 'data/produk/';
			$res = $this->produk_m->get('numrows');
			$per_page = 10;
			$config = paginate($url,$res,$per_page,3);
			$this->pagination->initialize($config);

			$this->produk_m->limit = $per_page;
			if($this->uri->segment(3) == TRUE){
            	$this->produk_m->offset = $this->uri->segment(3);
	        }else{
	            $this->produk_m->offset = 0;
	        }	

			$this->produk_m->sort = 'kode_produk';
        	$this->produk_m->order = 'ASC';
        	//end pagination

			$data['page_name']	= 'data/l_produk';
			$data['page_title']	= 'Data Produk';
			$data['data']		= $this->produk_m->get('pagging');						
		}
		
		$this->_generate_page($data);
	}
}