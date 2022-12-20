<?php
   
   $mode = $this->uri->segment(3);
   
   if($mode === 'edt' || $mode === 'edt_act'){
      
      $id = $data->id;      
      $nama = $mode === 'edt' ? $data->nama : set_value('nama');      
      $kantor = $mode === 'edt' ? $data->kantor : set_value('kantor');      
      $gudang = $mode === 'edt' ? $data->gudang : set_value('gudang');
      $cp_nama = $mode === 'edt' ? $data->cp_nama : set_value('cp_nama');
      $cp_telp = $mode === 'edt' ? $data->cp_telp : set_value('cp_telp');
      $cp_email = $mode === 'edt' ? $data->cp_email : set_value('cp_email');
      $cp_jabatan = $mode === 'edt' ? $data->cp_jabatan : set_value('cp_jabatan');
      
      $act = 'edt_act/' . $id;
   }else{
      
      $nama = $mode === 'add' ? '': set_value('nama');      
      $kantor = $mode === 'add' ? '' : set_value('kantor');      
      $gudang = $mode === 'add' ? '' : set_value('gudang');
      $cp_nama = $mode === 'add' ? '' : set_value('cp_nama');
      $cp_telp = $mode === 'add' ? '' : set_value('cp_telp');
      $cp_email = $mode === 'add' ? '' : set_value('cp_email');
      $cp_jabatan = $mode === 'add' ? '' : set_value('cp_jabatan');
     
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
               <form action="<?php echo base_url() . 'data/konsumen/' . $act;?>" method="post" accept-charset="utf-8" autocomplete="off">
                  <div class="col-lg-6">
                     <table  class="table-form">
                        <tr>
                           <td>Nama</td>
                           <td><input type="text" name="nama" required value="<?php echo $nama;?>" id="nama" class="form-control col-lg-8" tabindex="2" autofocus></td>
                        </tr>
                        <tr>
                           <td>Alamat Kantor</td>
                           <td><textarea name="kantor" required id="kantor" class="form-control col-lg-8" tabindex="1"><?php echo $kantor;?></textarea></td>
                        </tr>
                        <tr>
                           <td>Alamat Gudang</td>
                           <td><textarea name="gudang" required id="gudang" class="form-control col-lg-8" tabindex="2"><?php echo $gudang;?></textarea></td>
                        </tr>
                        <tr>
                           <td width="25%">CP Nama</td>                           
                           <td><input type="text" name="cp_nama" value="<?php echo $cp_nama;?>" id="cp_nama" class="form-control col-lg-8" tabindex="2" autofocus></td>                           
                        </tr>
                        <tr>
                           <td width="25%">CP Email</td>                           
                           <td><input type="text" name="cp_email" value="<?php echo $cp_email;?>" id="cp_email" class="form-control col-lg-8" tabindex="2" autofocus></td>                           
                        </tr>  
                        <tr>
                           <td width="25%">CP Telp</td>                           
                           <td><input type="text" name="cp_telp" value="<?php echo $cp_telp;?>" id="cp_telp" class="form-control col-lg-8" tabindex="2" autofocus></td>                           
                        </tr>
                        <tr>
                           <td width="25%">CP Jabatan</td>                           
                           <td><input type="text" name="cp_jabatan" value="<?php echo $cp_jabatan;?>" id="cp_jabatan" class="form-control col-lg-8" tabindex="2" autofocus></td>                           
                        </tr>
                        <tr>
                           <td colspan="2">
                           </td>
                        </tr>
                     </table>
                  </div>
                  <div class="col-lg-12" style="margin-left: 252px;margin-top: 20px">
                     <a href="<?php echo base_url() . 'data/konsumen'?>" class="btn btn-success" tabindex="11"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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