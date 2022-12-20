<!DOCTYPE html>
<html>
<head>
<?php
	$base_js = base_url() . 'assets/js/';
	$base_css = base_url() . 'assets/css/';
	$base_fonts = base_url() . 'assets/fonts/';
	$base_library = base_url() . 'assets/library/';
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. 1368</title>
	
    <link href="<?php echo $base_css;?>bootstrap.css" rel="stylesheet">	
    <link href="<?php echo $base_library;?>font-awesome/css/font-awesome.css" rel="stylesheet">	
	<link href="<?php echo $base_css;?>toggle-switch.css" rel="stylesheet">
    <link href="<?php echo $base_css;?>sb-admin.css" rel="stylesheet">
    <link href="<?php echo $base_library;?>ui/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo $base_library;?>chosen_v1.3.0/chosen.css" rel="stylesheet">
	<link href="<?php echo $base_library;?>classy-edit/css/jquery.classyedit.css" rel="stylesheet">
	<link href="<?php echo $base_library;?>tree/jquery.tree.min.css" rel="stylesheet" />

	<script src="<?php echo $base_js;?>jquery-1.10.2.js"></script>
	<script src="<?php echo $base_library;?>ui/jquery-ui.js"></script>
	<script src="<?php echo $base_library;?>chosen_v1.3.0/chosen.jquery.js"></script>
	<script src="<?php echo $base_library;?>tree/jquery.tree.min.js"></script>
	<!--<script src="<?php echo $base_library;?>chosen/ajax-chosen.js"></script>-->
	<script src="<?php echo $base_js;?>jquery.chained.js"></script>
	<script src="<?php echo $base_js;?>bootstrap.min.js"></script>
	<script src="<?php echo $base_js;?>bootstrap-modal.js"></script>
	<script src="<?php echo $base_js;?>bootstrap-dropdown.js"></script>
	<script src="<?php echo $base_js;?>bootstrap-tooltip.js"></script>
	<!--<script src="<?php echo $base_library;?>bootstrap-wysiwyg/bootstrap-wysiwyg.js"></script>-->
    <script src="<?php echo $base_library;?>metisMenu/jquery.metisMenu.js"></script>
	<script src="<?php echo $base_library;?>jquery.autocomplete.min.js"></script>
	<script src="<?php echo $base_library;?>classy-edit/js/jquery.classyedit.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url();?>texteditor/tiny_mce/tiny_mce.js"></script>
    <script src="<?php echo $base_js;?>sb-admin.js"></script>
	
	<style>
		pre{
			font-family: "Open Sans";
			display: block;
			padding: 9.5px;
			margin: 0px 0px 0px;
			font-size: 14px;			
			color: #333;
			word-break: break-all;
			word-wrap: break-word;
			background-color: #FFFFFF;
			border: 0px solid #FFFFFF;
			border-radius: 4px;
		}
		
		.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
		.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
		.autocomplete-selected { background: #F0F0F0; }
		.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
		.autocomplete-group { padding: 2px 5px; }
		.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
	</style>
	
	<script type="text/javascript">
		
		
		function formatRupiah(angka){
			var rev     = parseInt(angka, 10).toString().split("").reverse().join("");
			var rev2    = "";
			for(var i = 0; i < rev.length; i++){
				rev2  += rev[i];
				if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
					rev2 += ".";
				}
			}
			return "Rp " + rev2.split("").reverse().join("");
		}
		
		$(document).ready(function () {
			$('a').tooltip('hide');
			$(function() {
				$( ".tag_tgl" ).datepicker({
					changeMonth: true,
					changeYear: true,
					dateFormat: 'yy-mm-dd'
				});
			});
			
			$('input[type=number],input[type=text-number]').keypress(function(event) {
				var charCode = (event.which) ? event.which : event.keyCode
				if ((charCode >= 48 && charCode <= 57)
					|| charCode == 46 || charCode == 44	|| charCode == 8)
					return true;
				return false;
			});
		});
		// ]]>
	</script>
	
	 <script type="text/javascript">
		//$('#editor').wysiwyg();		
		tinyMCE.init({
				mode : "exact",
				elements : "tinyMCE",
				theme : "advanced",
				plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
				
				theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,charmap,media,advhr,|,print,|,ltr,rtl",
				theme_advanced_buttons4 : "styleprops,|,cite,abbr,acronym,del,ins,attribs",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : false,
				height:300,
				width:500,
				
				//Mad File Manager				
				relative_urls : false,
				file_browser_callback : MadFileBrowser
				
		});
		
				
		function MadFileBrowser(field_name, url, type, win) {
			  tinyMCE.activeEditor.windowManager.open({
			      file : "<?php echo base_url();?>texteditor/mfm.php?field=" + field_name + "&url=" + url + "",
			      title : 'File Manager',
			      width : 640,
			      height : 450,
			      resizable : "no",
			      inline : "yes",
			      close_previous : "no"
			  }, {
			      window : win,
			      input : field_name
			  });
			  return false;
		}
		
	 </script>
