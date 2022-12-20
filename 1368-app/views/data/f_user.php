<style type="text/css">
  .col-lg-2 {
    width: 11%;
  }  
</style>

<?php
   
   $mode = $this->uri->segment(3);
   
   if($mode === 'edt' || $mode === 'edt_act'){
      
      $id = $data->id;      
      $username = $mode === 'edt' ? $data->username : set_value('username');      
      $nama_lengkap = $mode === 'edt' ? $data->nama_lengkap : set_value('nama_lengkap');      
      $email = $mode === 'edt' ? $data->email : set_value('email');
      $telp = $mode === 'edt' ? $data->telp : set_value('telp');
      $level = $mode === 'edt' ? $data->level : set_value('level');
      $akses_menu = $mode === 'edt' ? $data->akses_menu : set_value('akses_menu');
      $otorisasi_trans = $mode === 'edt' ? $data->otorisasi_trans : set_value('otorisasi_trans');

      $act = 'edt_act/' . $id;
   }else{
      
      $username = $mode === 'add' ? '' : set_value('username');
      $nama_lengkap = $mode === 'add' ? '' : set_value('nama_lengkap');     
      $email = $mode === 'add' ? '' : set_value('email');
      $telp = $mode === 'add' ? '' : set_value('telp');
      $level = $mode === 'add' ? '' : set_value('level');
      $akses_menu = $mode === 'add' ? '' : set_value('akses_menu');
      $otorisasi_trans = $mode === 'add' ? '' : set_value('otorisasi_trans');

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
               <form id="user-form" action="<?php echo base_url() . 'data/user/' . $act;?>" method="post" accept-charset="utf-8" autocomplete="off">
                  <div class="col-lg-12">
                     <table  class="table-form">
                        <tr>
                           <td width="10%">Level</td>
                           <td>
                              <select name="level" style="width:25%" id="level">
                                 <option <?php echo $level === 'marketing' ? 'selected' : '';?> value='marketing'>Marketing</option>
                                 <option <?php echo $level === 'manager' ? 'selected' : '';?> value='manager'>Manager</option>
                                 <option <?php echo $level === 'bahanbaku' ? 'selected' : '';?> value='bahanbaku'>Bahan Baku</option>
                                 <option <?php echo $level === 'packaging' ? 'selected' : '';?> value='packaging'>Packaging</option>
                                 <option <?php echo $level === 'produksi' ? 'selected' : '';?> value='produksi'>Produksi</option>
                                 <option <?php echo $level === 'custom' ? 'selected' : '';?> value="custom">Custom</option>
                              </select>
                           </td>
                        </tr>                        
                        <tr>
                          <td></td>
                          <td>
                             <div id="tree" style="display:none">
                                <input type="hidden" id="akses_menu" name="akses_menu">                                
                                <div class="col-lg-3">
                                  <ul style="padding-left:0px">                
                                  <?php echo build_menu('build_hak_akses')?>
                                  </ul>
                                </div>
                              </div>                               
                          </td>
                        </tr>
                        <tr>
                          <td>Otorisasi Transaksi</td>
                          <td>
                            <select name="otorisasi_trans" style="width:25%" id="otorisasi_trans">
                                <option <?php echo $otorisasi_trans === 'Y' ? 'selected':'';?> value="Y">Ya</option>
                                <option <?php echo $otorisasi_trans === 'N' ? 'selected':'';?> value="N">Tidak</option>
                            </select>
                          </td>
                        </tr>  
                        <tr>
                           <td>Nama Lengkap</td>
                           <td><input type="text" name="nama_lengkap" required value="<?php echo $nama_lengkap;?>" id="nama_lengkap" class="form-control col-lg-3" tabindex="2" autofocus></td>
                        </tr>
                        <tr>
                           <td>User Name</td>
                           <td><input type="text" name="username" required value="<?php echo $username;?>" id="username" class="form-control col-lg-3" tabindex="2"></td>
                        </tr>
                        <tr>
                           <td>Email</td>
                           <td><input type="text" name="email" value="<?php echo $email;?>" id="email" class="form-control col-lg-3" tabindex="2"></td>
                        </tr>
                        <tr>
                           <td>Telp</td>
                           <td><input type="text" name="telp" value="<?php echo $telp;?>" id="telp" class="form-control col-lg-3" tabindex="2"></td>
                        </tr>
                        
                     </table>
                  </div>
                  <div class="col-lg-12" style="margin-left: 212px;margin-top: 20px">
                     <a href="<?php echo base_url() . 'data/user'?>" class="btn btn-success" tabindex="11"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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
   $('#tree div').tree({});

   function build_hak_akses(arr_hak_akses){
      
      hak_akses = arr_hak_akses.split(',');
           
      var i;
      for (i = 0; i < hak_akses.length; i++) {   
        $('#cb_' + hak_akses[i]).prop('checked', true);
      }
   }
   
   build_hak_akses("<?php echo $akses_menu;?>");
   
   <?php if($level === 'custom'){ ?>
   $('#tree').show(); 
   <?php } ?>
    
   $('#level').change(function(){
        var select_level = $('#level').val();
        
        if (select_level === 'custom') {
        $('#tree').show(); 
        }else{
         $('#tree').hide();
        }    
   });

   $("#user-form").submit(function(){
      //alert('test');

      var selected = [];
      $('input:checkbox:checked').each(function (i, obj) {
          selected.push($(this).attr('kode'));
      });
     
      $('#akses_menu').val(selected.join(","));

   }); 
</script>