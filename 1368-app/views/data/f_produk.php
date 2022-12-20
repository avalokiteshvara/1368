<?php
   
   $mode = $this->uri->segment(3);
   
   if($mode === 'edt' || $mode === 'edt_act'){
      
      $id = $data->id;      
      $kode_produk = $mode === 'edt' ? $data->kode_produk : set_value('kode_produk');  
      $deskripsi = $mode === 'edt' ? $data->deskripsi : set_value('deskripsi');
      $act = 'edt_act/' . $id;
      
   }else{
      
      //dibuat_oleh
      $kode_produk = $mode === 'add' ? '' : set_value('kode_produk');      
      $deskripsi = $mode === 'add' ? '' : set_value('deskripsi');      
      $act = 'add_act';    
   }

?>

<div class="row" style="margin-top: 20px">
   <div class="col-lg-12">
      <!-- /.panel -->
      <div class="panel panel-info">
         <div class="panel-heading">
            <div class="navbar-header">
               <b class="navbar-brand"><i class="fa fa-file-o"> </i> &nbsp; <?php echo $page_title ;?></b>
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
               <form action="<?php echo base_url() . 'data/produk/' . $act;?>" method="post" accept-charset="utf-8" autocomplete="off">
                  <div class="col-lg-6">
                     <table  class="table-form">
                        <tr>
                           <td>Kode Produk</td>
                           <td><input style="width: 100%" type="text" name="kode_produk" required value="<?php echo $kode_produk;?>" id="kode_produk" class="form-control col-lg-8" tabindex="2" autofocus></td>
                        </tr>
                        
                        <tr>
                           <td width="25%">Keterangan</td>                           
                           <td><textarea style="width: 100%" name="deskripsi" id="deskripsi" class="form-control col-lg-8" tabindex="2"><?php echo $deskripsi;?></textarea></td>                           
                        </tr>
                     </table>
                  </div>
                 
                  <div class="col-lg-12" style="margin-bottom: 20px">                     
                     <a href="#dataitem" onclick="reset()" data-toggle="modal" class="btn btn-info btn-sm pull-right"><i class="fa fa-plus"> </i> Tambah Item</a>                     
                  </div>
                  
                  <div class="col-lg-12" id="table-no-item">                     
                     <div class="table-responsive">                        
                        <table  id="table-body" class="table table-bordered table-hover">
                           <thead>
                              <tr>                                                                                                                 
                                 <th>Kode Bahan</th>
                                 <th>Deskripsi</th>
                                 <th>Qty</th>                                 
                                 <th>Aksi</th>
                              </tr>
                           </thead>
                           <tbody>                  
                              <tr>
                                 <td colspan="4" style="text-align: center; font-weight: bold">
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
                                 <th>Aksi</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php foreach ($this->cart->contents() as $item) { ?> 
                              <?php
                                 $this->db->select('a.id as id,a.kode_bahan,a.deskripsi,b.nama as satuan');
                                 $this->db->join('tbl_satuan b','a.id_satuan = b.id','left');
                                 $r = $this->db->get_where('tbl_bahan_mentah a',array('a.id'=>$item['name']))->row();
                              ?>
                              <tr id="row_<?php echo $item['rowid'];?>">
                                 <td><?php echo $r->kode_bahan?></td>                                 
                                 <td><?php echo $r->deskripsi;?></td>
                                 <td><?php echo $item['qty'] . ' ' . $r->satuan;?></td>
                                 <td class="ctr">
                                   <div class="btn-group">                                                                         
                                      <button type="button" class="btn btn-danger btn-sm" onclick="del('<?php echo $item['rowid']; ?>')"><i class="fa fa-trash-o "></i> Hapus</button>                                         
                                   </div>                                   
                                 </td>
                                 
                              </tr>                              
                              <?php } ?>                              
                           </tbody>
                        </table>
                     </div>
                  </div>
                  
                  <div class="col-lg-12 pull-right">
                     <a href="<?php echo base_url() . 'data/produk'?>" class="btn btn-success" tabindex="11"><i class="fa fa-arrow-circle-left"></i> Kembali</a>                     
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

<!-- MODAL PRODUK -->
<div class="modal col-lg-12 fade" id="dataitem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form id="form-item" action="<?php echo base_url() . 'data/produk/add_detail'?>" method="post">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               <h4 class="modal-title" id="myModalLabel">Data Item</h4>
            </div>
            <div class="modal-body">
               <table width="100%" class="table-form" align="center">
                  <tr>
                     <td width="40%">Produk</td>
                     <td>
                        <select id="bahan_mentah" name="id_bahan_mentah" style="width:100%" required>
                           <option value="">[ Pilih Bahan ]</option>
                           <?php foreach($bahan_mentah->result() as $bm){ ?>
                           <option value="<?php echo $bm->id;?>"><?php echo $bm->kode_bahan;?></option>
                           <?php } ?>
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
                     <td><input type="text" id="modal-deskripsi" name="deskripsi" class="form-control col-lg-12" tabindex="1" required></td>
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
   
   <?php if($this->cart->total_items() == 0){ ?>
      $('#table-no-item').show();
      $('#table-item').hide();  
  <?php }else{ ?>
      $('#table-no-item').hide();
      $('#table-item').show();      
  <?php } ?>
   
   function reset() {
      $('#satuan-sign').html('');
      $('#modal-deskripsi').val('');
   }
   
   $('#bahan_mentah').change(function () {                         
      $.get("<?php echo base_URL(); ?>data/produk/get-bahan-details/",
            {'id'         :  this.value},
            function(data,status){               
               $('#modal-deskripsi').val(data.deskripsi);
               $('#satuan-sign').html(data.satuan);
            }
      );
   });
     
   function del(id){
      //alert('test');
	  var answer =  confirm('Anda yakin ingin menghapus data ini?');
     
      if (answer) {
          $.ajax({
            type:'POST',
            async: false,
            cache: false,
            url: '<?php echo base_url() . 'data/produk/del_detail/';?>' + id,
            success: function(data){				                		
                var tr  = $('#row_' + id);
                tr.css("background-color","").css("background-color","#FF3700");
                tr.fadeOut(400, function(){
                   tr.remove();
                   
                   if (data == 0) {
                     
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
</script>