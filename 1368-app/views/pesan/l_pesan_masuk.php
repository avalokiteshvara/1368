<div class="row" style="margin-top: 20px">
   <div class="col-lg-12">
      <!-- /.panel -->
      <div class="panel panel-info">
         <div class="panel-heading">
            <div class="navbar-header">
               <b class="navbar-brand"><i class="fa fa-th-large"> </i> &nbsp; <?php echo $page_title;?></b>
            </div>
            <div class="navbar-collapse collapse navbar-inverse-collapse" >
               <ul class="nav navbar-nav navbar-right">
                  <form class="navbar-form" method="post" action="<?php echo base_url() . 'pesan/masuk/cari';?>">
                     <input type="text" class="form-control" name="cari" style="width: 200px" value="<?php echo $this->session->userdata('cari');?>" placeholder="Kata kunci pencarian ..." required>
                     <button type="submit" class="btn btn-info"><i class="fa fa-search fa-fw"> </i> Cari</button>
                     <a href="<?php echo base_url() . 'pesan/masuk/clear_search'?>"><button type="button" class="btn btn-info"><i class="fa fa-times fa-fw"> </i> Clear</button></a>
                  </form>
               </ul>
            </div>
            <!-- /.nav-collapse -->
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">
            <div class="row">
               <div class="col-lg-12">
                  <div class="table-responsive">
                     <table class="table table-bordered table-hover">
                        <thead>
                           <tr>
                              <th style="width: 15%">Tanggal</th>
                              <th style="width: 15%">Pengirim</th>
                              <!--<th>Status</th>-->
                              <th>Subyek</th>     
                              <th>Isi</th>                           
                              <th style="width: 250px">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if($data->num_rows() == 0){ ?>
                             <tr>
                               <td colspan="7" style="text-align: center; font-weight: bold">
                                 <div class="alert alert-danger" style="margin-bottom: 0px">Data tidak ditemukan</div>
                               </td>
                             </tr>
                           <?php }else{ ?>
                             <?php foreach($data->result() as $r){ ?>
                             <tr <?php echo $r->status === 'pending' ? 'style="font-weight: bolder" class="danger"': '' ?>>
                                <td class="ctr"><?php echo $r->tgl_kirim;?></td>
                                <td><?php echo $r->pengirim;?></td>
                                <!--<td><?php echo $r->status;?></td>                           -->
                                <td><?php echo $r->subyek;?></td> 
                                <td><?php echo strlen($r->isi) >= 300 ? substr($r->isi,0,300) . ' ...' : $r->isi;?></td>                             
                                <td class="ctr">
                                   <div class="btn-group">
                                      <a style="margin-right: 10px" href="#baca-pesan" data-toggle="modal" onclick="return read(<?php echo $r->id;?>);" class="btn btn-warning btn-sm"><i class="fa fa-edit">  </i> Baca</a>
                                      <a style="margin-right: 10px" href="<?php echo base_url() . 'pesan/masuk/reply/' . $r->id;?>" class="btn btn-warning btn-sm"><i class="fa fa-mail-reply">  </i> Balas</a>
                                      <a style="margin-right: 10px" href="<?php echo base_url() . 'pesan/masuk/del/' . $r->id;?>" class="btn btn-danger btn-sm" title="" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash">  </i> Hapus</a>
                                   </div>
                                </td>
                             </tr>
                             <?php } ?>
                           <?php } ?>
                        </tbody>
                     </table>
                     <!--<div style="background-color: #EBCCCC;width: 160px">Status : Terbaca</div>-->
                     <center>
                        <ul class="pagination">
                          <?php echo $this->pagination->create_links();?> 
                        </ul>
                     </center>
                  </div>
                  <!-- /.table-responsive -->
               </div>
            </div>
         </div>
         <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
   </div>
</div>

<!-- MODAL BACA PESAN -->
<div class="modal col-lg-12 fade" id="baca-pesan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content" style="width: 650px">         
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               <h4 class="modal-title" id="myModalLabel">Pesan Details</h4>
            </div>
            <div class="modal-body">
               <table width="100%" class="table-form" align="center">                  
                  <tr>
                     <td width="20%">Pengirim</td>
                     <td><input type="text" id="pengirim" class="form-control col-lg-12"></td>
                  </tr>
                  <tr>
                     <td width="20%">Penerima</td>
                     <td><input type="text" id="penerima" class="form-control col-lg-12"></td>
                  </tr>
                  <tr>
                     <td width="20%">Subyek</td>
                     <td><input type="text" id="subyek" class="form-control col-lg-12"></td>
                  </tr>
                  <!--<tr>-->
                  <!--   <td width="20%">Status</td>-->
                  <!--   <td><input type="text" id="status" class="form-control col-lg-12"></td>-->
                  <!--</tr>-->
                  <tr>
                     <td width="20%">Isi Pesan</td>
                     <td>
                        <textarea class="classy-editor" class="form-control col-lg-12">
                           
                        </textarea>
                     </td>
                  </tr>

               </table>
            </div>
            <div class="modal-footer">         
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
      </div>
   </div>
</div>


<script type="text/javascript">
                                          
   $('#baca-pesan').on('hidden.bs.modal', function () {
      location.reload();
   })
   
   function read(id_pesan)
   {  
      $.get("<?php echo base_URL(); ?>pesan/masuk/read/" + id_pesan,
            function(data,status)
            {               
               $('#pengirim').val(data.pengirim);
               $('#penerima').val(data.penerima);               
               $('#subyek').val(data.subyek);
               $('.classy-editor').replaceWith('<textarea class="classy-editor" class="form-control col-lg-12">' + data.isi + '</textarea>')
               $(".classy-editor").ClassyEdit();
            }
      );
   }
</script>
