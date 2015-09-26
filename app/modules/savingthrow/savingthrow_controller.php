<?php 

/**
 * Savingthrow_controller class
 *
 * @package munkireport
 * @author AvB
 **/
class Savingthrow_controller extends Module_controller
{
	function __construct()
	{
        $this->module_path = dirname(__FILE__) .'/';
        $this->view_path = $this->module_path . 'views/';
	}

	/**
	 * Default method
	 *
	 * @author AvB
	 **/
	function index()
	{
		echo "You've loaded the Savingthrow module!";
	}

    /**
     * Show detail information
     *
     * @author AvB
     **/
    function show()
    {
        if( ! $this->authorized())
        {
            redirect('auth/login');
        }
        
        $data['scripts'] = array("clients/client_list.js");
        $data['page'] = '';
        $obj = new View();
        $obj->view('savingthrow', $data, $this->view_path);
    }

	/**
     * Retrieve data in json format
     *
     * @return void
     * @author 
     **/
    function get_data($serial_number = '')
    {
        $obj = new View();

        if( ! $this->authorized())
        {
            $obj->view('json', array('msg' => 'Not authorized'));
        }

        $service = new Service_model;
        $obj->view('json', array('msg' => $service->retrieve_records($serial_number)));
    }
	
	/**
     * Retrieve data in json format
     *
     * @return void
     * @author 
     **/
    function get_items()
    {
		
		if( ! $this->authorized())
		{
			$obj->view('json', array('msg' => 'Not authorized'));
		}

		$savingthrow = new Savingthrow_model();
		$obj = new View();
		$obj->view('json', array('msg' => $savingthrow->get_items()));
    }


} // END class Service_controller