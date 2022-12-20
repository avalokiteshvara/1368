<?php
   
   $mode = $this->uri->segment(3);
   
   if($mode === 'edt' || $mode === 'edt_act'){
      
      $id = $data->id;      
      $id_bahan_mentah = $mode === 'edt' ? $data->id_bahan_mentah : set_value('id_bahan_mentah');  
      $stok_lama = $mode === 'edt' ? $data->stok_lama : set_value('stok_lama');
      $stok_baru = $mode === 'edt' ? $data->stok_baru : set_value('stok_baru');
      $keterangan = $mode === 'edt' ? $data->keterangan : set_value('keterangan');
      
      $act = 'edt_act/' . $id;
      
   }else{
      
      //dibuat_oleh
      $id_bahan_mentah = $mode === 'add' ? '' : set_value('id_bahan_mentah');  
      $stok_lama = $mode === 'add' ? '' : set_value('stok_lama');
      $stok_baru = $mode === 'add' ? '' : set_value('stok_baru');
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
               <form action="<?php echo base_url() . 'barang/stok_opname/' . $act;?>" method="post" accept-charset="utf-8" autocomplete="off">
                  <div class="col-lg-6">
                     <table  class="table-form">
                        <tr>
                           <td>Kode Bahan</td>
                           <td>
                              <select name="id_bahan_mentah" id="bahan" style="width: 66%" required>
                                <option value="">[ Pilih Bahan ]</option> 
                                <?php foreach($bahan_mentah->result() as $bahan){ ?>
                                <option <?php echo $id_bahan_mentah == $bahan->id ? 'selected': '';?> value="<?php echo $bahan->id?>"><?php echo $bahan->kode_bahan;?></option>
                                <?php } ?>
                              </select>
                           </td>
                        </tr>                        
                        <tr>
                           <td width="25%">Stok Lama</td>                           
                           <td><input type="text-number" name="stok_lama" value="<?php echo $stok_lama;?>" id="stok_lama" class="form-control col-lg-4" tabindex="2" autofocus readonly></td>                           
                        </tr>
                        <tr>
                           <td width="25%">Stok Baru</td>                           
                           <td><input type="text-number" name="stok_baru" value="<?php echo $stok_baru;?>" id="stok_baru" class="form-control col-lg-4" tabindex="2" autofocus required></td>                           
                        </tr>
                        <tr>
                           <td width="25%">Keterangan</td>                           
                           <td><textarea style="width: 66%" name="keterangan" id="keterangan" class="form-control col-lg-8" tabindex="2" required><?php echo $keterangan;?></textarea></td>                           
                        </tr>  
                        
                     </table>
                  </div>
                  <div class="col-lg-12" style="margin-left: 252px;margin-top: 20px">
                     <a href="<?php echo base_url() . 'barang/stok_opname'?>" class="btn btn-success" tabindex="11"><i class="fa fa-arrow-circle-left"></i> Kembali</a>                     
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

<script>
   
   $('#bahan').change(function () {
                         
      $.get("<?php echo base_URL(); ?>barang/stok_opname/get-last-stok/",
            {'id'         :  this.value},
            function(data){               
               $('#stok_lama').val(data.stok);               
            }
      );
   });
   
</script>