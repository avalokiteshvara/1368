<?php
   
   $mode = $this->uri->segment(3);
   
   if($mode === 'edt' || $mode === 'edt_act'){
      
      $id = $data->id;
      $kode_penjualan = $mode === 'edt' ? $data->kode_penjualan : set_value('kode_penjualan');      
      $tgl_penjualan = $mode === 'edt' ? $data->tgl_penjualan : set_value('tgl_penjualan');
      //status
      $status = $data->status;
      $id_konsumen= $mode === 'edt' ? $data->id_konsumen : set_value('id_konsumen');      
      $tgl_kirim_diminta = $mode === 'edt' ? $data->tgl_kirim_diminta : set_value('tgl_kirim_diminta');
      $alamat_pengiriman = $mode === 'edt' ? $data->alamat_pengiriman : set_value('alamat_pengiriman');
      $catatan_penjualan = $mode === 'edt' ? $data->catatan_penjualan : set_value('catatan_penjualan');
      
      $sp_nama = $mode === 'edt' ? $data->sp_nama : set_value('sp_nama');
      $sp_telp = $mode === 'edt' ? $data->sp_telp : set_value('sp_telp');
      $sp_email = $mode === 'edt' ? $data->sp_email : set_value('sp_email');
      $sp_jabatan = $mode === 'edt' ? $data->sp_jabatan : set_value('sp_jabatan');
      $keterangan = $mode === 'edt' ? $data->keterangan : set_value('keterangan');
      
      $act = 'edt_act/' . $id;
      
   }else{
      
      $this->db->select_max('id');
      $max_id = $this->db->get('tbl_penjualan')->row()->id;
      
      $kode_penjualan = $mode === 'add' ? 'SO-' . str_pad(($max_id + 1),6,'0',STR_PAD_LEFT) : set_value('kode_penjualan');     
      $tgl_penjualan = $mode === 'add' ? '' : set_value('tgl_penjualan');
      $status = 'pending';
      $id_konsumen = $mode === 'add' ? '' : set_value('id_konsumen');      
      $tgl_kirim_diminta = $mode === 'add' ? '' : set_value('tgl_kirim_diminta');
      $alamat_pengiriman = $mode === 'add' ? '' : set_value('alamat_pengiriman');
      $catatan_penjualan = $mode === 'add' ? '' : set_value('catatan_penjualan');
      
      $sp_nama = $mode === 'add' ? '' : set_value('sp_nama');
      $sp_telp = $mode === 'add' ? '' : set_value('sp_telp');
      $sp_email = $mode === 'add' ? '' : set_value('sp_email');
      $sp_jabatan = $mode === 'add' ? '' : set_value('sp_jabatan');      
      $keterangan = $mode === 'add' ? '' : set_value('keterangan');
     
      $act = 'add_act';    
   }

?>

