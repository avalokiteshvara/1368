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

class Pesan extends MY_Controller
{
    
    function __construct()
    {
        parent::__construct();
    }
    
    function _generate_page($data)
    {	
        $this->load->view('page', $data);
    }
    
    /**********************************************************************************************/
    function index(){
      
		$this->load->model(array('basecrud_m','menu_m'));
		$data = array('page_name'	=>	'home',
					  'include_back' => 'TRUE',
					  'menu_bawah'  =>  $this->menu_m->menu_bawah(13)
					  );
		$this->_generate_page($data);
	}
    
    /**********************************************************************************************/
    function masuk($cmd = null, $param = null)
    {
        $this->load->model(array(
            'basecrud_m',
            'pesan_m'
        ));
        
        if ($cmd === 'cari') {
            
            $this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');
            
            if ($this->form_validation->run() == TRUE) {
                $this->session->set_userdata('cari', $this->input->post('cari'));                
            }

            redirect('pesan/masuk', 'reload');

        } elseif ($cmd === 'clear_search') {
          
            $this->session->unset_userdata('cari');
            redirect('pesan/masuk', 'reload');
            
        } elseif ($cmd === 'read') {
          
            header("content-type: application/json");
            $this->basecrud_m->update('tbl_pesan', $param, array(
                'status' => 'terbaca'
            ));

            $rs = $this->pesan_m->get('masuk','read',$param)->row();
            echo '{"id":"' . $rs->id . '",
                   "pengirim":"' . $rs->pengirim . '",
                   "penerima":"' . $rs->penerima . '",
                   "status":"' . $rs->status . '",
				   "subyek":"' . $rs->subyek . '",
                   "isi":"' . $rs->isi . '"}';
            exit(0);
            
        } elseif ($cmd === 'reply') {

            $userid = $this->session->userdata('userid');
            $data = array(
                'page_name' => 'pesan/f_pesan_keluar',
                'page_title' => 'Buat Pesan Baru',
                'penerima' => $this->basecrud_m->get_where('tbl_user', 
                                    array(
                                        'id <>' => $userid,
                                        'terhapus' => 'N')
                              ),
                'data' => $this->basecrud_m->get_where('tbl_pesan',array('id'=>$param))->row()
            );

            $this->_generate_page($data);

        } elseif ($cmd === 'reply-act') {
          
        } elseif ($cmd === 'del') {
          
            $this->basecrud_m->update('tbl_pesan', $param, array(
                'terhapus_penerima' => 'Y'
            ));
            redirect('pesan/masuk', 'reload');
            
        } else {
          
            //pagination
            $url = base_url() . 'pesan/masuk/';
            $res = $this->pesan_m->get('masuk','numrows');
            $per_page = 10;
            $config = paginate($url,$res,$per_page,3);
            $this->pagination->initialize($config);

            $this->pesan_m->limit = $per_page;
            if($this->uri->segment(3) == TRUE){
                $this->pesan_m->offset = $this->uri->segment(3);
            }else{
                $this->pesan_m->offset = 0;
            }   

            $this->pesan_m->sort = 'a.tgl_kirim';
            $this->pesan_m->order = 'DESC';
            //end pagination

            //get list
            $data = array(
                'page_name' => 'pesan/l_pesan_masuk',
                'page_title' => 'Data Pesan Masuk',
                'data' => $this->pesan_m->get('masuk','pagging')
            );

            $this->_generate_page($data);
            
        }
    }
    
    /************************************************************************************/
    function keluar($cmd = null, $param = null)
    {
        $this->load->model(array(
            'basecrud_m','pesan_m'
        ));
        
        if ($cmd === 'cari') {
            
            $this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');
            
            if ($this->form_validation->run() == TRUE) {
                
                $this->session->set_userdata('cari', $this->input->post('cari'));
                
            }

            redirect('pesan/keluar','reload');
            
        } elseif ($cmd === 'clear_search') {
          
            $this->session->unset_userdata('cari');
            redirect('pesan/keluar', 'reload');
            
        } elseif ($cmd === 'read') {
          
            header("content-type: application/json");
            $rs = $this->pesan_m->get('keluar', 'read',$param)->row();
            echo '{"id":"' . $rs->id . '",
                   "pengirim":"' . $rs->pengirim . '",
                   "penerima":"' . $rs->penerima . '",
                   "status":"' . $rs->status . '",
				   "subyek":"' . $rs->subyek . '",
                   "isi":"' . $rs->isi . '"}';
            exit(0);
            
        } elseif ($cmd === 'add') {
          
            $userid = $this->session->userdata('userid');
            $data = array(
                'page_name' => 'pesan/f_pesan_keluar',
                'page_title' => 'Buat Pesan Baru',
                'penerima' => $this->basecrud_m->get_where('tbl_user', array(
                    'id <>' => $userid,
                    'terhapus' => 'N'
                ))
            );
            $this->_generate_page($data);
            
        } elseif ($cmd === 'add_act') {
          
            $date_now = date('Y-m-d H:i:s');
            $in = array(
                'id_pengirim' => $this->input->post('id_pengirim') ,
                'id_penerima' => $this->input->post('id_penerima') ,
                'subyek' => $this->input->post('subyek') ,
                'isi' => $this->input->post('isi') ,
                'tgl_kirim' => $date_now
            );
            $this->basecrud_m->insert('tbl_pesan', $in);
            redirect('pesan/keluar', 'reload');
            
        } elseif ($cmd === 'del') {
          
            $this->basecrud_m->update('tbl_pesan',
                                      $param,
                                      array(
                                            'terhapus_pengirim' => 'Y'
            ));
            
            redirect('pesan/pesan_keluar', 'reload');
            
        } else {

            
            //pagination
            $url = base_url() . 'pesan/keluar/';
            $res = $this->pesan_m->get('keluar','numrows');
            $per_page = 10;
            $config = paginate($url,$res,$per_page,3);
            $this->pagination->initialize($config);

            $this->pesan_m->limit = $per_page;
            if($this->uri->segment(3) == TRUE){
                $this->pesan_m->offset = $this->uri->segment(3);
            }else{
                $this->pesan_m->offset = 0;
            }   

            $this->pesan_m->sort = 'a.tgl_kirim';
            $this->pesan_m->order = 'DESC';
            //end pagination

            $data = array(
                'page_name' => 'pesan/l_pesan_keluar',
                'page_title' => 'Data Pesan Keluar',
                'data' => $this->pesan_m->get('keluar','pagging')
            );
            $this->_generate_page($data);
            
        }
    }
}

