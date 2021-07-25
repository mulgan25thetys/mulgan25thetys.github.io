<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar ace-save-state navbar-fixed-top">
			<div class="navbar-container ace-save-state container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="<?php echo base_url().'auth_v2/home';?>" class="navbar-brand">
						<small>
							<i class="fa fa-headphones"></i>
							AU<span style="color: black">XI</span>CALL
						</small>
					</a>

					<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
						<span class="sr-only">Toggle user menu</span>

						<img src="<?= base_url()?>/images/avatars/user.jpg" alt="Jason's Photo" />
					</button>

					<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
						<span class="sr-only">Toggle sidebar</span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
					<ul class="nav ace-nav">
						

						<li class="light-blue dropdown-modal user-min">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?= base_url()?>assets/images/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									<?php 

									   if($this->session->userdata('username') != "")
                                       {
                                       	  echo $this->session->userdata('username');
                                       }else{
                                       	redirect(base_url().'auth_v2/login');
                                       }                                                      
									?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="<?php echo base_url().'auth_v2/account';?>">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="<?php echo base_url().'auth_v2/logout';?>">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>

				<nav role="navigation" class="navbar-menu pull-left collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="ace-icon fa fa-phone"></i>
								Call
							</a>
						</li>

						<li>
							<a href="#">
								<i class="ace-icon fa fa-commenting"></i>
								SMS Push
								<span class="badge badge-warning">5</span>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="ace-icon fa fa-envelope"></i>
								E-Mailing
							</a>
						</li>
					</ul>

					<form class="navbar-form navbar-left form-search" role="search">
						<div class="form-group">
							<input type="text" placeholder="search" />
						</div>

						<button type="button" class="btn btn-mini btn-info2">
							<i class="ace-icon fa fa-search icon-only bigger-110"></i>
						</button>
					</form>
				</nav>
			</div><!-- /.navbar-container -->
		</div>