<div class="position-relative">
	<div id="login-box" class="login-box visible widget-box no-border">
		<div class="widget-body">
			<div class="widget-main">
				<h4 class="header blue lighter bigger">
					<i class="ace-icon fa fa-coffee green"></i>
					<?= $subtitle ?>
				</h4>
                <?php echo '<label class="text-success" >'.$this->session->flashdata('update_password').'</label>';?>
				<div class="space-4"></div>

				<?php $this->load->view($module.'/'.$view_file)?>

				<div class="space-4"></div>
		
			</div><!-- /.widget-main -->

			<div class="toolbar clearfix">
				<?php if(isset($forgot_password) && $forgot_password == true) {
					// code...
				?>
				<div>
					<a href="<?php echo base_url().'auth_v2/reset_password'?>" class="forgot-password-link">
						<i class="ace-icon fa fa-arrow-left"></i>
						I forgot my password
					</a>
				</div>
				<?php
                }
				?>

				<div>
					<a href="<?php echo base_url().'auth_v2/'.$next_form?>" class="user-signup-link">
						I want to <?= $next_form?>
						<i class="ace-icon fa fa-arrow-right"></i>
					</a>
				</div>
			</div>
		</div><!-- /.widget-body -->
	</div><!-- /.login-box -->