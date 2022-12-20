   <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
   <html>
      <head>
         <meta http-equiv="content-type" content="text/html; charset=utf-8">
         <title></title>
         <meta name="generator" content="LibreOffice 4.2.7.2 (Linux)">
         <meta name="author" content="trias ">
         <meta name="created" content="20150121;103108399363935">
         <meta name="changedby" content="trias ">
         <meta name="changed" content="20150121;110224326137647">
         <style type="text/css">
            body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font: 12pt "Tahoma";
            }
            * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            }
            .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }
            .subpage {
            padding: 1cm;
            border: 1px black solid;
            height: 257mm;
            }
            @page {
            size: A4;
            margin: 0;
            }
            @media print {
            html, body {
            width: 210mm;
            height: 297mm;        
            }
            .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
            }
            }
         </style>
      </head>
      <body lang="en-US" dir="ltr">
         <div class="book">
            <div class="page">
               <div class="subpage">
                  <table width="100%" cellpadding="4" cellspacing="0">
                     <col width="128*">
                     <col width="128*">
                     <tr valign="top">
                        <td width="50%" style="border: none; padding: 0in">
                           <p><b><?php echo $nama_perusahaan;?></b><br>
                              <font size="1" style="font-size: 7pt">
                              PO Box: <?php echo $po_box;?> <br>
                              Telp No : <?php echo $telp;?><br>
                              Fax No : <?php echo $fax;?><br>
                              Email: <?php echo $email;?>   
                              </font>
                           </p>
                        </td>
                        <td width="50%" style="border: none; padding: 0in">
                           <p><img src="<?php echo base_url() . 'assets/img/' . $logo_perusahaan;?>" class="" style="margin-left:100px; width: 100px; height: 100px"></p>
                        </td>
                     </tr>
                  </table>
                  <p style="margin-bottom: 0in; line-height: 100%"><br></p>
                  <table width="100%" cellpadding="4" cellspacing="0">
                     <col width="85*">
                     <col width="85*">
                     <col width="85*">
                     <tr valign="top">
                        <td width="33%" style="border: none; padding: 0in">
                           <p><font size="1" style="font-size: 8pt"><i>Dibeli dari</i></font></p>
                           <p style="font-style: normal">
                              <font size="2" style="font-size: 10pt"><b><?php echo $supplier->nama;?></b></font>	
                              <font size="1" style="font-size: 8pt"><br>
                              <?php echo nl2br($supplier->alamat);?>
                              </font>                            
                           </p>
                        </td>
                        <td width="33%" style="border: none; padding: 0in">
                           <p><font size="1" style="font-size: 8pt"><i>Dikirim ke</i></font></p>
                           <p style="font-style: normal">
                              <font size="2" style="font-size: 10pt"><b><?php echo $nama_perusahaan;?></b></font>
                              <font size="1" style="font-size: 8pt"><br>
                              <?php echo nl2br($alamat_pengiriman);?> 
                              </font>
                           </p>
                        </td>
                        <td width="33%" style="border: none; padding: 0in">
                           <p><b>ORDER PEMBELIAN</b></p>
                           <p style="font-weight: normal"><font size="1" style="font-size: 8pt">
                              Kode Order : <b><?php echo $kode_pembelian;?></b><br>
                              Tanggal    : <?php echo $tgl_order;?>  
                              </font>
                           </p>
                           
                           
                        </td>
                     </tr>
                  </table>
                  <p style="margin-bottom: 0in; line-height: 100%"><font size="1" style="font-size: 8pt">Kami
                     menyepakati dan mengkonfirmasi pembelian item dibawah ini</font> 
                  </p>
                  <table width="100%" cellpadding="4" cellspacing="0">
                     <col width="51*">
                     <col width="51*">
                     <col width="51*">
                     <col width="51*">
                     <col width="51*">
                     <tr valign="top">
                        <td width="20%" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                           <p align="center">
                              <font size="1" style="font-size: 8pt"><b>Kode Bahan</b></font>
                           </p>
                        </td>
                        <td width="20%" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                           <p align="center">
                              <font size="1" style="font-size: 8pt"><b>Deskripsi</b></font>
                           </p>
                        </td>
                        <td width="20%" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                           <p align="center">
                              <font size="1" style="font-size: 8pt"><b>Qty</b></font>
                           </p>
                        </td>
                        <td width="20%" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                           <p align="center">
                              <font size="1" style="font-size: 8pt"><b>Harga</b></font>
                           </p>
                        </td>
                        <td width="20%" style="border: 1px solid #000000; padding: 0.04in">
                           <p align="center">
                              <font size="1" style="font-size: 8pt"><b>Sub Total</b></font>
                           </p>
                        </td>
                     </tr>
                     <?php $harga_awal = 0;?>
                     <?php foreach($pembelian_details->result() as $pd){ ?>
                     <tr valign="top">
                        <td width="20%" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                           <p><font size="1" style="font-size: 8pt"><?php echo $pd->kode_bahan;?></font></p>
                        </td>
                        <td width="20%" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                           <p><font size="1" style="font-size: 8pt"><?php echo $pd->deskripsi;?></font></p>
                        </td>
                        <td width="20%" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                           <p><font size="1" style="font-size: 8pt"><?php echo $pd->kuantitas . ' ' . $pd->satuan;?></font></p>
                        </td>
                        <td width="20%" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                           <p><font size="1" style="font-size: 8pt"><?php echo formatRupiah($pd->harga_per_item);?></font></p>
                        </td>
                        <td width="20%" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
                           <p><font size="1" style="font-size: 8pt"><?php echo formatRupiah($pd->subtotal);?></font></p>
                        </td>
                        <?php $harga_awal += $pd->subtotal;?>
                     </tr>
                     <?php } ?>
                  </table>
                  <dl>
                     <dl>
                        <dl>
                           <dl>
                              <dl>
                                 <dl>
                                    <dl>
                                       <dl>
                                          <dl>
                                             <?php
                                                $awal_kirim = $harga_awal + $biaya_kirim;
                                                $nilai_diskon = $awal_kirim * ($diskon / 100);
                                                $setelah_diskon = $awal_kirim - $nilai_diskon;
                                                $nilai_pajak = $setelah_diskon * ($pajak / 100);
                                                ?>
                                             <table width="246" cellpadding="4" cellspacing="0">
                                                <col width="62">
                                                <col width="35">
                                                <col width="122">
                                                <tr valign="top">
                                                   <td width="62" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                                                      <p><font size="1" style="font-size: 8pt">TOTAL</font></p>
                                                   </td>
                                                   <td colspan="2" width="166" style="border: 1px solid #000000; padding: 0.04in">
                                                      <p><font size="1" style="font-size: 8pt"><?php echo formatRupiah($harga_awal);?></font></p>
                                                   </td>
                                                </tr>
                                                <tr valign="top">
                                                   <td width="62" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                                                      <p><font size="1" style="font-size: 8pt">Biaya Kirim</font></p>
                                                   </td>
                                                   <td colspan="2" width="166" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
                                                      <p><font size="1" style="font-size: 8pt"><?php echo formatRupiah($biaya_kirim);?></font></p>
                                                   </td>
                                                </tr>
                                                <tr valign="top">
                                                   <td width="62" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                                                      <p><font size="1" style="font-size: 8pt">Diskon</font></p>
                                                   </td>
                                                   <td width="35" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                                                      <p><font size="1" style="font-size: 8pt"><?php echo $diskon;?>%</font></p>
                                                   </td>
                                                   <td width="122" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
                                                      <font size="1" style="font-size: 8pt"><?php echo formatRupiah($nilai_diskon);?></font>
                                                   </td>
                                                </tr>
                                                <tr valign="top">
                                                   <td width="62" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                                                      <p><font size="1" style="font-size: 8pt">Pajak</font></p>
                                                   </td>
                                                   <td width="35" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                                                      <p><font size="1" style="font-size: 8pt"><?php echo $pajak;?>%</font></p>
                                                   </td>
                                                   <td width="122" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
                                                      <font size="1" style="font-size: 8pt">
                                                         <?php echo formatRupiah($nilai_pajak);?>
                                                      </font>   
                                                   </td>
                                                </tr>
                                                <tr valign="top">
                                                <td width="62" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                                                <p><font size="1" style="font-size: 8pt">Total Akhir</font></p>
                                                </td>
                                                <td colspan="2" width="166" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
                                                <p><b><font size="1" style="font-size: 8pt"><?php echo formatRupiah($besar_trans);?></font></b></p>
                                                </td>
                                                </tr>
                                             </table>
                                          </dl>
                                       </dl>
                                    </dl>
                                 </dl>
                              </dl>
                           </dl>
                        </dl>
                     </dl>
                  </dl>
                  
                  
                  <table width="396" cellpadding="4" cellspacing="0">
                     <col width="386">
                     <tr>
                        <td width="386" valign="top" style="border: 1px solid #000000; padding: 0.04in">
                           <p><font size="1" style="font-size: 8pt"><i>Term Pengiriman</i></font></p>
                           <p style="font-style: normal"><font size="2" style="font-size: 9pt">
                              <?php echo nl2br($term_pengiriman);?></font>
                           </p>
                        </td>
                     </tr>
                     <tr>
                        <td width="386" valign="top" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
                           <p><font size="1" style="font-size: 8pt"><i>Term Pembayaran</i></font></p>
                           <p style="font-style: normal"><font size="2" style="font-size: 9pt">Ini
                              <?php echo nl2br($term_pembayaran);?></font>
                           </p>
                        </td>
                     </tr>
                     <tr>
                        <td width="386" valign="top" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
                           <p><font size="1" style="font-size: 8pt"><i>Catatan Pembelian</i></font></p>
                           <p style="font-style: normal"><font size="2" style="font-size: 9pt"><?php echo nl2br($catatan);?></font></p>
                        </td>
                     </tr>
                  </table>


                  
               </div>
            </div>
         </div>
      </body>
   </html>

