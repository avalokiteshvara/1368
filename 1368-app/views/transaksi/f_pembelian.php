<?php
   
   $mode = $this->uri->segment(3);
   
   if($mode === 'edt' || $mode === 'edt_act'){
      
      $id = $data->id;
      //dibuat_oleh
      $kode_pembelian = $mode === 'edt' ? $data->kode_pembelian : set_value('kode_pembelian');
      $kode_penjualan_terkait = $mode === 'edt' ? $data->kode_penjualan_terkait : set_value('kode_penjualan_terkait');
      //status
      //disetujui_oleh
      $status = $data->status;
      
      $tgl_pembelian = $mode === 'edt' ? $data->tgl_pembelian : set_value('tgl_pembelian');
      //status
      $id_supplier = $mode === 'edt' ? $data->id_supplier : set_value('id_supplier');      
      $tgl_kirim = $mode === 'edt' ? $data->tgl_kirim : set_value('tgl_kirim');
      $alamat_pengiriman = $mode === 'edt' ? $data->alamat_pengiriman : set_value('alamat_pengiriman');
      $term_pembayaran = $mode === 'edt' ? $data->term_pembayaran : set_value('term_pembayaran');
      $term_pengiriman = $mode === 'edt' ? $data->term_pengiriman : set_value('term_pengiriman');
      $biaya_kirim = $mode === 'edt' ? $data->biaya_kirim : set_value('biaya_kirim');
      $diskon = $mode === 'edt' ? $data->diskon : set_value('diskon');      
      $pajak = $mode === 'edt' ? $data->pajak : set_value('pajak  ');
      $catatan_pembelian = $mode === 'edt' ? $data->catatan_pembelian : set_value('catatan_pembelian');
      
      $biaya_kirim = $this->session->userdata('biaya_kirim') != null ? $this->session->userdata('biaya_kirim') : 0;
      $diskon = $this->session->userdata('diskon') != null ? $this->session->userdata('diskon') : 0;
      $pajak = $this->session->userdata('pajak') != null ? $this->session->userdata('pajak') : 0;
      
      //hitung
      $harga_awal = $this->cart->total();
      $awal_kirim = $harga_awal + $biaya_kirim;
      $nilai_diskon = $awal_kirim * ($diskon / 100);
      $setelah_diskon = $awal_kirim - $nilai_diskon;
      $nilai_pajak = $setelah_diskon * ($pajak / 100);
      
      //hitung
      $besar_trans = $setelah_diskon + $nilai_pajak;
      
      $act = 'edt_act/' . $id;
      
   }else{
      
      //dibuat_oleh
      $this->db->select_max('id');
      $max_id = $this->db->get('tbl_pembelian')->row()->id;
      
      $kode_pembelian = $mode === 'add' ? 'PO-' . str_pad(($max_id + 1),6,'0',STR_PAD_LEFT) : set_value('kode_pembelian');
      $kode_penjualan_terkait = $mode === 'add' ? '' : set_value('kode_penjualan_terkait');
      
      $status = 'pending';
      //disetujui_oleh
      $tgl_pembelian = $mode === 'add' ? '' : set_value('tgl_pembelian');
      //status
      $id_supplier = $mode === 'add' ? '' : set_value('id_supplier');      
      $tgl_kirim = $mode === 'add' ? '' : set_value('tgl_kirim');
      $alamat_pengiriman = $mode === 'add' ? '' : set_value('alamat_pengiriman');
      $term_pembayaran = $mode === 'add' ? '' : set_value('term_pembayaran');
      $term_pengiriman = $mode === 'add' ? '' : set_value('term_pengiriman');
      $biaya_kirim = $mode === 'add' ? '' : set_value('biaya_kirim');
      $diskon = $mode === 'add' ? '' : set_value('diskon');      
      $pajak = $mode === 'add' ? '' : set_value('pajak  ');
      $catatan_pembelian = $mode === 'add' ? '' : set_value('catatan_pembelian');
      
      $biaya_kirim = $this->session->userdata('biaya_kirim') != null ? $this->session->userdata('biaya_kirim') : 0;
      $diskon = $this->session->userdata('diskon') != null ? $this->session->userdata('diskon') : 0;
      $pajak = $this->session->userdata('pajak') != null ? $this->session->userdata('pajak') : 0;
      //
      
      $harga_awal = $this->cart->total();
      $awal_kirim = $harga_awal + $biaya_kirim;
      $nilai_diskon = $awal_kirim * ($diskon / 100);
      $setelah_diskon = $awal_kirim - $nilai_diskon;
      $nilai_pajak = $setelah_diskon * ($pajak / 100);
      $besar_trans = $setelah_diskon + $nilai_pajak;
      
      $act = 'add_act';    
   }

