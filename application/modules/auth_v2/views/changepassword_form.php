<p>
	Enter your details : to modify your password
<?php echo '<label class="text-danger" >'.$this->session->flashdata('update_error').'</label>';?>
<?php 
 $attributs = array(
                'id' => 'form_resetPwd'
                );
 echo form_open('auth_v2/submit_update_password', '', $attributs);
?>
	<fieldset>
		<label class="block clearfix">
			<span class="text-danger"><?php echo form_error('password')?></span>
			<span class="block input-icon input-icon-right">
				<input type="password" name="password" class="form-control" placeholder="New password" <?php
				    if(isset($_POST['password'])){
				?>
						value="<?php echo $_POST['password']?>"<?php }?>/>
				<i class="ace-icon fa fa-lock"></i>
			</span>
		</label>

		<label class="block clearfix">
			<span class="text-danger"><?php echo form_error('repeatPassword')?></span>
			<span class="block input-icon input-icon-right">
				<input type="password" name="repeatPassword" class="form-control" placeholder="Repeat password" <?php 
				    if(isset($_POST['repeatPassword'])){
				?>
						value="<?php echo $_POST['repeatPassword']?>"<?php }?>/>
				<i class="ace-icon fa fa-retweet"></i>
			</span>
		</label>

		<div class="clearfix">
			<button name="resetpwd_update" class="width-35 pull-right btn btn-sm btn-danger">
				<i class="ace-icon fa fa-lightbulb-o"></i>
				<span class="bigger-110">Save!</span>
			</button>
		</div>
	</fieldset>
<?php echo form_close();?>