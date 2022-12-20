<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * Classes list:
 * - Sign_in extends CI_Controller
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @todo Description of class Sign_in
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */

class Sign_in extends CI_Controller
{
    /**
     * @todo Description of function __construct
     * @param
     * @return
     */
    
    function __construct()
    {		
        parent::__construct();	
		
		if($this->session->userdata('userid'))
		{
			redirect(base_url() . 'web','reload');
		}
    }
    /**
     * @todo Description of function index
     * @param
     * @return
     */
    
	
    function index($param = null)
    {
        $data = array();
        
        if (!empty($_POST)) {
            
			$this->form_validation->set_rules('username', 'User Name', 'xss_clean|required');
            $this->form_validation->set_rules('userpass', 'Password', 'xss_clean|required');
            
            if ($this->form_validation->run() == TRUE) {
                
				$username 	= $this->input->post('username');
                $userpass	= md5($this->input->post('userpass'));
				
				$this->db->where(array(
									   'username'=>	$username,
									   'userpass'=>	$userpass,
									   'terhapus'=> 'N'
									   )
								 );
                
				$rs = $this->db->get('tbl_user');
				
                if ($rs->num_rows() != 0) {
                    
					$id = $rs->row()->id;                    
                    $nama_lengkap = $rs->row()->nama_lengkap;
                    $username = $rs->row()->username;					
                    $email = $rs->row()->email;
					$level = $rs->row()->level;
					$akses_menu = $rs->row()->akses_menu;
					$otorisasi_trans = $rs->row()->otorisasi_trans;
					
                    $this->session->set_userdata('userid', $id);                    
                    $this->session->set_userdata('nama_lengkap', $nama_lengkap);
                    $this->session->set_userdata('username', $username);                    
                    $this->session->set_userdata('email', $email);
					$this->session->set_userdata('level', $level );
					$this->session->set_userdata('akses_menu',$akses_menu);
					$this->session->set_userdata('otorisasi_trans',$otorisasi_trans);
					
					//$param = $this->_get_akses($akses_menu);
					//$this->session->set_userdata('menu',$param);
					
					redirect(base_url() . 'web','reload');
					
                } else {
					$data['msg'] = 'UserName Atau Password Salah!';
                }
            } else {
				$data['msg'] = validation_errors();
            }
        }        
		
		$data['page_title'] = 'Please SignIn';        
		$this->load->view('sign_in',$data);	
    }
}

