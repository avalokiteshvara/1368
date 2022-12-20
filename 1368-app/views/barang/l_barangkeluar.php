<div class="row" style="margin-top: 20px">
   <div class="col-lg-12">
      <!-- /.panel -->
      <div class="panel panel-info">
         <div class="panel-heading">
            <div class="navbar-header">
               <b class="navbar-brand"><i class="fa fa-th-large"> </i> &nbsp; <?php echo $page_title;?></b>
               <ul class="nav navbar-nav">
                  <li><a data-original-title="" href="<?php echo base_url() . 'barang/keluar/add'?>" class="btn-info"><i class="fa fa-plus fa-fw"> </i> Tambah Data</a></li>
               </ul>
            </div>
            
            <div class="navbar-collapse collapse navbar-inverse-collapse" >
               <ul class="nav navbar-nav navbar-right">
                  <form class="navbar-form" method="post" action="<?php echo base_url() . 'barang/keluar/cari';?>">
                     <input type="text" class="form-control" name="cari" style="width: 200px" value="<?php echo $this->session->userdata('cari');?>" placeholder="Kata kunci pencarian ..." required>
                     <button type="submit" class="btn btn-info"><i class="fa fa-search fa-fw"> </i> Cari</button>
                     <a href="<?php echo base_url() . 'barang/keluar/clear_search'?>"><button type="button" class="btn btn-info"><i class="fa fa-times fa-fw"> </i> Clear</button></a>
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
                     <table class="table table-bordered">
                        <thead>
                           <tr>
                              <th>Tanggal Keluar</th>
                              <th>Kode Penjualan</th>
                              <th>Pemeriksa</th>                                                         
                              <th>Keterangan</th>                              
                              <th width="21%">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if($data->num_rows() == 0){ ?>
                             <tr>
                               <td colspan="5" style="text-align: center; font-weight: bold">
                                 <div class="alert alert-danger" style="margin-bottom: 0px">Data tidak ditemukan</div>
                               </td>
                             </tr>
                           <?php }else{ 
                             foreach($data->result() as $r){ ?>                          
                             <tr>
                                <td><?php echo $r->tgl_keluar;?></td>
                                <td><?php echo $r->kode_penjualan;?></td>
                                <td><?php echo $r->pemeriksa;?></td>                                                             
                                <td><?php echo $r->keterangan;?></td>
                                                           
                                <td class="ctr">
                                   <div class="btn-group">                                      
                                      <a style="margin-right: 10px" href="<?php echo base_url() . 'barang/keluar/edt/' . $r->id;?>" class="btn btn-success btn-sm"><i class="fa fa-edit">  </i> Edit</a>                                      
                                      <a style="margin-right: 10px" href="<?php echo base_url() . 'barang/keluar/del/' . $r->id;?>" class="btn btn-danger btn-sm" title="" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash">  </i> Hapus</a>
                                   </div>
                                </td>
                             </tr>                             
                           <?php }
                           } ?>
                        </tbody>
                     </table>
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
