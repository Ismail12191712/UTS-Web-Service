<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Buku extends REST_Controller 
{

    function __construct($config = 'rest') 
    {
    	parent::__construct($config);
    }

    //Menampilkan data
    public function index_get() 
    {

        $id = $this->get('id');
        $buku=[];
        if ($id == '') 
        {
        	$data = $this->db->get('buku')->result();
            foreach ($data as $row => $key):
                $buku[] = ["id_buku"=>$key->id_buku,
                            "pengarang_buku"=>$key->pengarang_buku,
                            "judul_buku"=>$key->judul_buku,
                            "jenis_buku"=>$key->jenis_buku,
                            "_links"=>[(object) ["href"=>"user/{$key->id_buku}",
                                        "rel"=>"user",
                                        "type"=>"GET"]],
            ];
            endforeach;
        } 
        else 
        {
        	$this->db->where('id_buku', $id);
        	$data = $this->db->get('buku')->result();
        }
        $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
        			"code"=>200,
        			"message"=>"Response succesfully",
        			"data"=>$buku];
        $this->response($result, 200);
    }


    //Menambah data Method Post
    public function index_post() {
        $data = array(
                    'id_buku'           => $this->post('id_buku'),
                    'pengarang_buku'          => $this->post('pengarang_buku'),
                    'judul_buku'    => $this->post('judul_buku'),
                    'jenis_buku'    => $this->post('jenis_buku'));
        $insert = $this->db->insert('buku', $data);
        if ($insert) {
            $this->response($data, 200);
            $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                    "code"=>201,
                    "message"=>"Data has succesfully added",
                    "data"=>$data];
            $this->response($result, 201); 
        } else {
            $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                    "code"=>502,
                    "message"=>"Failed adding data",
                    "data"=>$null];
            $this->response($result, 502);
        }
    }

    //Memperbarui data yang telah ada
    public function index_put() {
        $id = $this->put('id');
        $data = array(
                    'id_buku'           => $this->post('id_buku'),
                    'pengarang_buku'          => $this->post('pengarang_buku'),
                    'judul_buku'    => $this->post('judul_buku'),
                    'jenis_buku'    => $this->post('jenis_buku'));
        $this->db->where('id_buku', $id);
        $update = $this->db->update('buku', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Menghapus data buku
    public function index_delete() {
        $id = $this->delete('id');
        $this->db->where('id_buku', $id);
        $delete = $this->db->delete('buku');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

}
?>