</head>

<body style="overflow-x: hidden; overflow-y: auto;">
    <div id="wrapper">
		<div style="height: 150px; border-top: solid 5px #1E4A7A; background: url(http://localhost/persuratan/aset/img/back_3.png)">
			<div class="col-lg-2">
				<img src="<?php echo base_url()?>assets/img/luckyshrimp_logo.jpg" class="" style="margin: 10px 0 0 40px; width: 120px; height: 120px">
			</div>
			<div>
				<h2>PT. 1368 COLD STORAGE</h2>
				<h3 style="margin-top: 0px">Banyuwangi</h3>
				<h4>
					<b>Alamat : Jl.XXX</b>
				</h4>
			</div>
		</div>
		
        <nav class="navbar navbar-default navbar-static-top  sidebar-collapse" role="navigation" style="margin-bottom: 0; z-index: initial">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- /.navbar-header -->
			
            <ul class="nav navbar-top-links">				
				<li style="margin-left: 10px">
					<a href="<?php echo base_url() . 'web'?>" title="Home"><i class="fa fa-home" style="font-size: 20px"></i></a>
				</li>
				
				<?php echo build_menu();?>
				
				<li class="dropdown pull-right">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i><?php echo ucfirst($this->session->userdata('nama_lengkap'));?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                       <li><a tabindex="-1" href="<?php echo base_url()?>web/profile"><i class="fa fa-wrench"> </i> Profile</a></li>
					   <li><a tabindex="-1" href="<?php echo base_url()?>web/password"><i class="fa fa-wrench"> </i> Ubah Password</a></li>					   
                       <li><a tabindex="-1" href="<?php echo base_url()?>web/log_akses"><i class="fa fa-exchange"> </i> Log Akses</a></li>
					   <li><a tabindex="-1" href="<?php echo base_url()?>sign_out"><i class="fa fa-sign-out"> </i> Logout</a></li>					   
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
        </nav>
        <!-- /.navbar-static-top -->
		<?php
		    $page_name .= ".php";
			include $page_name;
		?>
	</div>

    
	<script type="text/javascript">
	<?php
		$userid = $this->session->userdata('userid');
		$pending_msg = $this->basecrud_m->get_where('tbl_pesan',array('id_penerima'=>$userid,
																	  'status'=>'pending',
																	  'terhapus_penerima'=>'N')
													);
		
		$total_msg = $this->basecrud_m->get_where('tbl_pesan',array('id_penerima'=>$userid,		
																	'terhapus_penerima'=>'N')
												 );
	?>	
	$(document).ready(function () {
		/* Modal */
	
	    var config = {
			'.chosen-select'           : {},
			'.chosen-select-deselect'  : {allow_single_deselect:true},
			'.chosen-select-no-single' : {disable_search_threshold:10},
			'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
			'.chosen-select-width'     : {width:"95%"}
		  }
		for (var selector in config) {
		  $(selector).chosen(config[selector]);
		}
		
		$('#menu_13').html('Pesan ( <?php echo $pending_msg->num_rows();?> )');
		$('#menu_14').html('Pesan Masuk ( <?php echo $pending_msg->num_rows() . ' / ' . $total_msg->num_rows();?> )');
		
		
		(function(){
		   var bsModal = null;
		   $("[data-toggle=modal]").click(function(e) {
			  e.preventDefault();
			  var trgId = $(this).attr('data-target'); 
			  if ( bsModal == null ) 
			   bsModal = $(trgId).modal;
			  $.fn.bsModal = bsModal;
			  $(trgId + " .modal-body").load($(this).attr("href"));
			  $(trgId).bsModal('show');
			});
		 })();
	});
	/* <![CDATA[ */	
	</script>	

</body>

</html>

