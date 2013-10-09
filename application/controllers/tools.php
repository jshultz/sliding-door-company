<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/site
	 *    - or -
	 *        http://example.com/index.php/site/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
	{
		parent::__construct();

        $this->load->model('Tools_model');

	}

	/* This Does Nothing except prove the site can load */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	/* Move quotes from clients table to quotes table */
	public function move_quotes()
	{
		$result = $this->Tools_model->move_quotes();

        if ($result == false) {
            echo 'something went wrong';
            return false;
        } else {
            echo 'success';
            return true;
        }

	}

    public function update_locations() {
        $this->Tools_model->update_locations_lat();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/site.php */