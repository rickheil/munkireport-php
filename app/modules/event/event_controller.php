<?php

namespace modules\event;

use munkireport\Module_controller as Module_controller;
use modules\reportdata\Reportdata_model as Reportdata_model;
use munkireport\View as View;

/**
 * Event module class
 *
 * @package munkireport
 * @author AvB
 **/
class Event_controller extends Module_controller
{
    public function __construct()
    {
        if (! $this->authorized()) {
            $out['items'] = array();
            $out['reload'] = true;
            $out['error'] = 'Session expired: please login';
            $obj = new View();
            $obj->view('json', array('msg' => $out));

            die();
        }
    }

    public function index()
    {
        echo "You've loaded the Event module!";
    }

    /**
     * Get Event
     *
     * @author AvB
     **/
    public function get($minutes = 60, $type = 'all', $module = 'all', $limit = 0)
    {
        $queryobj = new Event_model();
        $queryobj = new Reportdata_model();
        $fromtime = time() - 60 * $minutes;
        $limit = $limit ? sprintf('LIMIT %d', $limit) : '';
        $out['items'] = array();
        $out['error'] = '';
        $sql = "SELECT m.serial_number, module, type, msg, data, m.timestamp,
					machine.computer_name
				FROM event m 
				LEFT JOIN reportdata USING (serial_number) 
				LEFT JOIN machine USING (serial_number) 
				WHERE m.timestamp > $fromtime 
				".get_machine_group_filter('AND')."
				ORDER BY m.timestamp DESC
				$limit";


        foreach ($queryobj->query($sql) as $obj) {
            $out['items'][] = $obj;
        }

        $obj = new View();
        $obj->view('json', array('msg' => $out));
    }
} // END class Event_controller
