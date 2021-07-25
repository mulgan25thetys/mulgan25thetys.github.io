<p>
	Enter your email and to receive instructions
</p>
<?php echo '<label class="text-danger" >'.$this->session->flashdata('email_sent').'</label>';?>
<?php 
 $attributs = array(
                'id' => 'form_resetPwd'
                );
 echo form_open('auth_v2/submit_resetpwd', '', $attributs);
?>
	<fieldset>
		<label class="block clearfix">
			<span class="text-danger"><?php echo form_error('email');?></span>
			<span class="block input-icon input-icon-right">
				<input type="email" name="email" class="form-control" placeholder="Email" <?php 
				    if(isset($_POST['email'])){
				?>
						value="<?php echo $_POST['email']?>"<?php }?>/>
				<i class="ace-icon fa fa-envelope"></i>
			</span>
		</label>

		<div class="clearfix">
			<button name="resetpwd" class="width-35 pull-right btn btn-sm btn-danger">
				<i class="ace-icon fa fa-lightbulb-o"></i>
				<span class="bigger-110">Send Me!</span>
			</button>
		</div>
	</fieldset>
<?php echo form_close();?>