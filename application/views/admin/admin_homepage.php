<!doctype html>

	<?php
		if (isset($this->session->userdata['logged_in'])) {
			$username = ($this->session->userdata['logged_in']['username']);
			$email = ($this->session->userdata['logged_in']['email']);
			$nama = ($this->session->userdata['logged_in']['nama']);
		} else {
			header("location: login");
		}
	?>

<head>
	<title>Admin</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- jQuery library -->
	<script src="<?php echo base_url(); ?>public/js/jquery-3.2.1.min.js"></script>
	<!--Bootstrap 4-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap.min.css">
	<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
	<!--Icons-->
	<script defer src="<?php echo base_url(); ?>public/js/fontawesome-all.js"></script>
	<!--Our Custom CSS & JS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/global.css">
	<script src="<?php echo base_url(); ?>public/js/global.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/admin.css">
	<script src="<?php echo base_url(); ?>public/js/admin.js"></script>
	<!--Data Tables-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/dataTables.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/select.dataTables.min.css">
    <script src="<?php echo base_url(); ?>public/js/dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/dataTables.select.min.js"></script>
</head>
<body>
	<div id="for-web">
		<div class="modal fade" id="editor" tabindex="-1" role="dialog">
		 	<div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
				        <h5 class="modal-title">Edit Data</h5>
				        <button type="button" class="close" data-dismiss="modal">
				        	<span>&times;</span>
				        </button>
			      	</div>
			     <div class="modal-body">
			        <form>
			        	<div class="form-group row">
			        		<label for="uname" class="col-md-2 col-form-label">Username:</label>
			        		<div class="col-md-10">
			        			<input type="text" class="form-control" id="uname" name="uname" required> <!--@TODO add validation-->
			        		</div>
			        	</div>
			        	<div class="form-group row">
			        		<label for="nama" class="col-md-2 col-form-label">Nama:</label>
    						<div class="col-md-10">
			        			<input type="text" class="form-control" id="nama" name="nama">
			        		</div>
			        	</div>
			        	<div class="form-group row">
			        		<label for="tipe" class="col-md-2 col-form-label">Tipe:</label>
    						<div class="col-md-10">
			        			<input type="text" class="form-control" id="tipe" name="tipe">
			        		</div>
			        	</div>
			        	<div class="form-group row">
			        		<label for="password" class="col-md-2 col-form-label">New Password:</label>
    						<div class="col-md-10">
			        			<input type="text" class="form-control" id="password" name="password">
			        		</div>
			        	</div>
			        </form>
			     </div>
			    	<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				        <button type="submit" class="btn btn-primary" id="save" data-dismiss="modal">Save</button>
			    	</div>
			    </div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2 sidebar">
				<div class="sidebar-header">
					<h2>Admin</h2>
					<p>Halo, <?php echo $nama;?></p>
				</div>
				<hr>
				<ul class="links list-unstyled">
					<li class="active" id="bahan"><a href="#data-bahan">Data Bahan</a></li>
					<li id="akun"><a href="#kelola-akun">Kelola Akun</a></li>
					<!--<li>
						<a id="other" href="#sublinks" data-toggle="collapse" aria-expanded="false">Lihat Lainnya<i class="fas fa-angle-down fa-fw fa-lg arrow"></i></a>
						<ul class="collapse list-unstyled" id="sublinks">
							<li><a href="#">Page</a></li>
							<li><a href="#">Page</a></li>
							<li><a href="#">Page</a></li>
						</ul>
					</li>-->
				</ul>
				<div class="links2 col-md-12">
					<ul class="list-unstyled">
						<li><a href="#"><i class="fas fa-bell fa-fw fa-lg"></i> Notifikasi</a></li>
						<li><a href="<?php echo base_url(); ?>Admin/logout"><i class="fas fa-power-off fa-fw fa-lg"></i> Logout</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-10 offset-md-2 content">
				<?php
					echo "<div class='error_msg'>";
					if (isset($message_display)) {
						echo $message_display;
					}
					echo "</div>";
				?>
				<div id="bahan-content">
					<div class="row button-container mr-0">
						<div class="col">
							<button class="btn btn-block" onclick="location.href='<?php echo base_url();?>Admin/add_data_bahan_baku_show'"; >Tambah Data Bahan Baku</button>
						</div>
						<div class="col">
							<button class="btn btn-block" onclick="location.href='<?php echo base_url();?>Admin/add_data_bahan_kemas_show'"; >Tambah Data Bahan Kemas</button>
						</div>
					</div>
				</div>
				<div id="akun-content" style="display: none;">
					<div id="test-table">
						<div id=asd>
							<?php
		 				$template = array(
		 			        'table_open' => '<table class="table table-bordered table-hover decorated" cell-spacing="0">'
		 				);
		 				$this->table->set_template($template);
		 				$this->table->set_heading('Username', 'Nama', 'Sebagai');

		 				foreach ($akun as $a) {
		 					$username = array('data' => $a->Username, 'data-id' => $a->Username);
							$nama = array('data' => $a->Nama, 'data-id' => $a->Username);
							$tipe = array('data' => $a->Tipe_Pegawai, 'data-id' => $a->Username);
							$this->table->add_row($username, $nama, $tipe);	
		 				}

		 				echo $this->table->generate();
		 				$this->table->clear();
			 			?>
						</div>
						
					</div>
					
					<div class="row button-container mlr-0">
						<div class="col">
							<button class="btn btn-block" onclick="location.href='<?php echo base_url();?>Admin/user_registration_show'"; >Buat Akun Baru</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>