?>

<div class="row" style="margin-top: 20px">
   <div class="col-lg-12">
      <!-- /.panel -->
      <div class="panel panel-info">
         <div class="panel-heading">
            <div class="navbar-header">
               <b class="navbar-brand"><i class="fa fa-file-o"> </i> &nbsp; <?php echo $page_title ;?> <?php echo $status !== 'pending' ? ' #DATA-READ-ONLY':'';?></b>
            </div>
            <div class="navbar-collapse" style="margin-bottom: 20px"></div>
            <!-- /.nav-collapse -->
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">
            <div class="col-lg-12">
              <?php if(isset($msg)){ ?>
              <div class="alert alert-danger" style="margin-bottom: 0px"><?php echo $msg;?></div>
              <?php } ?>
               <form action="<?php echo base_url() . 'transaksi/pembelian/' . $act;?>" method="post" accept-charset="utf-8" autocomplete="off">
                  <div class="col-lg-6">
                     <table  class="table-form">
                        <tr>
                           <td>Kode Pembelian</td>
                           <td><input style="width: 100%" type="text" name="kode_pembelian" required value="<?php echo $kode_pembelian;?>" id="kode_pembelian" class="form-control col-lg-8" tabindex="2" autofocus></td>
                        </tr>
                        <tr>
                           <td>Ref.Kode Penjualan</td>
                           <td>
                               <input style="width: 50%" class="form-control col-lg-8" type="text" value="<?php echo $kode_penjualan_terkait;?>" name="kode_penjualan_terkait" id="kode_penjualan_terkait"/>                               
                               <div id="suggestions-container"></div>
                           </td>
                        </tr>
                        <tr>
                           <td>Tanggal</td>
                           <td><input style="width: 50%" type="text" name="tgl_pembelian" required value="<?php echo $tgl_pembelian;?>" id="tgl_pembelian" class="form-control col-lg-8 tag_tgl" tabindex="2"></td>
                        </tr>
                        <tr>
                           <td>Supplier</td>
                           <td>                              
                              <select style="width: 50%" name="id_supplier" id="id_supplier">
                              <?php foreach($supplier->result() as $s){ ?>
                                <option value="<?php echo $s->id;?>"><?php echo $s->nama;?></option>
                              <?php } ?>
                              </select>  
                              
                           </td>
                        </tr>
                        <tr>
                           <td>Tanggal Kirim</td>                           
                           <td><input style="width: 50%" type="text" name="tgl_kirim" value="<?php echo $tgl_kirim;?>" id="tgl_kirim" class="form-control col-lg-8 tag_tgl" tabindex="2"></td>                           
                        </tr>
                        <tr>
                           <td width="25%">Alamat Pengiriman</td>                           
                           <td><textarea style="width: 100%" name="alamat_pengiriman" id="alamat_pengiriman" class="form-control col-lg-8" tabindex="2"><?php echo $alamat_pengiriman;?></textarea></td>                           
                        </tr>
                        <tr>
                           <td width="25%">Term Pengiriman</td>                           
                           <td><textarea style="width: 100%" name="term_pengiriman" id="term_pengiriman" class="classy-editor form-control col-lg-8" tabindex="2"><?php echo $term_pengiriman;?></textarea></td>                           
                        </tr>
                        <tr>
                           <td width="25%">Term Pembayaran</td>                           
                           <td><textarea style="width: 100%" name="term_pembayaran" id="term_pembayaran" class="form-control col-lg-8" tabindex="2"><?php echo $term_pembayaran;?></textarea></td>                           
                        </tr>
                        
                        <tr>
                           <td width="25%">Catatan Pembelian</td>                           
                           <td><textarea style="width: 100%" name="catatan_pembelian" id="catatan_pembelian" class="form-control col-lg-8" tabindex="2"><?php echo $catatan_pembelian;?></textarea></td>                           
                        </tr>
                     </table>
                  </div>
                 
                  <div class="col-lg-12" style="margin-bottom: 20px">
                     <?php if($status === 'pending'){ ?>
                     <a href="#dataitem" onclick="get_bahan()" data-toggle="modal" class="btn btn-info btn-sm pull-right"><i class="fa fa-plus"> </i> Tambah Item</a>
                     <?php } ?>
                  </div>
                  
                  <div class="col-lg-12" id="table-no-item">                     
                     <div class="table-responsive">                        
                        <table  id="table-body" class="table table-bordered table-hover">
                           <thead>
                              <tr>                                                                                                                 
                                 <th>Kode Produk</th>
                                 <th>Deskripsi</th>                                 
                                 <th>Qty</th>
                                 <th>Harga</th>                                
                                 <th>Sub Total</th>
                                 <th>Aksi</th>
                              </tr>
                           </thead>
                           <tbody>                  
                              <tr>
                                 <td colspan="6" style="text-align: center; font-weight: bold">
                                   <div class="alert alert-danger" style="margin-bottom: 0px">Data Item Belum Ada</div>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>

                  <div class="col-lg-12" id="table-item">                     
                     <div class="table-responsive">                        
                        <table id="table-item-body" class="table table-bordered table-hover">
                           <thead>
                              <tr>                                                                                                                 
                                 <th>Kode Bahan</th>
                                 <th>Deskripsi</th>                                 
                                 <th>Qty</th>
                                 <th>Harga</th>                                
                                 <th>Sub Total</th>
                                 <?php if($status === 'pending'){ ?>
                                 <th>Aksi</th>
                                 <?php } ?>
                              </tr>
                           </thead>
                           <tbody>
                              <?php foreach ($this->cart->contents() as $item) { ?> 
                              <?php $r = $this->basecrud_m->get_where('tbl_bahan_mentah',array('id'=>$item['name']))->row();?>
                              <tr id="row_<?php echo $item['rowid'];?>">
                                 <td><?php echo $r->kode_bahan?></td>                                 
                                 <td><?php echo $r->deskripsi;?></td>
                                 <td><?php echo $item['qty'];?></td>
                                 <td><?php echo formatRupiah($item['price']);?></td>                                                                
                                 <td><?php echo formatRupiah($item['subtotal']);?></td>   
                                 <?php if($status === 'pending'){ ?>
                                 <td class="ctr">
                                   <div class="btn-group">                                                                         
                                      <button type="button" class="btn btn-danger btn-sm" onclick="del('<?php echo $item['rowid']; ?>')"><i class="fa fa-trash-o "></i> Hapus</button>                                         
                                   </div>                                   
                                 </td>
                                 <?php } ?>
                              </tr>                              
                              <?php } ?>                              
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="col-lg-8" id="col-separator">
                  </div>
                  <div class="col-lg-4" id="table-footer" style="padding-right: 0px; padding-left: 0px;">                     
                     <div class="table-responsive">                        
                        <table  id="table-body" class="table">
                           <thead>                           
                           </thead>
                           <tbody>
                              <tr>
                                 <td style="text-align: right;border: none" colspan="4">TOTAL</td>
                                 <td style="border: none" value="<?php echo $harga_awal;?>" id="total"><?php echo formatRupiah($this->cart->total());?></td>
                              </tr>
                              <tr style="border: none">
                                 <td style="text-align: right;border: none" colspan="4">Biaya Kirim</td>
                                 <td style="border: none"><input style="width: 100%" type="number" id="biaya_kirim" value="<?php echo $biaya_kirim;?>" onchange="hitung_akhir();" onkeyup="hitung_akhir();" name="biaya_kirim"></td>
                              </tr>
                              <tr>
                                 <td style="text-align: right;border: none" colspan="4">Diskon</td>
                                 <td style="border: none">
                                    <input style="width: 100px" type="text-number" id="diskon" value="<?php echo $diskon;?>" onkeyup="hitung_akhir();" onchange="hitung_akhir();" name="diskon">
                                    <span class="add-on">%</span>
                                    <label id="nilai_diskon"><?php echo '- ' . formatRupiah($nilai_diskon)?></label>   
                                 </td>                                    
                              </tr>
                              <tr>
                                 <td style="text-align: right;border: none" colspan="4">Pajak</td>
                                 <td style="border: none">
                                    <input style="width: 100px" type="text-number" id="pajak" value="<?php echo $pajak;?>" onkeyup="hitung_akhir();" onchange="hitung_akhir();" name="pajak">
                                    <span class="add-on">%</span>
                                    <label id="nilai_pajak"><?php echo '+ ' . formatRupiah($nilai_pajak)?></label>   
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: right;border: none" colspan="4">Total Akhir</td>
                                 <td style="border: none">
                                    <input style="width: 100%" id="besar_trans" value="<?php echo formatRupiah($besar_trans);?>" name="besar_trans" readonly>                                       
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  
                  <div class="col-lg-12 pull-right">
                     <a href="<?php echo base_url() . 'transaksi/pembelian'?>" class="btn btn-success" tabindex="11"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                     <?php if($status === 'pending'){ ?>
                     <button type="submit" class="btn btn-primary" tabindex="10"><i class="fa fa-check-circle"></i> Simpan</button>
                     <?php } ?>
                  </div>
               </form>
            </div>
            <!-- /.row -->
         </div>
         <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
   </div>
   <!-- /.col-lg-4 -->
