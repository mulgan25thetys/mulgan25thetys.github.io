<?php echo '<label class="text-danger">'.$this->session->flashdata('error').'</label>';?>
<?php echo '<label class="text-primary">'.$this->session->flashdata('email_sent').'</label>';?>

<?php 
$attributs = array(
             'id' => 'form_login'
           );
echo form_open('auth_v2/submit_login', $attributs);?>
	<fieldset>
		<label class="block clearfix">
			<span class="text-danger"><?php echo form_error('username')?></span>
			<span class="block input-icon input-icon-right">
				<input type="text" name="username" class="form-control" placeholder="Username" <?php 
				    if(isset($_POST['username'])){
				?>
						value="<?php echo $_POST['username']?>"<?php }?>/>
				<i class="ace-icon fa fa-user"></i>
			</span>
		</label>

		<label class="block clearfix">
			<span class="text-danger"><?php echo form_error('password')?></span>
			<span class="block input-icon input-icon-right">
				<input type="password" name="password" class="form-control" placeholder="Password" <?php
				    if(isset($_POST['password'])){
				?>
						value="<?php echo $_POST['password']?>"<?php }?>/>
				<i class="ace-icon fa fa-lock"></i>
			</span>
		</label>

		<div class="space"></div>
		<?php 
            if ($this->session->userdata('login_attempted')) {
            	echo '<label class="text-danger">'.$this->session->userdata('login_attempted').'</label>';
            	$this->session->set_userdata(array('locked'=> time()));
            }else{
		?>
		<div class="clearfix">
			<label class="inline">
				<input type="checkbox" name="remember"  class="ace" />
				<span class="lbl"> Remember Me</span>
			</label>
            
			<button name="login" class="width-35 pull-right btn btn-sm btn-primary">
				<i class="ace-icon fa fa-key"></i>
				<span class="bigger-110">Login</span>
			</button>
		</div>
		<?php }?>
		<div class="space-4"></div>
	</fieldset>
<?php echo form_close();?>