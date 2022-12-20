<?php
  
  $mode = $this->uri->segment(3);
  
  if($mode === 'reply' || $mode === 'reply_act'){

    $id_pengirim = $this->session->userdata('userid'); 
    $id_penerima = $mode === 'reply' ? $data->id_pengirim : set_value('id_pengirim');
    $subyek = $mode === 'reply' ? 'Re: ' . $data->subyek : set_value('subyek');
    $nama_penerima = $this->basecrud_m->get_where('tbl_user',array('id'=>$id_penerima))->row()->nama_lengkap;
    $isi = $mode === 'reply' ? '<br><br><br>'.
                               '--------[Balas diatas tanda ini--------------<br>' . 
                               '<span style="text-decoration: underline;"><em>' . $nama_penerima . ' Menulis:</em></span><br>' .  
                               $data->isi .
                               '--------------------------------------------'  
                               : set_value('isi') ;

     $act = 'add_act';     
  }else{

    $id_pengirim = $this->session->userdata('userid'); 
    $id_penerima = set_value('id_penerima');
    $subyek = set_value('subyek');
    $isi = set_value('isi');
  
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
               <form action="<?php echo base_url() . 'pesan/keluar/' . $act;?>" method="post" accept-charset="utf-8" autocomplete="off">
                  <input type="hidden" name="id_pengirim" value="<?php echo $id_pengirim;?>">
                  <div class="col-lg-6">
                     <table  class="table-form">
                        
                        <tr>
                           <td>Kepada</td>
                           <td>
                              <select class="form-control" name="id_penerima" style="width: 50%" required>
                                <option value="">Pilih Penerima</option>
                                <?php foreach($penerima->result() as $penerima){ ?>
                                <option <?php echo $penerima->id === $id_penerima ? 'selected':'';?> value="<?php echo $penerima->id;?>"><?php echo ucfirst($penerima->nama_lengkap);?></option>
                                <?php } ?>
                              </select>                              
                           </td>
                        </tr>
                        <tr>
                           <td>Subyek</td>
                           <td><input class="form-control col-lg-8" style="width: 570px" type="text" name="subyek" value="<?php echo $subyek;?>" required></td>
                        </tr>

                        <tr>
                           <td>Pesan</td>
                           <td><textarea id="tinyMCE" name="isi"><?php echo $isi;?></textarea></td>
                        </tr>
                     </table>
                  </div>
                  <div class="col-lg-12" style="margin-left: 465px;margin-top: 20px">
                     <a href="<?php echo base_url() . 'pesan/keluar'?>" class="btn btn-success" tabindex="11"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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