</div>

<!-- MODAL PRODUK -->
<div class="modal col-lg-12 fade" id="dataitem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form id="form-item" action="<?php echo base_url() . 'transaksi/pembelian/add_detail'?>" method="post">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               <h4 class="modal-title" id="myModalLabel">Data Item</h4>
            </div>
            <div class="modal-body">
               <table width="100%" class="table-form" align="center">
                  <tr>
                     <td width="40%">Bahan</td>
                     <td>
                        <select id="bahan" name="id_bahan_mentah" style="width:100%" required>
                           
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td width="40%">Kuantitas</td>
                     <td>
                        <div class="input-group">
                           <input type="number" id="kuantitas" name="kuantitas" class="form-control col-lg-12" tabindex="1" required>
                           <div id="satuan-sign" class="input-group-addon"></div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td width="40%">Deskripsi</td>
                     <td><input type="text" id="deskripsi" name="deskripsi" class="form-control col-lg-12" tabindex="1" required></td>
                  </tr>
                  <tr>
                     <td width="40%">Harga Per Item</td>
                     <td><input type="number" id="harga_per_item" name="harga_per_item" class="form-control col-lg-12" tabindex="1" required></td>
                  </tr>
               </table>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Simpan</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
   </div>
</div>

<script>
   
   $('#kode_penjualan_terkait').devbridgeAutocomplete({       
       minChars:3,
       paramName:'search',
       lookupLimit:5,
       delimiter:',',
       serviceUrl: '<?php echo base_url() .'transaksi/pembelian/get-kode-penjualan-terkait/';?>',
       onSearchStart: function (query) {
         
       },
       onSelect: function (suggestion) {
         
       },
       onSearchComplete: function (query, suggestions) {
         
       }
   });
   
   //window.onbeforeunload = function() {
   //   return "Data will be lost if you leave the page, are you sure?";
   //}
  
  <?php if($this->cart->total_items() == 0){ ?>
      $('#table-no-item').show();
      $('#table-item').hide();
      $('#col-separator').hide();
      $('#table-footer').hide();
  <?php }else{ ?>
      $('#table-no-item').hide();
      $('#table-item').show();
      $('#col-separator').show();
      $('#table-footer').show();
  <?php } ?>
   
   
   function get_bahan(args) {
      var id_supplier = $('#id_supplier').val();
      $.get("<?php echo base_URL(); ?>transaksi/pembelian/get-bahan/",
            {'id_supplier':  id_supplier},
            function(data){               
               $('#bahan').html(data);
               reset();
            }
      );
   }
   
   function reset() {
      $('#satuan-sign').html('');
      $('#deskripsi').val('');
      $('#harga_per_item').val('');
      $('#kuantitas').val('');
   }
   
   $('#bahan').change(function () {
                         
      $.get("<?php echo base_URL(); ?>transaksi/pembelian/get-deskripsi-bahan/",
            {'id'         :  this.value},
            function(data){               
               $('#deskripsi').val(data.deskripsi);
               $('#satuan-sign').html(data.satuan);
               $('#harga_per_item').val(data.hrg_terakhir);
            }
      );
   });
   
   function refresh_total(total){
      var biaya_kirim = $('#biaya_kirim').val();
      var diskon = $('#diskon').val().length > 0 ? $('#diskon').val() : 0 ;
      var pjk = $('#pajak').val().length > 0 ? $('#pajak').val() : 0 ;
      
      var awal_kirim = parseInt(total,10) + parseInt(biaya_kirim,10);
      var nilai_diskon = parseInt(awal_kirim,10) * (parseFloat(diskon) / 100);
      var setelah_diskon = parseInt(awal_kirim,10) - nilai_diskon;
      var nilai_pajak = parseInt(setelah_diskon,10) * (parseFloat(pjk) / 100);
      var besar_trans = parseInt(setelah_diskon,10) + parseInt(nilai_pajak);
      
      $('#nilai_diskon').html('- ' + formatRupiah(nilai_diskon));
      $('#nilai_pajak').html('+ ' + formatRupiah(nilai_pajak));
      $('#besar_trans').val(formatRupiah(besar_trans));
   }
   
   function del(id){
      //alert('test');
	  var answer =  confirm('Anda yakin ingin menghapus data ini?');
     
      if (answer) {
          $.ajax({
            type:'POST',
            async: false,
            cache: false,
            url: '<?php echo base_url() . 'transaksi/pembelian/del_detail/';?>' + id,
            success: function(data){				                		
                var tr  = $('#row_' + id);
                tr.css("background-color","").css("background-color","#FF3700");
                tr.fadeOut(400, function(){
                   tr.remove();
                   
                   if (data == 0) {
                     
                     $('#table-no-item').show();
                     $('#table-item').hide();
                     $('#col-separator').hide();
                     $('#table-footer').hide();
                     
                   }else{
                     
                     $('#table-no-item').hide();
                     $('#table-item').show();
                     $('#col-separator').show();
                     $('#table-footer').show();
                    
                   }
                   
                  refresh_total(data);
                });
                
                
            }
          });
      }
   }
   
   $('#form-item').submit(function(){
	  
	  var page_url = $(this).attr("action");
	  $.ajax({
		 url: page_url,
		 type: 'POST',		 
		 data: $('#form-item').serialize(),		 
		 success: function (data) {				
			 
            var row = data.row;
            var total = data.total;
            
            $('#table-no-item').hide();
            $('#table-item').show();
            $('#col-separator').show();
            $('#table-footer').show();
            
            $('#table-item-body').find("tr:gt(0)").remove().append(row);
            $('#table-item-body').append(row);
            $('#dataitem').modal('hide'); //hide modal            
            $('#total').attr('value',total).html(formatRupiah(total));
            
            refresh_total(total);
		 },
		 error: function () {	
			 console.error('Error !');	
		 }
 
	 });	
	  return false;
   })
   
   
   function hitung_akhir(){

        var total  = $('#total').attr("value");
        var bkirim = $('#biaya_kirim').val();
        var disk   = $('#diskon').val().length > 0 ? $('#diskon').val() : 0 ;
        var pjk    = $('#pajak').val().length > 0 ? $('#pajak').val() : 0 ;
        
        
        $.post("<?php echo base_url() . 'transaksi/pembelian/update-nilai-tambahan/' . $this->uri->segment(4);?>",
                  {  biaya_kirim :  bkirim,
                     diskon      :  disk,
                     pajak       :  pjk
                  }
               );

        refresh_total(total);
        return false; 
    }    

</script>