<div class="row" style="margin-top: 20px">
   <div class="col-lg-12">
      <!-- /.panel -->
      <div class="panel panel-info">
         <div class="panel-heading" style="padding-bottom:20px">
            <div class="navbar-header">
               <b class="navbar-brand"><i class="fa fa-th-large"> </i> &nbsp; <?php echo $page_title;?></b>               
            </div>
            
            <div class="navbar-collapse collapse navbar-inverse-collapse" >
                <ul class="nav navbar-nav navbar-right">
                  
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
                              <!--'a.id,a.kode_bahan,a.deskripsi,a.updated_at,IFNULL(b.stok,0) as stok,c.nama as satuan'-->
                              
                              <th>Kode Bahan</th>
                              <th>Deskripsi</th>
                              <th>Satuan</th>                                                         
                              <th>Stok</th>
                              <th>Update</th>                               
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
                                <td><?php echo $r->kode_bahan;?></td>
                                <td><?php echo $r->deskripsi;?></td>
                                <td><?php echo $r->satuan;?></td>
                                <td><?php echo $r->stok;?></td>
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
