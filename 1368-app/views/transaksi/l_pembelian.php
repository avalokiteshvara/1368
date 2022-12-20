<?php $otorisasi_trans = $this->session->userdata('otorisasi_trans');?>

<div class="row" style="margin-top: 20px">
   <div class="col-lg-12">
      <!-- /.panel -->
      <div class="panel panel-info">
         <div class="panel-heading">
            <div class="navbar-header">
               <b class="navbar-brand"><i class="fa fa-th-large"> </i> &nbsp; <?php echo $page_title;?></b>
               <ul class="nav navbar-nav">
                  <li><a data-original-title="" href="<?php echo base_url() . 'transaksi/pembelian/add'?>" class="btn-info"><i class="fa fa-plus fa-fw"> </i> Tambah Data</a></li>
               </ul>
            </div>
            
            <div class="navbar-collapse collapse navbar-inverse-collapse" >
               <ul class="nav navbar-nav navbar-right">
                  <form class="navbar-form" method="post" action="<?php echo base_url() . 'transaksi/pembelian/cari';?>">
                     <input type="text" class="form-control" name="cari" style="width: 200px" value="<?php echo $this->session->userdata('cari');?>" placeholder="Kata kunci pencarian ..." required>
                     <button type="submit" class="btn btn-info"><i class="fa fa-search fa-fw"> </i> Cari</button>
                     <a href="<?php echo base_url() . 'transaksi/pembelian/clear_search'?>"><button type="button" class="btn btn-info"><i class="fa fa-times fa-fw"> </i> Clear</button></a>
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
                              <th>Tanggal Order</th>
                              <th>Kode Pembelian</th>
                              <th>Supplier</th>                                                         
                              <th>Nilai Transaksi</th>
                              <th>Status</th>
                              <th width="25%">Aksi</th>
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
                                <td><?php echo $r->tgl_pembelian;?></td>
                                <td><?php echo $r->kode_pembelian;?></td>
                                <td>
                                    <b><?php echo $r->supplier;?></b>                 
                                </td>                                                             
                                <td>
                                    <?php echo formatRupiah($r->besar_trans);?>
                                </td>
                                <td style="text-align: left">
                                    <?php if($r->status === 'disetujui'){ ?>
                                    <span class="label label-success">Approved</span><br>
                                    Kode Brg Masuk : <span class="label label-success"><?php echo $r->kode_masuk;?></span><br>
                                    Tgl Brg Masuk : <span class="label label-warning"><?php echo $r->tgl_masuk;?></span>

                                    <?php }elseif($r->status === 'ditolak'){ ?>
                                    <span class="label label-danger">Rejected</span>
                                    <?php }else{ ?>
                                    <span class="label label-default">Pending</span>
                                    <?php } ?>                                    
                                 </td>
                                                           
                                <td class="ctr">
                                   <div class="btn-group">                                      
                                      <?php if($r->status === 'pending' && $otorisasi_trans === 'Y'){ ?>
                                      <a style="margin-right: 10px" href="#" onclick="setstatus(<?php echo $r->id . ',\'disetujui\''?>)" class="btn btn-info btn-sm"><i class="fa fa-check">  </i> Approved</a>                                      
                                      <a style="margin-right: 10px" href="#" onclick="setstatus(<?php echo $r->id . ',\'ditolak\''?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash">  </i> Rejected</a>                                       
                                      <a style="margin-right: 10px" href="<?php echo base_url() . 'transaksi/pembelian/edt/' . $r->id;?>" class="btn btn-success btn-sm"><i class="fa fa-edit">  </i> <?php echo $r->status === 'pending' ? 'Edit' : 'Lihat' ?></a>
                                      <?php }else{ ?>
                                      <a style="margin-right: 10px" href="<?php echo base_url() . 'transaksi/pembelian/edt/' . $r->id;?>" class="btn btn-success btn-sm"><i class="fa fa-eye">  </i> <?php echo $r->status === 'pending' ? 'Edit' : 'Lihat' ?></a>                                      
                                          <?php if($r->status === 'disetujui'){ ?>
                                          <a style="margin-right: 10px" href="<?php echo base_url() . 'transaksi/pembelian/printdoc/' . $r->id;?>" target="_BLANK" class="btn btn-success btn-sm"><i class="fa fa-print">  </i> Cetak Dokument</a>                                      
                                          <?php } ?>
                                      <?php } ?>
                                      
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

<script>
   
   function setstatus(id,v_status) {
      
      $.post( "<?php echo base_url() . 'transaksi/pembelian/set-status/';?>" + id,
             { status: v_status }
      ).done(function( data ) {
         location.reload();
      });;
      
   }
   
</script>

