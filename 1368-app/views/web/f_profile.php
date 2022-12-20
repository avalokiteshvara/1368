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
               <form action="<?php echo base_url() . 'web/profile/edt_act';?>" method="post" accept-charset="utf-8" autocomplete="off">
                  <div class="col-lg-6">
                     <table  class="table-form">
                        <tr>
                           <td>Nama Lengkap</td>
                           <td><input type="text" name="nama_lengkap" required value="<?php echo $profile->nama_lengkap;?>" id="nama_lengkap" class="form-control col-lg-8" tabindex="2" autofocus></td>
                        </tr>
                        <tr>
                           <td>User Name</td>
                           <td><input type="text" name="username" readonly value="<?php echo $profile->username;?>" id="username" class="form-control col-lg-8" tabindex="1"></td>
                        </tr>
                        <tr>
                           <td>Email</td>
                           <td><input type="text" name="email" required value="<?php echo $profile->email;?>" id="email" class="form-control col-lg-8" tabindex="2"></td>
                        </tr>
                        <tr>
                           <td>Telp</td>
                           <td><input type="text" name="telp" value="<?php echo $profile->telp;?>" id="telp" class="form-control col-lg-8" tabindex="2"></td>
                        </tr>
                        <tr>
                           <td colspan="2">
                           </td>
                        </tr>
                     </table>
                  </div>
                  <div class="col-lg-12" style="margin-left: 380px;margin-top: 20px">
                     <!--<a href="<?php echo base_url() . 'data/user'?>" class="btn btn-success" tabindex="11"><i class="fa fa-arrow-circle-left"></i> Kembali</a>-->
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