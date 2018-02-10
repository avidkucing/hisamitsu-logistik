 <?php

Class Data_lpb extends CI_Model {

	//show data LPB
 	public function lpb() {
 		$this->db->select('bahan_terima.Nomor_LPB, bahan_terima.Tanggal_Terima, jenis_bahan.Kode_Bahan, bahan_terima.Nama_Supplier, bahan_terima.Nama_Manufacturer, jenis_bahan.Satuan');
 		$this->db->from('bahan_terima');
 		$this->db->join('jenis_bahan', 'bahan_terima.ID_Bahan = jenis_bahan.ID_Bahan', 'inner');
 		$this->db->where("jenis_bahan.Jenis", "Baku");
 		$this->db->order_by('Nomor_LPB', 'desc');
 		
 		$o_lpb_rows = $this->db->get()->result();

		$this->ubah_format_tanggal($o_lpb_rows);

 		return $o_lpb_rows;
 	}

 	//homepage batch show data batch
 	public function lpb_batch() {
 		$this->db->select('*');
 		$this->db->from('nomor_batch_bahan');
 		$this->db->order_by('Nomor_LPB', 'asc');
 		
 		$query = $this->db->get();
 		$o_batch_rows = $query->result();

		return $o_batch_rows; 
 	}

 	public function print_lpb($a, $b, $c, $d) {
		$nolpb = $a . '/' . $b . '/' . $c . '/' . $d;
		$this->db->select('bahan_terima.Nomor_LPB, bahan_terima.Tanggal_Terima, jenis_bahan.Kode_Bahan, jenis_bahan.Nama_Bahan, bahan_terima.Nama_Supplier, bahan_terima.Nama_Manufacturer, bahan_terima.Nomor_Surat, jenis_bahan.Satuan');
 		$this->db->from('bahan_terima');
 		$this->db->where("Nomor_LPB", $nolpb);
 		$this->db->join('jenis_bahan', 'bahan_terima.ID_Bahan = jenis_bahan.ID_Bahan', 'inner');
 		$this->db->order_by('Tanggal_Terima desc, Nomor_LPB desc');
 		
 		$o_lpb_rows = $this->db->get()->result();

 		$this->ubah_format_tanggal($o_lpb_rows);

 		$a_lpb_rows = json_decode(json_encode($o_lpb_rows), True);
 		return $a_lpb_rows;
	}

	public function print_batch_lpb($a, $b, $c, $d) {
		$nolpb = $a . '/' . $b . '/' . $c . '/' . $d;
		$this->db->select('*');
 		$this->db->from('nomor_batch_bahan');
 		$this->db->where("Nomor_LPB", $nolpb);
 		$this->db->order_by('Nomor_LPB', 'desc');
 		
 		$query = $this->db->get();
 		$o_batch_rows = $query->result();
 		$a_batch_rows = json_decode(json_encode($o_batch_rows), True);
		return $a_batch_rows; 
	}
 	
	public function ubah_format_tanggal($data){
	 	
 		if (isset($data[0]->Tanggal_Terima)) {
		    foreach($data as $key => $value)
		    	{
					$data[$key]->Tanggal_Terima = date('d/m/Y',strtotime($value->Tanggal_Terima));
				}
		}
		if (isset($data[0]->Tanggal_Permintaan)) {
		    foreach($data as $key => $value)
		    	{
					$data[$key]->Tanggal_Permintaan = date('d/m/Y',strtotime($value->Tanggal_Permintaan));
				}
		}
	}
}

?>