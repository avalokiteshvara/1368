<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - _no_goback()
 * - _check_auth()
 * Classes list:
 * - MY_Controller extends CI_Controller
 */

class MY_Controller extends CI_Controller
{
    protected $_open_controllers = array(
        'sign_in','sign_out'
    );
    
    public function __construct()
    {
        parent::__construct();
        $this->_check_auth();
    }
    
    private function _no_goback()
    {
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }
    
    private function _is_allowed($class,$method){
        
        $url = $class . '/' . $method; 
        $this->db->like('url_bawah',$url);
        $rs = $this->db->get('tbl_menu')->row();
        //echo $url;
        $id = $rs->id;
        
        $akses_menu = explode(',',$this->session->userdata('akses_menu'));
        $result = FALSE;
        
        if(in_array($id,$akses_menu)){
            $result = TRUE;
        }
        
        return $result;
    }
    
    private function _check_auth()
    {
        $level = $this->session->userdata('level');       
        
        if (!$this->session->userdata('userid')) {

            //jika belum login
            
            if (!in_array($this->router->class, $this->_open_controllers)) {

                //dan bukan akses yang diperbolehkan
                redirect(base_url() , 'reload'); //go back kids!                
            }
            
        } else {

            $curr_method = $this->session->userdata('curr_method');
            $method = $this->router->method; 
            
            if(!$curr_method){
                $this->session->set_userdata('curr_method',$method);
            }else{
                if($curr_method !== $method){
                    $this->session->unset_userdata('cari');
                    $curr_method = $this->session->set_userdata('curr_method',$method);                    
                }        
            }    

            $class = $this->router->class;
            
            if(($class !== 'web' && $method !== 'index') && $class !== 'sign_out' ){            
                             
                if(!$this->_is_allowed($class,$method)){
                    redirect(base_url() , 'reload'); //go back kids!                
                }
            }            
            
            $this->_no_goback();
        }
    }
}

