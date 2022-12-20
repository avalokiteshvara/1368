<div class="row" style="margin-top: 20px">
   <div class="col-lg-12">
      <!-- /.panel -->
      <div class="panel panel-info">
         <div class="panel-heading">
            <div class="navbar-header">
               <b class="navbar-brand"><i class="fa fa-th-large"> </i> &nbsp; <?php echo $page_title;?></b>
               <ul class="nav navbar-nav">
                  <li><a data-original-title="" href="<?php echo base_url() . 'barang/stok_opname/add'?>" class="btn-info"><i class="fa fa-plus fa-fw"> </i> Tambah Data</a></li>
               </ul>
            </div>
            
            <div class="navbar-collapse collapse navbar-inverse-collapse" >
               <ul class="nav navbar-nav navbar-right">
                  <form class="navbar-form" method="post" action="<?php echo base_url() . 'barang/stok_opname/cari';?>">
                     <input type="text" class="form-control" name="cari" style="width: 200px" value="<?php echo $this->session->userdata('cari');?>" placeholder="Kata kunci pencarian ..." required>
                     <button type="submit" class="btn btn-info"><i class="fa fa-search fa-fw"> </i> Cari</button>
                     <a href="<?php echo base_url() . 'barang/stok_opname/clear_search'?>"><button type="button" class="btn btn-info"><i class="fa fa-times fa-fw"> </i> Clear</button></a>
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
                              <!--
                              $this->db->select('a.stok_lama,a.stok_baru,a.keterangan,a.updated_at,
                              b.nama_lengkap,
                              c.kode_bahan,c.deskripsi,
                              d.nama as satuan');
                              -->
                              <th>Kode Bahan</th>
                              <th>Deskripsi</th>
                              <th>Satuan</th>                                                         
                              <th>Stok Lama</th>
                              <th>Stok Baru</th>
                              <th>Keterangan</th>
                              <th>Update</th>                               
                           </tr>
                        </thead>
                        <tbody>
                           <?php if($data->num_rows() == 0){ ?>
                             <tr>
                               <td colspan="7" style="text-align: center; font-weight: bold">
                                 <div class="alert alert-danger" style="margin-bottom: 0px">Data tidak ditemukan</div>
                               </td>
                             </tr>
                           <?php }else{ 
                             foreach($data->result() as $r){ ?>                          
                             <tr>
                                <td><?php echo $r->kode_bahan;?></td>
                                <td><?php echo $r->deskripsi;?></td>
                                <td><?php echo $r->satuan;?></td>
                                <td><?php echo $r->stok_lama;?></td>
                                <td><?php echo $r->stok_baru;?></td>
                                <td><?php echo $r->keterangan;?></td>
                                <td><?php echo $r->updated_at;?></td>
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