<div class="row" style="margin-top: 20px">
   <div class="col-lg-12">
      <!-- /.panel -->
      <div class="panel panel-info">
         <div class="panel-heading">
            <div class="navbar-header">
               <b class="navbar-brand"><i class="fa fa-file-o"> </i> &nbsp; <?php echo $page_title;?><?php echo $status !== 'pending' ? ' #DATA-READ-ONLY':'';?></b>
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
               <form action="<?php echo base_url() . 'transaksi/penjualan/' . $act;?>" method="post" accept-charset="utf-8" autocomplete="off">
                  <div class="col-lg-6">
                     <table  class="table-form">
                        <tr>
                           <td>Kode Penjualan</td>
                           <td><input style="width: 100%" type="text" name="kode_penjualan" required value="<?php echo $kode_penjualan;?>" id="nama" class="form-control col-lg-8" tabindex="2" autofocus></td>
                        </tr>
                        <tr>
                           <td>Tanggal</td>
                           <td><input style="width: 50%" type="text" name="tgl_penjualan" required value="<?php echo $tgl_penjualan;?>" id="tgl_penjualan" class="form-control col-lg-8 tag_tgl" tabindex="2"></td>
                        </tr>
                        <tr>
                           <td>Pembeli</td>
                           <td>                              
                              <select style="width: 50%" name="id_konsumen" id="id_konsumen" required>
                                 <option value="">Pilih Pembeli</option>
                              <?php foreach($buyer->result() as $b){ ?>
                                 <option <?php echo $b->id === $id_konsumen ? 'selected':'';?> value="<?php echo $b->id;?>"><?php echo $b->nama;?></option>
                              <?php } ?>  
                              </select> 
                           </td>
                        </tr>
                        <tr>
                           <td>Tanggal Kirim</td>                           
                           <td><input style="width: 50%" type="text" name="tgl_kirim_diminta" value="<?php echo $tgl_kirim_diminta;?>" id="tgl_kirim_diminta" class="form-control col-lg-8 tag_tgl" tabindex="2"></td>                           
                        </tr>
                        <tr>
                           <td width="25%">Alamat Pengiriman</td>                           
                           <td><textarea style="width: 100%" name="alamat_pengiriman" id="alamat_pengiriman" class="form-control col-lg-8" tabindex="2"><?php echo $alamat_pengiriman;?></textarea></td>                           
                        </tr>  
                        <tr>
                           <td width="25%">Catatan Penjualan</td>                           
                           <td><textarea style="width: 100%" name="catatan_penjualan" id="catatan_penjualan" class="form-control col-lg-8" tabindex="2"><?php echo $catatan_penjualan;?></textarea></td>                           
                        </tr>
                        <tr>
                           <td colspan="2">
                           </td>
                        </tr>
                     </table>
                  </div>
                  <!--<div class="col-lg-6">                     
                     <table class="table-form">
                        <tr>
                           <td width="25%">CP Nama</td>                           
                           <td><input style="width: 100%" type="text" name="sp_nama" value="<?php echo $sp_nama;?>" id="sp_nama" class="form-control col-lg-8" tabindex="2"></td>                           
                        </tr>
                        <tr>
                           <td width="25%">CP Telp</td>                           
                           <td><input style="width: 100%" type="text" name="sp_telp" value="<?php echo $sp_telp;?>" id="sp_telp" class="form-control col-lg-8" tabindex="2"></td>                           
                        </tr>
                        <tr>
                           <td width="25%">CP Email</td>                           
                           <td><input style="width: 100%" type="text" name="sp_email" value="<?php echo $sp_email;?>" id="sp_telp" class="form-control col-lg-8" tabindex="2"></td>                           
                        </tr>
                        <tr>
                           <td width="25%">CP Jabatan</td>                           
                           <td><input style="width: 100%" type="text" name="sp_jabatan" value="<?php echo $sp_jabatan;?>" id="sp_telp" class="form-control col-lg-8" tabindex="2"></td>                           
                        </tr>

                        <tr>
                           <td width="25%">Keterangan</td>                           
                           <td><textarea style="width: 100%" name="keterangan" id="keterangan" class="form-control col-lg-8" tabindex="2"><?php echo $keterangan;?></textarea></td>                           
                        </tr>  
                     </table>
                  </div>-->
                  
                  <div class="col-lg-12" style="margin-bottom: 20px">
                     <?php if($status === 'pending'){ ?>
                     <a href="#dataitem"  data-toggle="modal" class="btn btn-info btn-sm pull-right" style="margin-bottom: 10px"><i class="fa fa-plus"> </i> Tambah Item</a>                     
                     <?php } ?>
                  </div>
                  
                  <div class="col-lg-12">                     
                     <div class="table-responsive">                        
                        <table  id="table-body" class="table table-bordered table-hover">
                           <thead>
                              <tr>                                                                                                                 
                                 <th>Kode Produk</th>
                                 <th>Keadaan</th>
                                 <th>Qty</th>
                                 <th>Harga</th>                                
                                 <th>Sub Total</th>
                                 <?php if($status === 'pending'){ ?>
                                 <th style="width: 8%">Aksi</th>
                                 <?php } ?>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if($this->cart->total_items() == 0){ ?>
                                 <tr>
                                    <td colspan="6" style="text-align: center; font-weight: bold">
                                      <div class="alert alert-danger" style="margin-bottom: 0px">Data Item Belum Ada</div>
                                    </td>
                                 </tr>
                              <?php }else{ ?>
                                 <?php foreach ($this->cart->contents() as $item) { ?>                              
                                 <?php $r = $this->basecrud_m->get_where('tbl_produk',array('id'=>$item['name']))->row();?>
                                 <tr id="row_<?php echo $item['rowid'];?>">
                                    <td><?php echo $r->kode_produk;?></td>
                                    <td><?php echo $item['keadaan'];?></td>
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
                                 
                                 <tr>
                                    <td style="text-align: right" colspan="4">TOTAL</td>
                                    <td id="total"><?php echo formatRupiah($this->cart->total());?></td>
                                 </tr>                                 
                              <?php } ?>
                              
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="col-lg-12 pull-right">
                     <a href="<?php echo base_url() . 'transaksi/penjualan'?>" class="btn btn-success" tabindex="11"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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
         <form id="form-item" action="<?php echo base_url() . 'transaksi/penjualan/add_detail'?>" method="post">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               <h4 class="modal-title" id="myModalLabel">Data Item</h4>
            </div>
            <div class="modal-body">
               <table width="100%" class="table-form" align="center">
                  <tr>
                     <td>Produk</td>
                     <td>
                        <select id="produk" name="id_produk" required style="width: 100%">
                           <option value="">[ Pilih Produk ]</option>
                           <?php foreach($produk->result() as $p){ ?>
                           <option value="<?php echo $p->id?>"><?php echo $p->kode_produk;?></option>
                           <?php } ?>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td width="40%">Keadaan Produk</td>
                     <td>
                        <select name="keadaan" style="width: 100%">
                           <option value="matang">Matang</option>
                           <option value="mentah">Mentah</option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td width="40%">Kuantitas</td>
                     <td><input type="number" id="kuantitas" name="kuantitas" class="form-control col-lg-12" required></td>
                  </tr>
                  <tr>
                     <td width="40%">Harga Per Item</td>
                     <td><input type="number" id="harga_per_item" name="harga_per_item" class="form-control col-lg-12" required></td>
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
   
   $('#produk').change(function () {
                         
      $.get("<?php echo base_URL(); ?>transaksi/penjualan/get-latest-price/",
            {'id'         :  this.value},
            function(data){               
               $('#harga_per_item').val(data.harga);               
            }
      );
   });
   
   function del(id){
      //alert('test');
	  var answer =  confirm('Anda yakin ingin menghapus data ini?');
      var empty_row =  '<tr>' +
                       '    <td colspan="6" style="text-align: center; font-weight: bold">' +
                       '      <div class="alert alert-danger" style="margin-bottom: 0px">Data Item Belum Ada</div>' +
                       '    </td>' +
                       '</tr>';
      if (answer) {
          $.ajax({
            type:'POST',
            async: false,
            cache: false,
            url: '<?php echo base_url() . 'transaksi/penjualan/del_detail/';?>' + id,
            success: function(data){				                		
                var tr  = $('#row_' + id);
                tr.css("background-color","").css("background-color","#FF3700");
                tr.fadeOut(400, function(){
                   tr.remove();
                   //$('#total').html("<?php echo formatRupiah($this->cart->total());?>");
                   if (data == 0) {
                     $('#table-body').find("tr:gt(0)").remove();
                     $('#table-body').append(empty_row);
                   }else{
                     $('#total').html(data);
                   }
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
			 //$('#table-body').empty();
            $('#table-body').find("tr:gt(0)").remove();
            $('#table-body').append(data);
            $('#dataitem').modal('hide');
		 },
		 error: function () {	
			 console.error('Error !');	
		 }
 
	 });	
	  return false;
   });
   
   <?php if($mode === 'add' || $mode === 'add_act'){ ?>
   $('#id_konsumen').change(function () {
                         
      $.get("<?php echo base_URL(); ?>transaksi/penjualan/get-konsumen-details/",
            {'id'         :  this.value},
            function(data,status){               
               $('#alamat_pengiriman').val(data.alamat_pengiriman);               
            }
      );
   });
   <?php } ?>
   
</script>