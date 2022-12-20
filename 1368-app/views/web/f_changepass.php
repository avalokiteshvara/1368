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
               <form action="<?php echo base_url() . 'web/password/edt_act';?>" method="post" accept-charset="utf-8" autocomplete="off">
                  <div class="col-lg-6">
                     <table  class="table-form">
                        <tr>
                           <td>Password Lama</td>
                           <td><input type="password" name="old_pass" required id="old_pass" class="form-control col-lg-8" tabindex="2" autofocus></td>
                        </tr>
                        <tr>
                           <td>Password Baru</td>
                           <td><input type="password" name="new_pass" required id="new_pass" class="form-control col-lg-8" tabindex="2"></td>
                        </tr>
                        <tr>
                           <td>Ulangi</td>
                           <td><input type="password" name="repeat_pass" required id="repeat_pass" class="form-control col-lg-8" tabindex="2"></td>
                        </tr>
                        <tr>
                           <td colspan="2">
                           </td>
                        </tr>
                     </table>
                  </div>
                  <div class="col-lg-12" style="margin-left: 380px;margin-top: 20px">
                     <!--<a href="<?php echo base_url() . 'web/password'?>" class="btn btn-success" tabindex="11"><i class="fa fa-arrow-circle-left"></i> Kembali</a>-->
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