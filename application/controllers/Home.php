<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Note');
	}

	public function index()
	{
		$this->load->view('includes/header');
		$data['notes'] = $this->Note->getAll();
		$this->load->view('home/index', $data);
		$this->load->view('includes/footer');
	}

	public function add_note()
	{
		if ($this->input) {
			$title = $this->input->post("title");
			$content = $this->input->post("content");
			$data = array(
				'title' => $title,
				'content' => $content
			);
			$response = $this->Note->add($data);
			if ($response) {
				echo "<script>alert('Add Sucessful!')</script>";
			} else {
				echo "<script>alert('Add Failure!')</script>";
			}
			redirect('home/index', 'refresh');
		} else {
			redirect('home/index', 'refresh');
		}
	}
	public function update_note()
	{
		$content = trim(file_get_contents("php://input"));
		$decoded = json_decode($content, true);
		$response = $this->Note->update($decoded);
		echo json_encode(array('response' => $response));
	}
	public function delete_note($id)
	{
		$response = $this->Note->delete($id);
		if ($response) {
			echo "<script>alert('Delete Sucessful!')</script>";
			redirect('home/index', 'refresh');
		} else {
			echo "<script>alert('Delete Failure!')</script>";
			redirect('home/index', 'refresh');
		}

	}
}
