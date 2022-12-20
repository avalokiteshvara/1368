<?php
   
   $mode = $this->uri->segment(3);
   
   if($mode === 'edt' || $mode === 'edt_act'){
      
      $id = $data->id;
      $kode_keluar = $mode === 'edt' ? $data->kode_keluar : set_value('kode_keluar');
      $kode_penjualan = $mode === 'edt' ? $data->kode_penjualan : set_value('kode_penjualan');
      $tgl = $mode === 'edt' ? $data->tgl : set_value('tgl');
      $pemeriksa = $mode === 'edt' ? $data->pemeriksa : set_value('pemeriksa');
      $keterangan = $mode === 'edt' ? $data->keterangan : set_value('keterangan');
      
      $act = 'edt_act/' . $id;
      
   }else{
      
      $this->db->select_max('id');
      $max_id = $this->db->get('tbl_brg_keluar')->row()->id;
      
      $kode_keluar = $mode === 'add' ?  'WO-' . str_pad(($max_id + 1),6,'0',STR_PAD_LEFT) : set_value('kode_keluar');
      $kode_penjualan = $mode === 'add' ? '' : set_value('kode_penjualan');
      $tgl = $mode === 'add' ? '' : set_value('tgl');
      $pemeriksa = $mode === 'add' ? '' : set_value('pemeriksa');
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
               <b class="navbar-brand"><i class="fa fa-file-o"> </i> &nbsp; <?php echo $page_title;?></b>
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
               <form action="<?php echo base_url() . 'barang/keluar/' . $act;?>" method="post" accept-charset="utf-8" autocomplete="off">
                  <div class="col-lg-6">
                     <table  class="table-form">
                        <tr>
                           <td>Kode Keluar</td>
                           <td>
                               <input style="width: 50%" class="form-control col-lg-8" type="text" value="<?php echo $kode_keluar;?>" name="kode_keluar" id="kode_keluar"/>                               
                           </td>
                        </tr>
                        <tr>
                           <td>Kode Penjualan</td>
                           <td>
                               <input style="width: 50%" class="form-control col-lg-8" type="text" value="<?php echo $kode_penjualan;?>" name="kode_penjualan" id="kode_penjualan"/>
                               <button onclick="show_details()" id="btn-details" type="button" class="btn btn-primary" style="margin-left: 10px;display: none"><i class="fa fa-check-circle"></i> Details</button>                     
                               <div id="suggestions-container"></div>
                           </td>
                        </tr>
                        <tr>
                           <td>Tanggal</td>
                           <td><input style="width: 50%" type="text" name="tgl" required value="<?php echo $tgl;?>" id="tgl" class="form-control col-lg-8 tag_tgl" tabindex="2"></td>
                        </tr>
                        <tr>
                           <td width="25%">Pemeriksa</td>                           
                           <td><input type="text" name="pemeriksa" required value="<?php echo $pemeriksa;?>" id="pemeriksa" class="form-control col-lg-8" tabindex="2"></td>
                        </tr>
                        <tr>
                           <td width="25%">Keterangan</td>                           
                           <td><textarea style="width: 100%" name="keterangan" id="keterangan" class="form-control col-lg-8" tabindex="2"><?php echo $keterangan;?></textarea></td>                           
                        </tr>
                     </table>
                  </div>
                  
                  <div class="col-lg-12">
                     <a href="#dataitem"  data-toggle="modal" class="btn btn-info btn-sm pull-right" style="margin-bottom: 10px"><i class="fa fa-plus"> </i> Tambah Item</a>                     
                  </div>
                  
                  <div class="col-lg-12" id="table-no-item">                     
                     <div class="table-responsive">                        
                        <table  id="table-body" class="table table-bordered table-hover">
                           <thead>
                              <tr>
                                <th>Produk</th>
                                <th>Deskripsi</th>
                                <th>Keadaan Produk</th>    
                                <th>Qty</th>                                
                                <th>Aksi</th>
                              </tr>
                           </thead>
                           <tbody>                  
                              <tr>
                                 <td colspan="5" style="text-align: center; font-weight: bold">
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
                                <th>Produk</th>
                                <th>Deskripsi</th>
                                <th>Keadaan Produk</th>    
                                <th>Qty</th>                                
                                <th>Aksi</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              
                              foreach ($this->cart->contents() as $item) {
                                 $id_raw = $item['name'];
                                 $produk_det = $this->basecrud_m->get_where('tbl_produk',array('id'=>$id_raw))->row();
                                 
                              ?> 
                              
                              <tr id="row_<?php echo $item['rowid'];?>">                                 
                                 <td><?php echo $produk_det->kode_produk;?></td>
                                 <td><?php echo $produk_det->deskripsi;?></td>
                                 <td><?php echo ucfirst($item['keadaan']);?></td> 
                                 <td><?php echo $item['qty'];?></td>                                 
                                 <td class="ctr" style="width: 100px">
                                   <div class="btn-group">                                                                         
                                      <button type="button" class="btn btn-danger btn-sm" onclick="del('<?php echo $item['rowid']; ?>')"><i class="fa fa-trash-o "></i>Hapus</button>                                         
                                   </div>
                                </td>
                              </tr>                              
                              <?php } ?>                              
                           </tbody>
                        </table>
                     </div>
                  </div>
                  
                  <div class="col-lg-12 pull-right">
                     <a href="<?php echo base_url() . 'barang/keluar'?>" class="btn btn-success" tabindex="11"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                     <button type="submit" class="btn btn-primary" tabindex="10"><i class="fa fa-check-circle"></i> Simpan</button>                     
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

<div class="modal col-lg-12 fade" id="datadetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="datadetails-myModalLabel">Data Details</h4>
         </div>
         <div class="modal-body" id="datadetails-body">
            <table width="100%" class="table-form" align="center">
               <tr>
                  <td style="width: 30%">Konsumen</td>
                  <td>Nama Konsumen</td>
               </tr>
               <tr>
                  <td style="width: 30%">Tgl Penjualan</td>
                  <td>Tgl Beli</td>
               </tr>
            </table>
            <table width="100%" class="table table-bordered" align="center" style="margin-top: 30px">
               <thead>
                  <tr>
                     <th>Produk</th>
                     <th>Deskripsi</th>
                     <th>Keadaan Produk</th>
                     <th>Ukuran</th>
                     <th>Qty</th>                     
                  </tr>
               </thead>               
               <tbody>
                  <tr>
                     <td>Isi Produk</td>
                     <td>Deskripsi</td>
                     <td>Keadaan</td>
                     <td>Ukuran</td>
                     <td>Qty</td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="modal-footer">         
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

<!-- MODAL PRODUK -->
<div class="modal col-lg-12 fade" id="dataitem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form id="form-item" action="<?php echo base_url() . 'barang/keluar/add_detail'?>" method="post">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               <h4 class="modal-title" id="myModalLabel">Data Item</h4>
            </div>
            <div class="modal-body">
               <table width="100%" class="table-form" align="center">
                  <tr>
                    <td>Bahan</td>
                    <td>
                     
                      <select style="width: 100%" id="produk" name="id_produk" required>
                        <option value="">[ Pilih Produk ]</option>
                      <?php foreach($produk->result() as $r){ ?>
                        <option value="<?php echo $r->id;?>"><?php echo $r->kode_produk;?></option>
                      <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                     <td width="40%">Keadaan</td>
                     <td>
                        <select name="keadaan" style="width: 100%" required>
                           <option value="matang">Matang</option>
                           <option value="mentah">Mentah</option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td width="40%">Kuantitas</td>
                     <td>
                        <input type="number" name="kuantitas" id="kuantitas" class="form-control col-lg-8" tabindex="2" required>
                     </td>
                  </tr>
                  <tr>
                     <td width="40%">Deskripsi</td>
                     <td><input type="text" id="deskripsi" name="deskripsi" class="form-control col-lg-12" tabindex="1"></td>
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

   <?php if(($mode === 'edt' || $mode === 'edt_act') && strlen($kode_penjualan) > 0){ ?>
   $('#btn-details').show();
   <?php } ?>
   
  <?php if($this->cart->total_items() == 0){ ?>
      $('#table-no-item').show();
      $('#table-item').hide();
  <?php }else{ ?>
      $('#table-no-item').hide();
      $('#table-item').show();      
  <?php } ?>
  
   $('#produk').change(function () {                         
      $.get("<?php echo base_url();?>barang/keluar/get-produk-details/",
            {'id'         :  this.value},
            function(data){               
               $('#deskripsi').val(data.deskripsi);               
            }
      );
   });
  
   function fill_details(){
      var kode_penjualan = $('#kode_penjualan').val();
      
      $.get("<?php echo base_URL(); ?>barang/keluar/get-details-penjualan",
            {'kode_penjualan' :  kode_penjualan,
             'with-header': 'NOPE'},
            function(data){               
               $('#table-no-item').hide();
               $('#table-item').show();
            
               $('#table-item-body').find("tr:gt(0)").remove();
               $('#table-item-body').append(data);
            }
      );

      return false;   
   }
   
   $('#kode_penjualan').devbridgeAutocomplete({       
       minChars:3,
       paramName:'search',
       lookupLimit:5,
       serviceUrl: '<?php echo base_url() .'barang/keluar/get-kode-penjualan/';?>',
       onSearchStart: function (query) {
         $('#btn-details').hide();
       },
       onSelect: function (suggestion) {
         $('#btn-details').show();

         <?php if($mode === 'add' || $mode === 'add_act'){ ?>
         //jika nyampe disini dan mode 'add' maka
         fill_details();
         <?php } ?>
         
       },
       onSearchComplete: function (query, suggestions) {
         
       }
   });

    
   function del(id){
      //alert('test');
	  var answer =  confirm('Anda yakin ingin menghapus data ini?');
     
      if (answer) {
          $.ajax({
            type:'POST',
            async: false,
            cache: false,
            url: '<?php echo base_url() . 'barang/keluar/del_detail/';?>' + id,
            success: function(data){				                		
                var tr  = $('#row_' + id);
                tr.css("background-color","").css("background-color","#FF3700");
                tr.fadeOut(400, function(){
                   tr.remove();
                   
                   if (data == 0)
                   {                     
                     $('#table-no-item').show();
                     $('#table-item').hide();                                         
                   }else{                     
                     $('#table-no-item').hide();
                     $('#table-item').show();                    
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
			
            $('#table-no-item').hide();
            $('#table-item').show();
            
            $('#table-item-body').find("tr:gt(0)").remove();
            $('#table-item-body').append(data);
            $('#dataitem').modal('hide'); //hide modal            
            
		 },
		 error: function () {	
			 console.error('Error !');	
		 }
 
	 });	
	  return false;
   })
   
   function show_details(){
      var kode_penjualan = $('#kode_penjualan').val();
      $.get("<?php echo base_URL(); ?>barang/keluar/get-details-penjualan/",
            {'kode_penjualan' :  kode_penjualan,
             'with-header': 'YES'},
            function(data,status){               
               $('#datadetails-myModalLabel').html('Data Details ' + kode_penjualan);
               $('#datadetails-body').html(data);
            }
      );
      
      $('#datadetails').modal('toggle');     
      
   }
   

</script>