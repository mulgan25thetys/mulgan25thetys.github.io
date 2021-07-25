<?php $this->load->view('head')?>

	<body class="no-skin">
		
		<?php $this->load->view('header')?>

		<div class="main-container ace-save-state container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse          ace-save-state sidebar-fixed">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

			       	
            <?php $this->load->view('nav-liste')?>
				
			</div>

        <!-- MAIN -->

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						

						<div class="page-header">
							<h1>
								Top Menu Style
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									top menu &amp; navigation
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								

								<!--<div class="hidden-sm hidden-xs">
									<button type="button" class="sidebar-collapse btn btn-white btn-primary" data-target="#sidebar">
										<i class="ace-icon fa fa-angle-double-up" data-icon1="ace-icon fa fa-angle-double-up" data-icon2="ace-icon fa fa-angle-double-down"></i>
										Collapse/Expand Menu
									</button>
								</div>-->

								<?php $this->load->view($module.'/'.$view_file);?>

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->


			<!--END MAIN -->

			<?php $this->load->view('footer')?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<?php $this->load->view('view_js/default_js')?>
	</body>
</html>
