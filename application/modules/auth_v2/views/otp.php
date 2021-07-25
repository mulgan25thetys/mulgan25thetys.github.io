<p> Enter the code that you receive by Email: </p>

<?php echo '<label class="text-danger">'.$this->session->flashdata('error').'</label>';?>
<?php echo '<label class="text-success">'.$this->session->flashdata('email_sent').'</label>';?>

<?php 
 $attributs = array(
	'id' => 'form_otp'
 );
 echo form_open('auth_v2/submit_validate', '', $attributs);
?>
	<fieldset>
		<label class="block clearfix">
			<span class="text-danger"><?php echo form_error('code_otp')?></span>
			<span class="block input-icon input-icon-right">
				<input type="number" name="code_otp" class="form-control" placeholder="Insert code..." />
				<i class="ace-icon fa fa-lock"></i>
			</span>
		</label>

		<div class="space-12"></div>

		<div class="clearfix">
			<button name="resend" class="width-30 pull-left btn btn-sm">
				<i class="ace-icon fa fa-refresh"></i>
				<span class="bigger-110">Resend</span>
			</button>

			<button name="validate" class="width-65 pull-right btn btn-sm btn-success">
				<span class="bigger-110">Validate</span>

				<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
			</button>
		</div>
	</fieldset>
<?php echo form_close();?>