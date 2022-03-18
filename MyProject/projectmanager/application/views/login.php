<!DOCTYPE html>
<html lang="en">
	<head>
		<?= $this->load->view('head'); ?>
	</head>
	
		<style>
		.blink {
		  animation: blink-animation 1s steps(5, start) infinite;
		  -webkit-animation: blink-animation 1s steps(5, start) infinite;
		}
		@keyframes blink-animation {
		  to {
			visibility: hidden;
		  }
		}
		@-webkit-keyframes blink-animation {
		  to {
			visibility: hidden;
		  }
		}
		</style>
	
	<body >
		<div class="login-box">
			<div class="row">
				<div class="login-box-body">
					<div class="login-panel panel panel-default" style="margin-bottom:5px">
						<div class="panel-heading">
							<h3 class="panel-title" align="center">E-Office v3.0</h3>
						</div>
						<div class="panel-body">
							<?php echo validation_errors(); ?>
							<?php echo form_open('login_validation'); ?>
                            <fieldset>
                                <div class="form-group " align="center">
									<img width="200" height="" src="<?= base_url()?>assets/img/logos.png"  alt=""/><br>
                                    <? echo $alert; ?>
                                </div>
                                <div class="form-group">
									<input type="hidden" value="<?=isset($url)?$url:'';?>" name="url">
                                    <input class="form-control" placeholder="Username" name="username" type="username" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <input type="submit" value="Login" class="btn btn-lg btn-info btn-block">
                            </fieldset>
							<?php echo form_close(); ?>
							<div class="web-description"><br>
								
								<h5 align="center">Copyright &copy; 2022 DIVISI IT PERUM DAMRI</h5>
							</div>
						</div>
                    </div>
					
                </div>
            </div>
        </div>
		<?= $this->load->view('basic_js'); ?>
	</body>
</html>
