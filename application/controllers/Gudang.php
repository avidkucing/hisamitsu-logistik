<?php 
 
class Gudang extends CI_Controller{
	function __construct(){
		parent::__construct();
		
		//Load helper url
		$this->load->helper('url');

		// Load form helper library
		$this->load->helper('form');

		// Load table library
		$this->load->library('table');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// Load database
		$this->load->model('gudang_database');

		if (!(isset($this->session->userdata['logged_in']))) {
			redirect(base_url("User_Authentication"));
		}
	}
 
	public function index(){
		$data['lpb'] = $this->gudang_database->homepage();
		$data['lpb_batch'] =$this->gudang_database->homepage_batch();
		$this->load->view('gudang/gudang_homepage', $data);
	}

	public function print_lpb_show(){
		$this->load->view('gudang/print_lpb');	
	}
	
	public function tambah_lpb_show(){
		$this->load->view('gudang/tambah_lpb');
	}

	public function get_data_nama_bahan(){
	      $value = $this->input->post("value");
	      $data = $this->gudang_database->get_data_nama_bahan($value);
	      $option ="";
	      foreach($data as $d)
	      {
	         $option .= "<option value='".$d->Nama_Bahan."' >".$d->Nama_Bahan."</option>";
	      }
	      echo $option;
	}

	public function get_data_manufaktur(){
		  $value = $this->input->post("value");
	      $data = $this->gudang_database->get_data_manufaktur($value);
	      $option ="";
	      foreach($data as $d)
	      {
	         $option .= "<option value='".$d->Nama_Manufacturer."' >".$d->Nama_Manufacturer."</option>";
	      }
	      echo $option;	
	}

	public function get_data_supplier(){
		  $value = $this->input->post("value");
	      $data = $this->gudang_database->get_data_supplier($value);
	      $option ="";
	      foreach($data as $d)
	      {
	         $option .= "<option value='".$d->Nama_Supplier."' >".$d->Nama_Supplier."</option>";
	      }
	      echo $option;		
	}

	public function get_data_satuan(){
		  $value = $this->input->post("value");
	      $data = $this->gudang_database->get_data_satuan($value);
	      $option ="";
	      foreach($data as $d)
	      {
	         $option .= "<option value='".$d->Satuan."' >".$d->Satuan."</option>";
	      }
	      echo $option;		
	}

	public function new_lpb(){
		// Check validation for user input in SignUp form
		$this->form_validation->set_rules('lpb', 'Nomor LPB', 'trim|required');
		$this->form_validation->set_rules('tgl', 'Tanggal Terima', 'trim|required');
		$this->form_validation->set_rules('surat', 'No. Surat Pesanan', 'trim|required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required');
		$this->form_validation->set_rules('kode', 'Kode Bahan', 'trim|required');
		$this->form_validation->set_rules('nama', 'Nama Bahan', 'trim|required');
		$this->form_validation->set_rules('manu', 'Nama Manufaktur', 'trim|required');
		$this->form_validation->set_rules('supp', 'Nama Supplier', 'trim|required');
		$this->form_validation->set_rules('satuan', 'Satuan', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$data['message_display'] = 'Nomor LPB sudah ada! Gunakan nomor yang lain!';
					$this->load->view('gudang/tambah_lpb');
			$this->load->view('gudang/tambah_lpb');
		} else {
			
			//cari id_bahan di database
			$cari = array(
				'Kode_Bahan' => $this->input->post('kode'),
				'Nama_Bahan' => $this->input->post('nama'),
				'Nama_Manufacturer' => $this->input->post('manu'),
				'Nama_Supplier' => $this->input->post('supp'),
			);
			$arr_id_bahan = $this->gudang_database->cari_id_bahan($cari);
			if ($arr_id_bahan == FALSE) {
				$data['message_display'] = 'Nama Manufaktur dan Supplier tidak sesuai database!';
				$this->load->view('gudang/tambah_lpb', $data);
			} else {
				foreach($arr_id_bahan as $d)
		      {
		         $id_bahan = $d->ID_Bahan;
		      }
				
				//simpan ke variabel
				$data = array(
					'Nomor_LPB' => $this->input->post('lpb'),
					'ID_Bahan' => $id_bahan,
					'Tanggal_Terima' => $this->input->post('tgl'),
					'Nomor_Surat' => $this->input->post('surat'),
					'Jumlah' => $this->input->post('jumlah'),
					'Status' => 'QUARANTINE',
					);
				//input ke database
				$result = $this->gudang_database->bahan_terima_insert($data);
				if ($result == TRUE) {
					//$data['message_display'] = 'Nomor LPB berhasil ditambahkan !';
					
					$array_batch = $this->input->post('batch[]');
					$result =array();
					$b = 0;
					$results = 1;
					foreach (($this->input->post('batch[]')) as $a => $b) {
						$data = array(
						'Nomor_LPB' => $this->input->post('lpb'),
						'Nomor_Batch' => $array_batch[$a],
					);
						$result[$a] = $this->gudang_database->insert_batch_bahan_baku($data);
						if ($result[$a] == FALSE) {
							$data['message_display'] = 'Gagal menambahkan data batch!';
							$results = 0;
							break;
						}
					}
					if ($results == 0) { //gagal tambah data setelah break;
						$this->load->view('gudang/tambah_lpb', $data);	
					} else {
						$data['message_display'] = 'Sukses menambahkan data!';
						$data['lpb'] = $this->gudang_database->homepage();
						$data['lpb_batch'] =$this->gudang_database->homepage_batch();
						$this->load->view('gudang/gudang_homepage', $data);	
					}
				} else {
					$data['message_display'] = 'Nomor LPB sudah ada! Gunakan nomor yang lain!';
					$this->load->view('gudang/tambah_lpb');
				}
			}
		}
	}

	public function logout() {

		// Removing session data
		$sess_array = array(
		'username' => ''
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		$data['message_display'] = 'Successfully Logout';
		$this->load->view('login_form', $data);
	}
}
?>