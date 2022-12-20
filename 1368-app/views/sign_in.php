<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>Silahkan Login</title>
      <link rel='stylesheet' href='<?php echo base_url() . 'assets/login/'?>jquery-ui.css'>
      <link rel="stylesheet" href='<?php echo base_url() . 'assets/login/'?>style.css' media="screen" type="text/css" />
	  <link rel="stylesheet" href='<?php echo base_url() . 'assets/login/'?>jshake-1.1.min.css' type="text/css" />
	  <script src='<?php echo base_url() . 'assets/login/'?>jquery_and_jqueryui.js'></script>
	  <script src='<?php echo base_url() . 'assets/login/'?>jshake-1.1.min.js'></script>
	  <script>
		<?php if(isset($msg)){ ?>
		$(document).ready(function(){
			$('#login').jshake();
		});
		<?php } ?>
	  </script>
   </head>
   <body  style="padding-top: 100px" id="login">
      <div class="login-card">		
         <h1>[ LOGIN ]</h1>
         <br>
         <form method="POST" action="" >            
			<input type="text" name="username" placeholder="Username">
            <input type="password" name="userpass" placeholder="Password">
            <input type="submit" name="login" class="login login-submit" value="login">			
         </form>
      </div>
   </body>
</html>