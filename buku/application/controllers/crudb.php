<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crudb extends CI_Controller {

    //Menampilkan data
    public function load_buku() {
        $data = $this->m_crudb->GetDataBuku();
        $this->load->view('v_crudb', array('data' => $data));
    }
    public function load_tablejoin() {
        $dataa = $this->m_crudb->JoinAllTable();
        $this->load->view('/buku/v_crudjoin', array('dataa' => $dataa));
    }
}
?>