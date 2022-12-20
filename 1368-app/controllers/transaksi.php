<?php


if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Transaksi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function _generate_page($data)
    {
        $this->load->view('page', $data);
    }

    public function _pembelian_remove_cart()
    {
        $this->session->unset_userdata('biaya_kirim');
        $this->session->unset_userdata('diskon');
        $this->session->unset_userdata('pajak');

        $this->cart->destroy();
    }

    /***************************************************************************/
    public function _get_setting($nama)
    {
        $this->load->model(array('basecrud_m'));
        $r = $this->basecrud_m->get_where('tbl_settings', array('nama' => $nama))->row();

        return $r->value;
    }

    /***************************************************************************/
    public function pembelian($cmd = null, $param = null)
    {
        $this->load->model(array('basecrud_m', 'pembelian_m', 'penjualan_m'));
        $this->load->library('cart');

        if ($cmd === 'cari') {
            $this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');

            if ($this->form_validation->run() == true) {
                $this->session->set_userdata('cari', $this->input->post('cari'));
            }

            redirect('transaksi/pembelian', 'reload');
        } elseif ($cmd === 'clear_search') {
            $this->session->unset_userdata('cari');
            redirect('transaksi/pembelian', 'reload');
        } elseif ($cmd === 'printdoc') {
            $r = $this->basecrud_m->get_where('tbl_pembelian', array('id' => $param));

            if ($r->num_rows() == 0 || $r->row()->status !== 'disetujui') {
                redirect('transaksi/pembelian', 'reload');
            }

            $beli = $r->row();

            $data = array('nama_perusahaan' => $this->_get_setting('perusahaan'),
                          'logo_perusahaan' => $this->_get_setting('logo'),
                          'po_box' => $this->_get_setting('po_box'),
                          'telp' => $this->_get_setting('telp'),
                          'fax' => $this->_get_setting('fax'),
                          'email' => $this->_get_setting('email'),
                          'supplier' => $this->basecrud_m->get_where('tbl_supplier', array('id' => $beli->id_supplier))->row(),
                          'alamat_pengiriman' => $beli->alamat_pengiriman,
                          'kode_pembelian' => $beli->kode_pembelian,
                          'tgl_order' => $beli->tgl_pembelian,
                          'term_pembayaran' => $beli->term_pembayaran,
                          'term_pengiriman' => $beli->term_pengiriman,
                          'catatan' => $beli->catatan_pembelian,
                          'pembelian_details' => $this->pembelian_m->get_details_trans($param),
                          'besar_trans' => $beli->besar_trans,
                          'biaya_kirim' => $beli->biaya_kirim,
                          'diskon' => $beli->diskon,
                          'pajak' => $beli->pajak,
                          );

            $this->load->view('transaksi/p_pembelian', $data);
        } elseif ($cmd === 'set-status') {
            $status = $_POST['status'];

            $this->basecrud_m->update('tbl_pembelian', $param, array('status' => $status,
                                                                   'disetujui_oleh' => $this->session->userdata('userid'),
                                                                   )
                                      );
        } elseif ($cmd === 'get-kode-penjualan-terkait') {
            $search = $_GET['search'];

            $rs = $this->penjualan_m->get_kode_penjualan($search, 'disetujui');

            $row = '';
            foreach ($rs->result() as $r) {
                $row .= '{ "value": "'.$r->value.'", "data": "DATA" },';
            }

            $output = '{"suggestions": ['.substr($row, 0, -1).']}';
            echo $output;
        } elseif ($cmd === 'update-nilai-tambahan') {
            $sess = array('biaya_kirim' => $this->input->post('biaya_kirim'),
                            'diskon' => $this->input->post('diskon'),
                            'pajak' => $this->input->post('pajak'),
                        );

            $this->session->set_userdata($sess);
        } elseif ($cmd === 'get-bahan') {

            //TODO
            $id_supplier = $_GET['id_supplier'];
            $bahan_mentah = $this->basecrud_m->get_where('tbl_supplier', array('id' => $id_supplier));

            $option = '';

            if ($bahan_mentah->num_rows() == 0) {
                $option .= "<option value=''>SUPPLIER INI BELUM PUNYA PRODUK</option>";
            } else {
                $arr_bahan_mentah = explode(',', $bahan_mentah->row()->arr_bahan_mentah);
                $this->db->where_in('id', $arr_bahan_mentah);
                $bh = $this->db->get_where('tbl_bahan_mentah');

                $option .= '<option value="">[ Pilih Bahan ]</option>';
                foreach ($bh->result() as $b) {
                    $option .= "<option value='".$b->id."'>".$b->kode_bahan.'</option>';
                }
            }

            echo $option;
            exit(0);
        } elseif ($cmd === 'get-deskripsi-bahan') {
            $id = $_GET['id'];
            if ($id == null) {
                exit(0);
            }
            $b = $this->basecrud_m->get_where('tbl_bahan_mentah', array('id' => $id));
            $c = $this->basecrud_m->get_where('tbl_satuan', array('id' => $b->row()->id_satuan));

            $deskripsi = $b->num_rows() > 0 ? $b->row()->deskripsi : '';
            $satuan = $c->num_rows() > 0 ? $c->row()->nama : '';
            $hrg_terakhir = $b->num_rows() > 0 ? $b->row()->hrg_terakhir : 0;
            header('content-type: application/json');
            echo json_encode(array('deskripsi' => $deskripsi,
                                   'satuan' => $satuan,
                                   'hrg_terakhir' => $hrg_terakhir, )
                             );
            exit(0);
        } elseif ($cmd === 'add') {
            $data = array('page_name' => 'transaksi/f_pembelian',
                          'supplier' => $this->basecrud_m->get('tbl_supplier'),
                          'page_title' => 'Tambah Data Pembelian', );
            $this->_generate_page($data);
        } elseif ($cmd === 'add_detail') {
            $data = array(
                'id' => uniqid(),
                'name' => $this->input->post('id_bahan_mentah'),
                'qty' => $this->input->post('kuantitas'),
                'price' => $this->input->post('harga_per_item'),
            );

            $this->cart->insert($data);
            //lets update latest price for this raw material
            $id_bahan = $this->input->post('id_bahan_mentah');
            $harga = $this->input->post('harga_per_item');
            $this->basecrud_m->update('tbl_bahan_mentah', $id_bahan, array('hrg_terakhir' => $harga));

            $row = '';
            //name,deskripsi,qty,price,subtotal
            foreach ($this->cart->contents() as $item) {
                $r = $this->basecrud_m->get_where('tbl_bahan_mentah', array('id' => $item['name']))->row();

                $row .= '<tr id="row_'.$item['rowid'].'">
							<td>'.$r->kode_bahan.'</td>
                            <td>'.$r->deskripsi.'</td>
							<td>'.$item['qty'].'</td>
							<td>'.formatRupiah($item['price']).'</td>
							<td>'.formatRupiah($item['subtotal']).'</td>
							<td class="ctr">
								<div class="btn-group">
									<button type="button" class="btn btn-danger btn-sm" onclick="del(\''.$item['rowid'].'\')"><i class="fa fa-trash-o "></i>Hapus</button>
								</div>
							</td>
						</tr>';
            }

            header('content-type: application/json');
            echo json_encode(array('row' => $row,
                                   'total' => $this->cart->total(),
                                   )
                             );
        } elseif ($cmd === 'del_detail') {
            $data = array(
                'rowid' => $param,
                'qty' => 0, );

            $this->cart->update($data);

            echo $this->cart->total_items() == 0 ? 0 : $this->cart->total();
        } elseif ($cmd === 'add_act') {
            //simpen

            $this->form_validation->set_rules('kode_pembelian', 'Kode Pembelian', 'xss_clean|required|is_unique[tbl_pembelian.kode_pembelian]');
            $this->form_validation->set_rules('kode_penjualan_terkait', 'Ref.Kode Penjualan', 'xss_clean');
            $this->form_validation->set_rules('tgl_pembelian', 'Tanggal Pembelian', 'xss_clean|required');
            $this->form_validation->set_rules('id_supplier', 'Supplier', 'xss_clean|required');
            $this->form_validation->set_rules('tgl_kirim', 'Tanggal Pengiriman', 'xss_clean|required');
            $this->form_validation->set_rules('alamat_pengiriman', 'Alamat Pengiriman', 'xss_clean|required');
            $this->form_validation->set_rules('term_pembayaran', 'Term Pembayaran', 'xss_clean');
            $this->form_validation->set_rules('term_pengiriman', 'Term Pengiriman', 'xss_clean');
            $this->form_validation->set_rules('biaya_kirim', 'Biaya Kirim', 'xss_clean');
            $this->form_validation->set_rules('diskon', 'Diskon', 'xss_clean');
            $this->form_validation->set_rules('pajak', 'Pajak', 'xss_clean');
            $this->form_validation->set_rules('catatan_pembelian', 'Catatan Pembelian', 'xss_clean');

            if ($this->form_validation->run() == true) {
                $diskon = $this->input->post('diskon');
                $biaya_kirim = $this->input->post('biaya_kirim');
                $pajak = $this->input->post('pajak');

                $harga_awal = $this->cart->total();
                $awal_kirim = $harga_awal + $biaya_kirim;
                $setelah_diskon = $awal_kirim - ($awal_kirim * ($diskon / 100));
                $harga_akhir = $setelah_diskon + ($setelah_diskon * ($pajak / 100));

                $in = array('dibuat_oleh' => $this->session->userdata('userid'),
                            'kode_pembelian' => $this->input->post('kode_pembelian'),
                            'kode_penjualan_terkait' => $this->input->post('kode_penjualan_terkait'),
                            'tgl_pembelian' => $this->input->post('tgl_pembelian'),
                            'id_supplier' => $this->input->post('id_supplier'),
                            'tgl_kirim' => $this->input->post('tgl_kirim'),
                            'alamat_pengiriman' => $this->input->post('alamat_pengiriman'),
                            'term_pembayaran' => $this->input->post('term_pembayaran'),
                            'term_pengiriman' => $this->input->post('term_pengiriman'),
                            'biaya_kirim' => $this->input->post('biaya_kirim'),
                            'diskon' => $this->input->post('diskon'),
                            'pajak' => $this->input->post('pajak'),
                            'catatan_pembelian' => $this->input->post('catatan_pembelian'),
                            'besar_trans' => $harga_akhir,
                            );

                $id_pembelian = $this->pembelian_m->insert_header($in);

                //baru kemudian kita insert details

                foreach ($this->cart->contents() as $item) {
                    $data = array(
                                    'id_pembelian' => $id_pembelian,
                                    'id_bahan_mentah' => $item['name'],
                                    'kuantitas' => $item['qty'],
                                    'harga_per_item' => $item['price'],
                                );

                    $this->basecrud_m->insert('tbl_pembelian_details', $data);
                }

                $this->_pembelian_remove_cart();

                redirect('transaksi/pembelian', 'reload');
            } else {
                $data = array('msg' => validation_errors(),
                              'page_name' => 'transaksi/f_pembelian',
                              'supplier' => $this->basecrud_m->get('tbl_supplier'),
                              'page_title' => 'Tambah Data Pembelian',
                              );
                $this->_generate_page($data);
            }
        } elseif ($cmd === 'edt') {
            $this->_pembelian_remove_cart();

            $det = $this->basecrud_m->get_where('tbl_pembelian_details', array('id_pembelian' => $param));
            $head = $this->basecrud_m->get_where('tbl_pembelian', array('id' => $param))->row();

            $data = array('page_name' => 'transaksi/f_pembelian',
                          'page_title' => 'Edit Data Pembelian',
                          'data' => $head,
                          'supplier' => $this->basecrud_m->get('tbl_supplier'),
                          );

            $sess = array('biaya_kirim' => $head->biaya_kirim,
                            'diskon' => $head->diskon,
                            'pajak' => $head->pajak,
                        );

            $this->session->set_userdata($sess);

            //insert details to session

            foreach ($det->result() as $d) {
                $dt_det = array(
                    'id' => uniqid(),
                    'name' => $d->id_bahan_mentah,
                    'qty' => $d->kuantitas,
                    'price' => $d->harga_per_item,
                );

                $this->cart->insert($dt_det);
            }

            $this->_generate_page($data);
        } elseif ($cmd === 'edt_act') {

            //update
            $this->form_validation->set_rules('kode_pembelian', 'Kode Pembelian', 'xss_clean|required');
            $this->form_validation->set_rules('kode_penjualan_terkait', 'Ref.Kode Penjualan', 'xss_clean');
            $this->form_validation->set_rules('tgl_pembelian', 'Tanggal Pembelian', 'xss_clean|required');
            $this->form_validation->set_rules('id_supplier', 'Supplier', 'xss_clean|required');
            $this->form_validation->set_rules('tgl_kirim', 'Tanggal Pengiriman', 'xss_clean|required');
            $this->form_validation->set_rules('alamat_pengiriman', 'Alamat Pengiriman', 'xss_clean|required');
            $this->form_validation->set_rules('term_pembayaran', 'Term Pembayaran', 'xss_clean');
            $this->form_validation->set_rules('term_pengiriman', 'Term Pengiriman', 'xss_clean');
            $this->form_validation->set_rules('biaya_kirim', 'Biaya Kirim', 'xss_clean');
            $this->form_validation->set_rules('diskon', 'Diskon', 'xss_clean');
            $this->form_validation->set_rules('pajak', 'Pajak', 'xss_clean');
            $this->form_validation->set_rules('catatan_pembelian', 'Catatan Pembelian', 'xss_clean');

            if ($this->form_validation->run() == true) {
                $diskon = $this->input->post('diskon');
                $biaya_kirim = $this->input->post('biaya_kirim');
                $pajak = $this->input->post('pajak');

                $harga_awal = $this->cart->total();
                $awal_kirim = $harga_awal + $biaya_kirim;
                $setelah_diskon = $awal_kirim - ($awal_kirim * ($diskon / 100));
                $harga_akhir = $setelah_diskon + ($setelah_diskon * ($pajak / 100));

                $in = array('dibuat_oleh' => $this->session->userdata('userid'),
                            'kode_pembelian' => $this->input->post('kode_pembelian'),
                            'kode_penjualan_terkait' => $this->input->post('kode_penjualan_terkait'),
                            'tgl_pembelian' => $this->input->post('tgl_pembelian'),
                            'id_supplier' => $this->input->post('id_supplier'),
                            'tgl_kirim' => $this->input->post('tgl_kirim'),
                            'alamat_pengiriman' => $this->input->post('alamat_pengiriman'),
                            'term_pembayaran' => $this->input->post('term_pembayaran'),
                            'term_pengiriman' => $this->input->post('term_pengiriman'),
                            'biaya_kirim' => $this->input->post('biaya_kirim'),
                            'diskon' => $this->input->post('diskon'),
                            'pajak' => $this->input->post('pajak'),
                            'catatan_pembelian' => $this->input->post('catatan_pembelian'),
                            'besar_trans' => $harga_akhir,
                            );

                $this->basecrud_m->update('tbl_pembelian', $param, $in);

                //delete details
                $this->basecrud_m->delete('tbl_pembelian_details', array('id_pembelian' => $param));
                //baru kemudian kita insert details

                foreach ($this->cart->contents() as $item) {
                    //$data = array();

                    $data = array(
                                    'id_pembelian' => $param,
                                    'id_bahan_mentah' => $item['name'],
                                    'kuantitas' => $item['qty'],
                                    'harga_per_item' => $item['price'],
                                );

                    $this->basecrud_m->insert('tbl_pembelian_details', $data);
                }

                $this->_pembelian_remove_cart();
                //$this->_del_header_so();

                redirect('transaksi/pembelian', 'reload');
            } else {
                $data = array('msg' => validation_errors(),
                                'page_name' => 'transaksi/f_pembelian',
                                'page_title' => 'Edit Data Pembelian',
                                'data' => $this->basecrud_m->get_where('tbl_pembelian', array('id' => $param))->row(),
                                'supplier' => $this->basecrud_m->get('tbl_supplier'),
                                );
                $this->_generate_page($data);
            }
        } elseif ($cmd === 'del') {
            $this->basecrud_m->update('tbl_pembelian', $param, array('terhapus' => 'Y'));
            //$det = $this->basecrud_m->get_where('tbl_pembelian_details',array('id_pembelian'=>$param));
            //
            //foreach($det->result() as $d){
            //	$id = $d->id;
            //	$this->basecrud_m->update('tbl_pembelian_details',$id,array('terhapus'=>'Y'));
            //}

            redirect('transaksi/pembelian', 'reload');
        } else {
            //remove all cart data first
            $this->_pembelian_remove_cart();

            //pagination
            $url = base_url().'transaksi/pembelian/';
            $res = $this->pembelian_m->get('numrows');
            $per_page = 10;
            $config = paginate($url, $res, $per_page, 3);
            $this->pagination->initialize($config);

            $this->pembelian_m->limit = $per_page;
            if ($this->uri->segment(3) == true) {
                $this->pembelian_m->offset = $this->uri->segment(3);
            } else {
                $this->pembelian_m->offset = 0;
            }

            $this->pembelian_m->sort = 'a.tgl_pembelian';
            $this->pembelian_m->order = 'DESC';
            //end pagination

            $data = array('page_name' => 'transaksi/l_pembelian',
                          'page_title' => 'Data Pembelian',
                          'data' => $this->pembelian_m->get('pagging'), );
            $this->_generate_page($data);
        }
    }

    /*************************************************************************************/
    public function penjualan($cmd = null, $param = null)
    {
        $this->load->model(array('basecrud_m', 'penjualan_m'));
        $this->load->library('cart');

        if ($cmd === 'cari') {
            $this->form_validation->set_rules('cari', 'Text Cari', 'xss_clean|required');

            if ($this->form_validation->run() == true) {
                $this->session->set_userdata('cari', $this->input->post('cari'));
            }

            redirect('transaksi/penjualan', 'reload');
        } elseif ($cmd === 'clear_search') {
            $this->session->unset_userdata('cari');
            redirect('transaksi/penjualan', 'reload');
        } elseif ($cmd === 'set-status') {
            $status = $_POST['status'];

            $this->basecrud_m->update('tbl_penjualan', $param, array('status' => $status,
                                                                   'disetujui_oleh' => $this->session->userdata('userid'),
                                                                   )
                                      );
        } elseif ($cmd === 'get-konsumen-details') {
            $id_konsumen = $_GET['id'];
            $b = $this->basecrud_m->get_where('tbl_konsumen', array('id' => $id_konsumen));

            $alamat_pengiriman = $b->num_rows() > 0 ? $b->row()->gudang : '';
            header('content-type: application/json');
            echo json_encode(
                                array('alamat_pengiriman' => $alamat_pengiriman)
                             );
        } elseif ($cmd === 'get-latest-price') {
            $id_produk = $_GET['id'];
            $b = $this->basecrud_m->get_where('tbl_produk', array('id' => $id_produk));

            $hrg_terakhir = $b->num_rows() > 0 ? $b->row()->hrg_terakhir : 0;
            header('content-type: application/json');
            echo json_encode(
                                array('harga' => $hrg_terakhir)
                             );
        } elseif ($cmd === 'add') {
            $data = array('page_name' => 'transaksi/f_penjualan',
                          'buyer' => $this->basecrud_m->get('tbl_konsumen'),
                          'produk' => $this->basecrud_m->get_where('tbl_produk', array('terhapus' => 'N')),
                          'page_title' => 'Tambah Data Penjualan', );
            $this->_generate_page($data);
        } elseif ($cmd === 'add_detail') {
            $data = array(
                'id' => uniqid(),
                'name' => $this->input->post('id_produk'),
                'qty' => $this->input->post('kuantitas'),
                'price' => $this->input->post('harga_per_item'),
                'keadaan' => $this->input->post('keadaan'),
            );
            //var_dump($data);
            $this->cart->insert($data);

            //lets update latest price for this product
            $id_produk = $this->input->post('id_produk');
            $harga = $this->input->post('harga_per_item');
            $this->basecrud_m->update('tbl_produk', $id_produk, array('hrg_terakhir' => $harga));

            $row = '';

            if ($this->cart->total_items() == 0) {
                $row .= '<tr>
							<td colspan="5" style="text-align: center; font-weight: bold">
							  <div class="alert alert-danger" style="margin-bottom: 0px">Data Item Belum Ada</div>
							</td>
						</tr>';
            } else {
                foreach ($this->cart->contents() as $item) {
                    $r = $this->basecrud_m->get_where('tbl_produk', array('id' => $item['name']))->row();

                    $row .= '<tr id="row_'.$item['rowid'].'">
								<td>'.$r->kode_produk.'</td>
								<td>'.$item['keadaan'].'</td>
								<td>'.$item['qty'].'</td>
								<td>'.formatRupiah($item['price']).'</td>
								<td>'.formatRupiah($item['subtotal']).'</td>
								<td class="ctr">
									<div class="btn-group">
										<button type="button" class="btn btn-danger btn-sm" onclick="del(\''.$item['rowid'].'\')"><i class="fa fa-trash-o "></i>Hapus</button>
									</div>
								</td>
							</tr>';
                }
                $row .= '<tr>
							<td style="text-align: right" colspan="4">TOTAL</td>
							<td>'.formatRupiah($this->cart->total()).'</td>
						</tr>';
            }

            echo $row;
        } elseif ($cmd === 'del_detail') {
            $data = array(
                'rowid' => $param,
                'qty' => 0, );

            $this->cart->update($data);

            echo $this->cart->total_items() == 0 ? 0 : formatRupiah($this->cart->total());
        } elseif ($cmd === 'add_act') {
            //simpen

            $this->form_validation->set_rules('kode_penjualan', 'Kode Penjualan', 'xss_clean|required|is_unique[tbl_penjualan.kode_penjualan]');
            $this->form_validation->set_rules('tgl_penjualan', 'Tanggal Penjualan', 'xss_clean|required');
            $this->form_validation->set_rules('id_konsumen', 'Buyer', 'xss_clean|required');
            $this->form_validation->set_rules('tgl_kirim_diminta', 'Tanggal Pengiriman (Diminta)', 'xss_clean|required');
            $this->form_validation->set_rules('alamat_pengiriman', 'Alamat Pengiriman', 'xss_clean|required');
            $this->form_validation->set_rules('catatan_penjualan', 'Catatan Penjualan', 'xss_clean');

//            $this->form_validation->set_rules('sp_nama', 'CP Nama', 'xss_clean');
//			$this->form_validation->set_rules('sp_telp', 'CP Telp', 'xss_clean');
//			$this->form_validation->set_rules('sp_email', 'CP Email', 'xss_clean');
//			$this->form_validation->set_rules('sp_jabatan', 'CP Jabatan', 'xss_clean');
//			$this->form_validation->set_rules('keterangan', 'Keterangan', 'xss_clean');


            if ($this->form_validation->run() == true) {
                $in = array('dibuat_oleh' => $this->session->userdata('userid'),
                            'kode_penjualan' => $this->input->post('kode_penjualan'),
                            'tgl_penjualan' => $this->input->post('tgl_penjualan'),
                            'id_konsumen' => $this->input->post('id_konsumen'),
                            'tgl_kirim_diminta' => $this->input->post('tgl_kirim_diminta'),
                            'alamat_pengiriman' => $this->input->post('alamat_pengiriman'),
                            'catatan_penjualan' => $this->input->post('catatan_penjualan'),
//                            'sp_nama'	=> $this->input->post('sp_nama'),
//							'sp_telp'	=> $this->input->post('sp_telp'),
//							'sp_email'	=> $this->input->post('sp_email'),
//							'sp_jabatan'	=> $this->input->post('sp_jabatan'),
//							'keterangan'	=> $this->input->post('keterangan'),
                            'besar_trans' => $this->cart->total(),
                            );

                $id_penjualan = $this->penjualan_m->insert_header($in);

                //baru kemudian kita insert details

                foreach ($this->cart->contents() as $item) {
                    //$data = array();
                    $data = array(
                                    'id_penjualan' => $id_penjualan,
                                    'id_produk' => $item['name'],
                                    'keadaan' => $item['keadaan'],
                                    'kuantitas' => $item['qty'],
                                    'harga_per_item' => $item['price'],
                                );

                    $this->basecrud_m->insert('tbl_penjualan_details', $data);
                }

                $this->cart->destroy();

                redirect('transaksi/penjualan', 'reload');
            } else {
                $data = array('msg' => validation_errors(),
                              'page_name' => 'transaksi/f_penjualan',
                              'page_title' => 'Tambah Data Penjualan',
                              );
                $this->_generate_page($data);
            }
        } elseif ($cmd === 'edt') {

            //hapus dulu jika ada
            $this->cart->destroy();

            $det = $this->basecrud_m->get_where('tbl_penjualan_details', array('id_penjualan' => $param));
            $data = array('page_name' => 'transaksi/f_penjualan',
                          'page_title' => 'Edit Data Penjualan',
                          'data' => $this->basecrud_m->get_where('tbl_penjualan', array('id' => $param))->row(),
                          'data_details' => $det ,//untuk nampilin di view,
                          'buyer' => $this->basecrud_m->get('tbl_konsumen'),
                          'produk' => $this->basecrud_m->get_where('tbl_produk', array('terhapus' => 'N')),
                          );

            //insert details to session

            foreach ($det->result() as $d) {
                $dt_det = array(
                    'id' => uniqid(),
                    'name' => $d->id_produk,
                    'keadaan' => $d->keadaan,
                    'qty' => $d->kuantitas,
                    'price' => $d->harga_per_item,
                );

                $this->cart->insert($dt_det);
            }

            $this->_generate_page($data);
        } elseif ($cmd === 'edt_act') {

            //update
            $this->form_validation->set_rules('kode_penjualan', 'Kode Penjualan', 'xss_clean|required');
            $this->form_validation->set_rules('tgl_penjualan', 'Tanggal Penjualan', 'xss_clean|required');
            $this->form_validation->set_rules('id_konsumen', 'Buyer', 'xss_clean|required');
            $this->form_validation->set_rules('tgl_kirim_diminta', 'Tanggal Pengiriman (Diminta)', 'xss_clean|required');
            $this->form_validation->set_rules('alamat_pengiriman', 'Alamat Pengiriman', 'xss_clean|required');
            $this->form_validation->set_rules('catatan_penjualan', 'Catatan Penjualan', 'xss_clean');

//            $this->form_validation->set_rules('sp_nama', 'CP Nama', 'xss_clean');
//			$this->form_validation->set_rules('sp_telp', 'CP Telp', 'xss_clean');
//			$this->form_validation->set_rules('sp_email', 'CP Email', 'xss_clean');
//			$this->form_validation->set_rules('sp_jabatan', 'CP Jabatan', 'xss_clean');
//			$this->form_validation->set_rules('keterangan', 'Keterangan', 'xss_clean');


            if ($this->form_validation->run() == true) {
                $in = array('dibuat_oleh' => $this->session->userdata('userid'),
                            'kode_penjualan' => $this->input->post('kode_penjualan'),
                            'tgl_penjualan' => $this->input->post('tgl_penjualan'),
                            'id_konsumen' => $this->input->post('id_konsumen'),
                            'tgl_kirim_diminta' => $this->input->post('tgl_kirim_diminta'),
                            'alamat_pengiriman' => $this->input->post('alamat_pengiriman'),
                            'catatan_penjualan' => $this->input->post('catatan_penjualan'),

//                            'sp_nama'			=> $this->input->post('sp_nama'),
//							'sp_telp'			=> $this->input->post('sp_telp'),
//							'sp_email'			=> $this->input->post('sp_email'),
//							'sp_jabatan'		=> $this->input->post('sp_jabatan'),
//							'keterangan'		=> $this->input->post('keterangan'),

                            'besar_trans' => $this->cart->total(),
                            );

                $this->basecrud_m->update('tbl_penjualan', $param, $in);

                //delete details
                $this->basecrud_m->delete('tbl_penjualan_details', array('id_penjualan' => $param));
                //baru kemudian kita insert details

                foreach ($this->cart->contents() as $item) {
                    //$data = array();
                    $data = array(
                                    'id_penjualan' => $param,
                                    'id_produk' => $item['name'],
                                    'keadaan' => $item['keadaan'],
                                    'kuantitas' => $item['qty'],
                                    'harga_per_item' => $item['price'],
                                );

                    $this->basecrud_m->insert('tbl_penjualan_details', $data);
                }

                $this->cart->destroy();
                //$this->_del_header_so();

                redirect('transaksi/penjualan', 'reload');
            } else {
                $det = $this->basecrud_m->get_where('tbl_penjualan_details', array('id_penjualan' => $param));
                $data = array('msg' => validation_errors(),
                                'page_name' => 'transaksi/f_penjualan',
                                'page_title' => 'Edit Data Penjualan',
                                'data' => $this->basecrud_m->get_where('tbl_penjualan', array('id' => $param))->row(),
                                'data_details' => $det ,//untuk nampilin di view,
                                'buyer' => $this->basecrud_m->get('tbl_konsumen'),
                                'produk' => $this->basecrud_m->get_where('tbl_produk', array('terhapus' => 'N')),
                                );
                $this->_generate_page($data);
            }
        } elseif ($cmd === 'del') {
            $this->basecrud_m->update('tbl_penjualan', $param, array('terhapus' => 'Y'));
            //$det = $this->basecrud_m->get_where('tbl_penjualan_details',array('id_penjualan'=>$param));
            //
            //foreach($det->result() as $d){
            //	$id = $d->id;
            //	$this->basecrud_m->update('tbl_penjualan_details',$id,array('terhapus'=>'Y'));
            //}

            redirect('transaksi/penjualan', 'reload');
        } else {
            //remove all cart data first
            $this->cart->destroy();

            //pagination
            $url = base_url().'transaksi/penjualan/';
            $res = $this->penjualan_m->get('numrows');
            $per_page = 10;
            $config = paginate($url, $res, $per_page, 3);
            $this->pagination->initialize($config);

            $this->penjualan_m->limit = $per_page;
            if ($this->uri->segment(3) == true) {
                $this->penjualan_m->offset = $this->uri->segment(3);
            } else {
                $this->penjualan_m->offset = 0;
            }

            $this->penjualan_m->sort = 'a.tgl_penjualan';
            $this->penjualan_m->order = 'DESC';
            //end pagination

            $data = array('page_name' => 'transaksi/l_penjualan',
                          'page_title' => 'Data Penjualan',
                          'data' => $this->penjualan_m->get('pagging'), );
            $this->_generate_page($data);
        }
    }
}
