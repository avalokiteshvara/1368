<?php
   
   $mode = $this->uri->segment(3);
   
   if($mode === 'edt' || $mode === 'edt_act'){
      
      $id = $data->id;      
      $kode_bahan = $mode === 'edt' ? $data->kode_bahan : set_value('kode_bahan');      
      $id_satuan = $mode === 'edt' ? $data->id_satuan : set_value('id_satuan');      
      $deskripsi = $mode === 'edt' ? $data->deskripsi : set_value('deskripsi');
      
      $act = 'edt_act/' . $id;
      
   }else{
      
      $kode_bahan= $mode === 'add' ? '' : set_value('kode_bahan');      
      $id_satuan = $mode === 'add' ? '' : set_value('id_satuan');      
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
               <form action="<?php echo base_url() . 'data/bahan_mentah/' . $act;?>" method="post" accept-charset="utf-8" autocomplete="off">
                  <div class="col-lg-6">
                     <table  class="table-form">
                        <tr>
                           <td>Kode Bahan</td>
                           <td><input type="text" name="kode_bahan" required value="<?php echo $kode_bahan;?>" id="kode_bahan" class="form-control col-lg-8" tabindex="2" autofocus></td>
                        </tr>
                        <tr>
                           <td>Satuan</td>
                           <td>
                              <select name="id_satuan" style="width: 67%">
                              <?php foreach($satuan->result() as $s){ ?>
                                 <option <?php echo $s->id == $id_satuan ? 'selected':'';?> value="<?php echo $s->id;?>"><?php echo $s->nama;?></option>
                              <?php }?>
                              </select>
                           </td>
                        </tr>
                        <tr>
                           <td>Deskrispi</td>
                           <td><input type="text" name="deskripsi" required value="<?php echo $deskripsi;?>" id="deskripsi" class="form-control col-lg-8" tabindex="2" autofocus></td>
                        </tr>
                     </table>
                  </div>
                  <div class="col-lg-12" style="margin-left: 255px;margin-top: 20px">
                     <a href="<?php echo base_url() . 'data/bahan_mentah'?>" class="btn btn-success" tabindex="11"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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