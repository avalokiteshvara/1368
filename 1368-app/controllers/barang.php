<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends MY_Controller
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
					  'menu_bawah'  =>  $this->menu_m->menu_bawah(9)
					  );
		$this->_generate_page($data);

	}

	/***********************************************************************************/
	function masuk($cmd = null,$param = null){

		$this->load->model(array('basecrud_m','barang_m','pembelian_m'));
		$this->load->library('cart');

		if($cmd === 'cari'){

			$this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');

			if ($this->form_validation->run() == TRUE) {

				$this->session->set_userdata('cari',$this->input->post('cari'));
			}

			redirect('barang/masuk','reload');

		}elseif($cmd === 'clear_search'){

			$this->session->unset_userdata('cari');
			redirect('barang/masuk','reload');

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

		}elseif($cmd === 'get-details-pembelian'){

			$kode_pembelian = $_GET['kode_pembelian'];
			$with_header = $_GET['with-header'];
			$head = $this->pembelian_m->get_details($kode_pembelian)->row();

			$html = "";

			if($with_header === 'YES'){
				$html = '
				<table width="100%" class="table-form" align="center">
				   <tr>
					  <td style="width: 30%">Supplier</td>
					  <td>'. $head->supplier .'</td>
				   </tr>
				   <tr>
					  <td style="width: 30%">Tgl Pembelian</td>
					  <td>' . $head->tgl_pembelian . '</td>
				   </tr>
				</table>';

				$html .= '
				<table width="100%" class="table table-bordered" align="center" style="margin-top: 30px">
				   <thead>
					  <tr>
						 <th>Bahan</th>
						 <th>Deskripsi</th>
						 <th>Kuantitas</th>
					  </tr>
				   </thead>
				   <tbody>';

				$row = $this->basecrud_m->get_where('tbl_pembelian_details',array('id_pembelian'=>$head->id));

				foreach($row->result() as $r){

					$id_raw = $r->id_bahan_mentah;
					$produk = $this->basecrud_m->get_where('tbl_bahan_mentah',array('id'=>$id_raw))->row();

					$html .= '
					<tr>
						 <td>' . $produk->kode_bahan  .'</td>
						 <td>' . $produk->deskripsi . '</td>
						 <td>' . $r->kuantitas . '</td>
					  </tr>
					'	;
				}

				$html .= '
				   </tbody>
				</table>';

			}else{
				$this->cart->destroy();

				$row = $this->basecrud_m->get_where('tbl_pembelian_details',array('id_pembelian'=>$head->id));

				foreach($row->result() as $d){
					$dt_det = array(
							'id'				=> uniqid(),
							'name'     			=> $d->id_bahan_mentah,
							'qty'    			=> $d->kuantitas,
							'price'  			=> 666
					);

					$this->cart->insert($dt_det);
				}

				foreach ($this->cart->contents() as $item) {

					$id_raw = $item['name'];
					$produk = $this->basecrud_m->get_where('tbl_bahan_mentah',array('id'=>$id_raw))->row();

					$html .= '<tr id="row_' . $item['rowid'] .'">
								<td>' . $produk->kode_bahan . '</td>
								<td>' . $produk->deskripsi . '</td>
								<td>' . $item['qty'] . '</td>
								<td class="ctr">
									<div class="btn-group">
										<button type="button" class="btn btn-danger btn-sm" onclick="del(\''. $item['rowid'] . '\')"><i class="fa fa-trash-o "></i>Hapus</button>
									</div>
								</td>
							</tr>';
				}

			}

			echo $html;

		}elseif($cmd === 'get-kode-pembelian'){

			$search = $_GET['search'];

			$rs = $this->pembelian_m->get_kode_pembelian($search,'disetujui');

			$row = "";
			foreach($rs->result() as $r){
				$row .= '{ "value": "' . $r->value . '", "data": "DATA" },';
			}

			$output = '{"suggestions": [' . substr($row,0,-1) . ']}';
			echo $output;

		}elseif($cmd === 'add'){

			$data = array('page_name'	=> 'barang/f_barangmasuk',
						  'page_title'	=> 'Tambah Data Barang Masuk',
						  'bahan'=> $this->basecrud_m->get_where('tbl_bahan_mentah',array('terhapus'=>'N'))
						  );
			$this->_generate_page($data);

		}elseif($cmd === 'add_detail'){

			$data = array(
				'id'				=> uniqid(),
				'name'     			=> $this->input->post('id_bahan_mentah'),
				'qty'    			=> $this->input->post('kuantitas'),
				'price'  			=> 666
			);

			$this->cart->insert($data);

			$row = "";
			foreach ($this->cart->contents() as $item) {

				$id_raw = $item['name'];
				$produk = $this->basecrud_m->get_where('tbl_bahan_mentah',array('id'=>$id_raw))->row();

				$row .= '<tr id="row_' . $item['rowid'] .'">
							<td>' . $produk->kode_bahan . '</td>
							<td>' . $produk->deskripsi . '</td>
                            <td>' . $item['qty'] . '</td>
							<td class="ctr">
								<div class="btn-group">
									<button type="button" class="btn btn-danger btn-sm" onclick="del(\''. $item['rowid'] . '\')"><i class="fa fa-trash-o "></i>Hapus</button>
								</div>
							</td>
						</tr>';
			}

			echo $row;

		}elseif($cmd === 'del_detail'){

			$data = array(
				'rowid' => $param,
				'qty'   => 0);

			$this->cart->update($data);

			echo $this->cart->total_items();

		}elseif($cmd === 'add_act'){
			//simpen
			$this->form_validation->set_rules('kode_masuk', 'Kode Masuk', 'xss_clean|required');
			$this->form_validation->set_rules('kode_pembelian', 'Kode Pembelian', 'xss_clean');
			$this->form_validation->set_rules('tgl', 'Tanggal Masuk', 'xss_clean|required');
			$this->form_validation->set_rules('pemeriksa', 'Pemeriksa', 'xss_clean');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'xss_clean');

			if ($this->form_validation->run() == TRUE) {

				$in = array('kode_masuk' 		=> $this->input->post('kode_masuk'),
							'kode_pembelian'	=> $this->input->post('kode_pembelian'),
							'id_user' 			=> $this->session->userdata('userid'),
							'tgl'  				=> $this->input->post('tgl'),
							'pemeriksa'  		=> $this->input->post('pemeriksa'),
							'keterangan'		=> $this->input->post('keterangan')
							);

				$id_brg_masuk = $this->barang_m->insert_header('masuk',$in);

				//baru kemudian kita insert details

				foreach ($this->cart->contents() as $item) {

					$data = array(
									'id_brg_masuk'		=> $id_brg_masuk,
                                    'id_bahan_mentah'   => $item['name'],
                                    'kuantitas'    		=> $item['qty']
								);

					$this->basecrud_m->insert('tbl_brg_masuk_details',$data);
				}

				$this->cart->destroy();

				redirect('barang/masuk','reload');

			}else{

				$data = array('msg' => validation_errors(),
							  'page_name' => 'barang/f_barangmasuk',
							  'page_title' => 'Tambah Data Barang Masuk',
							  'bahan'=> $this->basecrud_m->get_where('tbl_bahan_mentah',array('terhapus'=>'N'))
							  );
				$this->_generate_page($data);

			}

		}elseif($cmd === 'edt'){

			$this->cart->destroy();

			$det = $this->basecrud_m->get_where('tbl_brg_masuk_details',array('id_brg_masuk'=>$param));
			$head = $this->basecrud_m->get_where('tbl_brg_masuk',array('id'=>$param))->row();

			$data = array('page_name' 		=> 'barang/f_barangmasuk',
						  'page_title' 		=> 'Edit Data Barang Masuk',
						  'data' 			=> $head,
						  'bahan'			=> $this->basecrud_m->get_where('tbl_bahan_mentah',array('terhapus'=>'N'))
						  );

			//insert details to session

			foreach($det->result() as $d){
				$dt_det = array(
						'id'				=> uniqid(),
						'name'     			=> $d->id_bahan_mentah,
						'qty'    			=> $d->kuantitas,
						'price'  			=> 666
				);

				$this->cart->insert($dt_det);
			}

			$this->_generate_page($data);

		}elseif($cmd === 'edt_act'){

			//update
			$this->form_validation->set_rules('kode_masuk', 'Kode Masuk', 'xss_clean|required');
			$this->form_validation->set_rules('kode_pembelian', 'Kode Pembelian', 'xss_clean');
			$this->form_validation->set_rules('tgl', 'Tanggal Masuk', 'xss_clean|required');
			$this->form_validation->set_rules('pemeriksa', 'Pemeriksa', 'xss_clean');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'xss_clean');

			if ($this->form_validation->run() == TRUE) {

				$in = array('kode_masuk' 		=> $this->input->post('kode_masuk'),
							'kode_pembelian'	=> $this->input->post('kode_pembelian'),
							'id_user' 			=> $this->session->userdata('userid'),
							'tgl'  				=> $this->input->post('tgl'),
							'pemeriksa'  		=> $this->input->post('pemeriksa'),
							'keterangan'		=> $this->input->post('keterangan')
					  );

				$this->basecrud_m->update('tbl_brg_masuk',$param,$in);

				//delete details
				$this->basecrud_m->delete('tbl_brg_masuk_details',array('id_brg_masuk'=>$param));
				//baru kemudian kita insert details

				foreach ($this->cart->contents() as $item) {
					//$data = array();

					$data = array(
									'id_brg_masuk'		=> $param,
                                    'id_bahan_mentah'	=> $item['name'],
                                    'kuantitas'    		=> $item['qty']
								);

					$this->basecrud_m->insert('tbl_brg_masuk_details',$data);
				}

				$this->cart->destroy();
				//$this->_del_header_so();

				redirect('barang/masuk','reload');

			}else{

				$data = array(	'msg' => validation_errors(),
								'page_name' 		=> 'barang/f_barangmasuk',
								'page_title' 		=> 'Edit Data Barang Masuk',
								'data' 	=> $this->basecrud_m->get_where('tbl_brg_masuk',array('id'=>$param))->row(),
								'bahan'=> $this->basecrud_m->get_where('tbl_bahan_mentah',array('terhapus'=>'N'))
							);
				$this->_generate_page($data);
			}

		}elseif($cmd === 'del'){

			$this->basecrud_m->update('tbl_brg_masuk',$param,array('terhapus'=>'Y'));
			//$det = $this->basecrud_m->get_where('tbl_brg_masuk_details',array('id_brg_masuk'=>$param));
			//
			//foreach($det->result() as $d){
			//	$id = $d->id;
			//	$this->basecrud_m->update('tbl_brg_masuk_details',$id,array('terhapus'=>'Y'));
			//}

			redirect('barang/masuk','reload');

		}else{

			$this->cart->destroy();

			//pagination
			$url = base_url() . 'barang/masuk/';
			$res = $this->barang_m->get('masuk','numrows');
			$per_page = 1;
			$config = paginate($url,$res,$per_page,3);
			$this->pagination->initialize($config);

			$this->barang_m->limit = $per_page;
			if($this->uri->segment(3) == TRUE){
            	$this->barang_m->offset = $this->uri->segment(3);
	        }else{
	            $this->barang_m->offset = 0;
	        }

			$this->barang_m->sort = 'tgl';
        	$this->barang_m->order = 'DESC';
        	//end pagination

			//get list
			$data = array('page_name'	=> 'barang/l_barangmasuk',
						  'page_title'	=> 'Data Barang Masuk',
					      'data'		=>	$this->barang_m->get('masuk','pagging'));
			$this->_generate_page($data);
		}

	}

	/*******************************************************************************/
	//pengiriman produk
	function keluar($cmd = null,$param = null){

		$this->load->model(array('basecrud_m','barang_m','penjualan_m'));
		$this->load->library('cart');

		if($cmd === 'cari'){
		  
			$this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');

			if ($this->form_validation->run() == TRUE) {

				$this->session->set_userdata('cari',$this->input->post('cari'));
			}

			redirect('barang/keluar','reload');

		}elseif($cmd === 'clear_search'){

			$this->session->unset_userdata('cari');
			redirect('barang/keluar','reload');

		}elseif($cmd === 'get-produk-details'){

			$id = $_GET['id'];
            $b = $this->basecrud_m->get_where('tbl_produk',array('id'=>$id));

            $deskripsi = $b->num_rows() > 0 ? $b->row()->deskripsi : '';
            header("content-type: application/json");
			echo json_encode(array('deskripsi'	=>	$deskripsi));
			exit(0);

		}elseif($cmd === 'get-details-penjualan'){

			$kode_penjualan = $_GET['kode_penjualan'];
			$with_header = $_GET['with-header'];
			$head = $this->penjualan_m->get_details($kode_penjualan)->row();

			$html = "";

			if($with_header === 'YES'){
				$html = '
				<table width="100%" class="table-form" align="center">
				   <tr>
					  <td style="width: 30%">Pembeli</td>
					  <td>'. $head->konsumen .'</td>
				   </tr>
				   <tr>
					  <td style="width: 30%">Tgl Penjualan</td>
					  <td>' . $head->tgl_penjualan . '</td>
				   </tr>
				</table>';

				$html .= '
				<table width="100%" class="table table-bordered" align="center" style="margin-top: 30px">
				   <thead>
					  <tr>
						 <th>Produk</th>
						 <th>Deskripsi</th>
						 <th>Keadaan</th>
						 <th>Kuantitas</th>
					  </tr>
				   </thead>
				   <tbody>';

				$row = $this->basecrud_m->get_where('tbl_penjualan_details',array('id_penjualan'=>$head->id));

				foreach($row->result() as $r){

					$id_raw = $r->id_produk;
					$produk = $this->basecrud_m->get_where('tbl_produk',array('id'=>$id_raw))->row();

					$html .= '
					<tr>
						 <td>' . $produk->kode_produk  .'</td>
						 <td>' . $produk->deskripsi . '</td>
						 <td>' . ucfirst($r->keadaan) . '</td>
						 <td>' . $r->kuantitas . '</td>
					  </tr>
					'	;
				}

				$html .= '
				   </tbody>
				</table>';

			}else{
				$this->cart->destroy();

				$row = $this->basecrud_m->get_where('tbl_penjualan_details',array('id_penjualan'=>$head->id));

				foreach($row->result() as $d){
					$dt_det = array(
							'id'				=> uniqid(),
							'name'     			=> $d->id_produk,
							'keadaan'  			=> $d->keadaan,
							'qty'    			=> $d->kuantitas,
							'price'  			=> 666
					);

					$this->cart->insert($dt_det);
				}

				foreach ($this->cart->contents() as $item) {

					$id_raw = $item['name'];
					$produk = $this->basecrud_m->get_where('tbl_produk',array('id'=>$id_raw))->row();

					$html .= '<tr id="row_' . $item['rowid'] .'">
								<td>' . $produk->kode_produk . '</td>
								<td>' . $produk->deskripsi . '</td>
								<td>' . $item['keadaan'] . '</td>
								<td>' . $item['qty'] . '</td>
								<td class="ctr">
									<div class="btn-group">
										<button type="button" class="btn btn-danger btn-sm" onclick="del(\''. $item['rowid'] . '\')"><i class="fa fa-trash-o "></i>Hapus</button>
									</div>
								</td>
							</tr>';
				}

			}

			echo $html;

		}elseif($cmd === 'get-kode-penjualan'){

			$search = $_GET['search'];

			$rs = $this->penjualan_m->get_kode_penjualan($search,'disetujui');

			$row = "";
			foreach($rs->result() as $r){
				$row .= '{ "value": "' . $r->value . '", "data": "AE" },';
			}
			$output = '{"suggestions": [' . substr($row,0,-1) . ']}';
			echo $output;

		}elseif($cmd === 'add'){

			$data = array('page_name'	=> 'barang/f_barangkeluar',
						  'page_title'	=> 'Tambah Data Barang Keluar',
						  'produk'=> $this->basecrud_m->get_where('tbl_produk',array('terhapus'=>'N'))
						  );
			$this->_generate_page($data);

		}elseif($cmd === 'add_detail'){

			$data = array(
				'id'				=> uniqid(),
				'name'     			=> $this->input->post('id_produk'),
				'keadaan'    			=> $this->input->post('keadaan'),
				'qty'    			=> $this->input->post('kuantitas'),
				'price'  			=> 666
			);

			$this->cart->insert($data);

			$row = "";
			foreach ($this->cart->contents() as $item) {

				$id_raw = $item['name'];
				$produk = $this->basecrud_m->get_where('tbl_produk',array('id'=>$id_raw))->row();

				$row .= '<tr id="row_' . $item['rowid'] .'">
							<td>' . $produk->kode_produk . '</td>
							<td>' . $produk->deskripsi . '</td>
							<td>' . $item['keadaan'] . '</td>
                            <td>' . $item['qty'] . '</td>
							<td class="ctr">
								<div class="btn-group">
									<button type="button" class="btn btn-danger btn-sm" onclick="del(\''. $item['rowid'] . '\')"><i class="fa fa-trash-o "></i>Hapus</button>
								</div>
							</td>
						</tr>';
			}

			echo $row;

		}elseif($cmd === 'del_detail'){

			$data = array(
				'rowid' => $param,
				'qty'   => 0);

			$this->cart->update($data);

			echo $this->cart->total_items();

		}elseif($cmd === 'add_act'){
			//simpen
			$this->form_validation->set_rules('kode_keluar', 'Kode Keluar', 'xss_clean|required');
			$this->form_validation->set_rules('kode_penjualan', 'Kode Penjualan', 'xss_clean');
			$this->form_validation->set_rules('tgl', 'Tanggal Keluar', 'xss_clean|required');
			$this->form_validation->set_rules('pemeriksa', 'Pemeriksa', 'xss_clean');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'xss_clean');

			if ($this->form_validation->run() == TRUE) {

				$in = array('kode_keluar'		=> $this->input->post('kode_keluar'),
							'kode_penjualan'	=> $this->input->post('kode_penjualan'),
							'id_user' 			=> $this->session->userdata('userid'),
							'tgl'  				=> $this->input->post('tgl'),
							'pemeriksa'  		=> $this->input->post('pemeriksa'),
							'keterangan'		=> $this->input->post('keterangan')
							);

				$id_brg_keluar = $this->barang_m->insert_header('keluar',$in);

				//baru kemudian kita insert details

				foreach ($this->cart->contents() as $item) {

					$data = array(
									'id_brg_keluar'		=> $id_brg_keluar,
                                    'id_produk'   		=> $item['name'],
									'keadaan'    		=> $item['keadaan'],
                                    'kuantitas'    		=> $item['qty']
								);

					$this->basecrud_m->insert('tbl_brg_keluar_details',$data);
				}

				$this->cart->destroy();

				redirect('barang/keluar','reload');

			}else{

				$data = array('msg' => validation_errors(),
							  'page_name' => 'barang/f_barangkeluar',
							  'page_title' => 'Tambah Data Barang Keluar',
							  'produk'=> $this->basecrud_m->get_where('tbl_produk',array('terhapus'=>'N'))
							  );
				$this->_generate_page($data);

			}

		}elseif($cmd === 'edt'){

			$this->cart->destroy();

			$det = $this->basecrud_m->get_where('tbl_brg_keluar_details',array('id_brg_keluar'=>$param));
			$head = $this->basecrud_m->get_where('tbl_brg_keluar',array('id'=>$param))->row();

			$data = array('page_name' 		=> 'barang/f_barangkeluar',
						  'page_title' 		=> 'Edit Data Barang Keluar',
						  'data' 			=> $head,
						  'produk'			=> $this->basecrud_m->get_where('tbl_produk',array('terhapus'=>'N'))
						  );

			//insert details to session

			foreach($det->result() as $d){
				$dt_det = array(
						'id'				=> uniqid(),
						'name'     			=> $d->id_produk,
						'keadaan'  			=> $d->keadaan,
						'qty'    			=> $d->kuantitas,
						'price'  			=> 666
				);

				$this->cart->insert($dt_det);
			}

			$this->_generate_page($data);

		}elseif($cmd === 'edt_act'){

			//update
			$this->form_validation->set_rules('kode_keluar', 'Kode Keluar', 'xss_clean|required');
			$this->form_validation->set_rules('kode_penjualan', 'Kode Penjualan', 'xss_clean');
			$this->form_validation->set_rules('tgl', 'Tanggal Masuk', 'xss_clean|required');
			$this->form_validation->set_rules('pemeriksa', 'Pemeriksa', 'xss_clean');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'xss_clean');

			if ($this->form_validation->run() == TRUE) {

				$in = array('kode_keluar'		=> $this->input->post('kode_keluar'),
							'kode_penjualan'	=> $this->input->post('kode_penjualan'),
							'id_user' 			=> $this->session->userdata('userid'),
							'tgl'  				=> $this->input->post('tgl'),
							'pemeriksa'  		=> $this->input->post('pemeriksa'),
							'keterangan'		=> $this->input->post('keterangan')
					  );

				$this->basecrud_m->update('tbl_brg_keluar',$param,$in);

				//delete details
				$this->basecrud_m->delete('tbl_brg_keluar_details',array('id_brg_keluar'=>$param));
				//baru kemudian kita insert details

				foreach ($this->cart->contents() as $item) {
					//$data = array();

					$data = array(
									'id_brg_keluar'		=> $param,
                                    'id_produk'			=> $item['name'],
									'keadaan'			=> $item['keadaan'],
                                    'kuantitas'    		=> $item['qty']
								);

					$this->basecrud_m->insert('tbl_brg_keluar_details',$data);
				}

				$this->cart->destroy();
				//$this->_del_header_so();

				redirect('barang/keluar','reload');

			}else{

				$data = array(	'msg' => validation_errors(),
								'page_name' 		=> 'barang/f_barangkeluar',
								'page_title' 		=> 'Edit Data Barang Keluar',
								'data' 	=> $this->basecrud_m->get_where('tbl_brg_keluar',array('id'=>$param))->row(),
								'produk'=> $this->basecrud_m->get_where('tbl_produk',array('terhapus'=>'N'))
							);
				$this->_generate_page($data);
			}

		}elseif($cmd === 'del'){

			$this->basecrud_m->update('tbl_brg_keluar',$param,array('terhapus'=>'Y'));
			//$det = $this->basecrud_m->get_where('tbl_brg_keluar_details',array('id_brg_keluar'=>$param));
			//
			//foreach($det->result() as $d){
			//	$id = $d->id;
			//	$this->basecrud_m->update('tbl_brg_keluar_details',$id,array('terhapus'=>'Y'));
			//}

			redirect('barang/keluar','reload');

		}else{
			$this->cart->destroy();

			//pagination
			$url = base_url() . 'barang/keluar/';
			$res = $this->barang_m->get('keluar','numrows');
			$per_page = 1;
			$config = paginate($url,$res,$per_page,3);
			$this->pagination->initialize($config);

			$this->barang_m->limit = $per_page;
			if($this->uri->segment(3) == TRUE){
            	$this->barang_m->offset = $this->uri->segment(3);
	        }else{
	            $this->barang_m->offset = 0;
	        }

			$this->barang_m->sort = 'tgl';
        	$this->barang_m->order = 'DESC';
        	//end pagination
			//get list
			$data = array('page_name'	=> 'barang/l_barangkeluar',
						  'page_title'	=> 'Data Barang Keluar',
					      'data'		=>	$this->barang_m->get('keluar','pagging'));
			$this->_generate_page($data);
		}
	}

	/******************************************************************************/
	function stok_opname($cmd = null,$param = null){

		$this->load->model(array('basecrud_m','stok_m'));

		$data = array();

		if($cmd === 'cari'){

			$this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');

			if ($this->form_validation->run() == TRUE) {

				$this->session->set_userdata('cari',$this->input->post('cari'));
			}

			redirect('barang/stok_opname','reload');

		}elseif($cmd === 'clear_search'){

			$this->session->unset_userdata('cari');
			redirect('barang/stok_opname','reload');

		}elseif($cmd === 'add'){

			$data['page_name'] = 'barang/f_stok_opname';
			$data['page_title'] = 'Tambah Data Stok Opname';
			$data['bahan_mentah'] = $this->basecrud_m->get_where('tbl_bahan_mentah',array('terhapus'=>'N'));

		}elseif($cmd === 'add_act'){

			$this->form_validation->set_rules('id_bahan_mentah', 'ID Bahan Mentah', 'xss_clean|required');
			$this->form_validation->set_rules('stok_lama', 'Stok Lama', 'xss_clean|required');
			$this->form_validation->set_rules('stok_baru', 'Stok Baru', 'xss_clean|required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'xss_clean|required');

			if ($this->form_validation->run() == TRUE) {

				$in_opname = array( 'id_user'	=>	$this->session->userdata('userid'),
									'id_bahan_mentah' => $this->input->post('id_bahan_mentah'),
									'stok_lama' => $this->input->post('stok_lama'),
									'stok_baru' => $this->input->post('stok_baru'),
									'keterangan' => $this->input->post('keterangan')
							);


				$this->basecrud_m->insert('tbl_stok_opname',$in_opname);

				$id_bahan_mentah = $this->input->post('id_bahan_mentah');
				$stok_baru = $this->input->post('stok_baru');

				//$this->db->update('tbl_stok',$in_stok,'id_bahan_mentah = ' . $id_bahan_mentah );
				/*
				INSERT IGNORE tbl_stok(id_bahan_mentah,stok) VALUES(v_id_bahan_mentah,-(v_kuantitas * in_kuantitas))
				ON DUPLICATE KEY UPDATE stok = stok - (v_kuantitas * in_kuantitas);
				*/
				$this->db->query("INSERT IGNORE tbl_stok(id_bahan_mentah,stok) VALUES($id_bahan_mentah,$stok_baru)
								  ON DUPLICATE KEY UPDATE stok = $stok_baru");
				redirect(base_url() . 'barang/stok_opname');

			}else{
				$data['page_name'] = 'barang/f_stok_opname';
				$data['page_title'] = 'Edit Data Stok Opname';
				$data['msg'] = validation_errors();
			}

		}elseif($cmd === 'get-last-stok'){

			$id = $_GET['id'];
			$b = $this->basecrud_m->get_where('tbl_stok',array('id_bahan_mentah'=>$id));
            $stok = $b->num_rows() > 0 ? $b->row()->stok : 0;

            header("content-type: application/json");
			echo json_encode(array('stok'	=>	$stok));
			exit(0);


		}else{

			//pagination
			$url = base_url() . 'barang/stok_opname/';
			$res = $this->stok_m->opname('numrows');
			$per_page = 10;
			$config = paginate($url,$res,$per_page,3);
			$this->pagination->initialize($config);

			$this->stok_m->limit = $per_page;
			if($this->uri->segment(3) == TRUE){
            	$this->stok_m->offset = $this->uri->segment(3);
	        }else{
	            $this->stok_m->offset = 0;
	        }

			$this->stok_m->sort = 'a.updated_at';
        	$this->stok_m->order = 'DESC';
        	//end pagination

			$data['page_name'] = 'barang/l_stok_opname';
			$data['page_title'] = 'Data Stok Opname';
			$data['data'] = $this->stok_m->opname('pagging');
		}

		$this->_generate_page($data);

	}

}
