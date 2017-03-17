<?php 

/**
 * department manifest status module class
 *
 * @package munkireport
 * @author
 **/
class department_controller extends Module_controller
{
	
	/*** Protect methods with auth! ****/
	function __construct()
	{
		// Store module path
		$this->module_path = dirname(__FILE__);
	}

	/**
	 * Default method
	 *
	 * @author AvB
	 **/
	function index()
	{
		echo "You've loaded the department module!";
	}

	/**
     * Get department names for widget
     *
     * @return void
     **/
     public function get_department()
     {
        $obj = new View();

        if (! $this->authorized()) {
            $obj->view('json', array('msg' => array('error' => 'Not authenticated')));
            return;
        }
        
        $department = new Department_model;
        $obj->view('json', array('msg' => $department->get_department()));
     }
	
} // END class default_module

