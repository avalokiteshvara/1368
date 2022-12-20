<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Web extends MY_Controller
{    
    function __construct()
    {
        parent::__construct();
    }
	
	function _generate_page($data)
    {		
        $this->load->view('page', $data);
    }
	
	function index()
	{		
		$this->load->model(array('basecrud_m','menu_m'));
		$data = array('page_name'	=>	'home',
					  'menu_bawah'  =>  $this->menu_m->menu_bawah(0)
					  );
		$this->_generate_page($data);
	}
	
	
	function profile($cmd = null){
		
		$userid = $this->session->userdata('userid');
		$this->load->model(array('basecrud_m'));
		$data = array();
		
		if($cmd === 'edt_act'){
			
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'xss_clean|required');
			$this->form_validation->set_rules('email', 'Email', 'xss_clean|required');
			$this->form_validation->set_rules('telp', 'No Telp', 'xss_clean');
			
			if ($this->form_validation->run() == TRUE) {
				
				$in = array('nama_lengkap'=> $this->input->post('nama_lengkap'),
							'email'=> $this->input->post('email'),
							'telp'=> $this->input->post('telp'),
							);
				
				$this->basecrud_m->update('tbl_user',$userid,$in);
				$data['msg'] = 'Data Profile berhasil dirubah';
				
				
			}else{
				
				$data['msg'] = validation_errors();							  
				
			}
			
		}
		
		$data['page_name'] 	= 'web/f_profile';
		$data['page_title'] = 'Profile';
		$data['profile'] 	= $this->basecrud_m->get_where('tbl_user',array('id'=>$userid))->row();						  
		$this->_generate_page($data);	
		
	}
	
	function password($cmd =null){
		
		$this->load->model(array('basecrud_m'));
		$data = array();
		
		if($cmd === 'edt_act'){
			
			$this->form_validation->set_rules('old_pass','Password Lama','xss_clean|required');
			$this->form_validation->set_rules('new_pass','Password Baru','xss_clean|required');
			$this->form_validation->set_rules('repeat_pass','Password Ulangan','xss_clean|required|matches[new_pass]');
			
			if ($this->form_validation->run() == TRUE) {
				
				$old_pass = $this->input->post('old_pass');
				$new_pass = $this->input->post('new_pass');
				//echo $old_pass;
				
				$ret =  $this->basecrud_m->change_password($old_pass, $new_pass);
				$data['msg'] = ($ret == TRUE) ? 'Password berhasil dirubah' : 'Password lama salah!';	
				$data['msg_status'] = ($ret == TRUE) ? 'SUCCESS' : 'ERROR';
				
				
			}else{
				
				$data['msg'] = validation_errors();							  
				
			}
			
		}
		
		$data['page_name'] 	= 'web/f_changepass';
		$data['page_title'] = 'Ganti Password';								  
		$this->_generate_page($data);	
	}
	
	function log_akses(){
		
	}
	

}