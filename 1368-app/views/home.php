        <div id="" style="margin-top: 40px">
			<div class="row col-lg-12">
				<div class="col-lg-12">
                    <?php if(isset($include_back)){ ?>
                    <div class="col-lg-2" style="text-align: center;">
						<a href="<?php echo base_url() . 'web';?>" class="thumbnail">
							<i class="fa fa-angle-double-left" style="font-size: 80px; margin: 10px 0"></i><br>
							<h4 class="">Kembali</h4>
						</a>
					</div>
                    <?php } ?>
					<?php foreach($menu_bawah->result() as $mn){ ?>
					<div class="col-lg-2" style="text-align: center;">
						<a href="<?php echo base_url() . $mn->url_bawah;?>" class="thumbnail" title="Klik disini melihat data <?php echo $mn->nama;?>">
							<i class="fa <?php echo $mn->icon;?>" style="font-size: 80px; margin: 10px 0"></i><br>
							<h4 class=""><?php echo $mn->nama;?></h4>
						</a>
					</div>
					<?php } ?>		
				</div>
					<!-- /.panel-body -->
			</div>
			<!-- /.panel -->		
		</div>
