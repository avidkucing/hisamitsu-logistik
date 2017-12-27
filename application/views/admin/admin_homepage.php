<html>
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
		<title>Admin Page</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div id="profile">
		<?php
			echo "Hello <b id='welcome'><i>" . $nama . "</i> !</b>";
			echo "<br/>";
			echo "<br/>";
			echo "Welcome to Admin Page";
			echo "<br/>";
			echo "<br/>";
			echo "Your Username is " . $username;
			echo "<br/>";
			echo "Your Email is " . $email;
			echo "<br/>";
			echo "<div class='error_msg'>";
			if (isset($message_display)) {
				echo $message_display;
			}
			echo "</div>";
		?>
		</div>
	<br/>
	<center>
		<button onclick="location.href='<?php echo base_url();?>Admin/user_registration_show'"; >Buat Akun Baru</button>
		<br>
		<button onclick="location.href='<?php echo base_url();?>Admin/add_data_bahan_show'"; >Tambah Data Bahan Baku</button>
		<br>
		<button onclick="location.href='<?php echo base_url();?>Admin/logout'"; >Logout</button>
	</center>
	</body>
</html>