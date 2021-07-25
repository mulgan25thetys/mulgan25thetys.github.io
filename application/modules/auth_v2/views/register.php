<p> Enter your details to begin: </p>
<?php echo '<label class="text-danger">'.$this->session->flashdata('error').'</label>';?>

<?php 
 $attributs = array(
	'id' => 'form_register'
 );
 echo form_open('auth_v2/submit_register', '', $attributs);
?>
	<fieldset>
		<label class="block clearfix">
			Vous etes?
			<span class="text-danger"><?php echo form_error('fonction')?></span>
			<span class="block input-icon input-icon-right">
				<select class="form-control" name="fonction" aria-label="Default select example">
				  <option selected value="callcenter">Call center</option>
				  <option value="entreprise">Entreprise</option>
				  <option value="particulier">Particulier</option>
				</select>
			</span>
		</label>
		<label class="block clearfix">
			<span class="text-danger"><?php echo form_error('email')?></span>
			<span class="block input-icon input-icon-right">
				<input type="email" name="email" class="form-control" placeholder="Email" 
				<?php 
				    if(isset($_POST['email'])){
				?>
						value="<?php echo $_POST['email']?>"<?php }?>
				/>
				<i class="ace-icon fa fa-envelope"></i>
			</span>
		</label>

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
			<span class="text-danger"><?php echo form_error('lastname')?></span>
			<span class="block input-icon input-icon-right">
				<input type="text" name="lastname" class="form-control" placeholder="LastName" <?php 
				    if(isset($_POST['firstname'])){
				?>
						value="<?php echo $_POST['lastname']?>"<?php }?>/>
				<i class="ace-icon fa fa-user"></i>
			</span>
		</label>
		<label class="block clearfix">
			<span class="text-danger"><?php echo form_error('firstname')?></span>
			<span class="block input-icon input-icon-right">
				<input type="text" name="firstname" class="form-control" placeholder="FirstName" <?php 
				    if(isset($_POST['firstname'])){
				?>
						value="<?php echo $_POST['firstname']?>"<?php }?>/>
				<i class="ace-icon fa fa-user"></i>
			</span>
		</label>
		<label class="block clearfix">
			<span class="text-danger"><?php echo form_error('activityDomain')?></span>
			<span class="block input-icon input-icon-right">
				<input type="text" name="activityDomain" class="form-control" placeholder="Activity Domain" <?php 
				    if(isset($_POST['activityDomain'])){
				?>
						value="<?php echo $_POST['activityDomain']?>"<?php }?>/>
				<i class="ace-icon  fa fa-building"></i>
			</span>
		</label>
		<label class="block clearfix">
			<span class="text-danger"><?php echo form_error('mobilePhone')?></span>
			<span class="block input-icon input-icon-right">
				<input type="number" name="mobilePhone" class="form-control" placeholder="Mobile phone" <?php 
				    if(isset($_POST['mobilePhone'])){
				?>
						value="<?php echo $_POST['mobilePhone']?>"<?php }?>/>
				<i class="ace-icon fa fa-phone"></i>
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

		<label class="block">
			<input type="checkbox" class="ace" />
			<span class="lbl">
				I accept the
				<a href="#">User Agreement</a>
			</span>
		</label>

		<div class="space-24"></div>

		<div class="clearfix">
			<button type="reset" class="width-30 pull-left btn btn-sm">
				<i class="ace-icon fa fa-refresh"></i>
				<span class="bigger-110">Reset</span>
			</button>

			<button name="register" class="width-65 pull-right btn btn-sm btn-success">
				<span class="bigger-110">Register</span>

				<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
			</button>
		</div>
	</fieldset>
<?php echo form_close();?>