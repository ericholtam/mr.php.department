<?php
class Department_model extends Model {
	function __construct($serial='')
	{
		parent::__construct('id', 'department'); //primary key, tablename
		$this->rs['id'] = '';
		$this->rs['serial_number'] = $serial; $this->rt['serial_number'] = 'VARCHAR(255) UNIQUE';
		$this->rs['department'] = '';
		$this->rs['status'] = '';
		// Schema version, increment when creating a db migration
		$this->schema_version = 0;
		
		// Create table if it does not exist
		$this->create_table();
		
        if ($serial) {
            $this->retrieve_record($serial);
        }
		
		$this->serial = $serial;
		  
	}
	
	// ------------------------------------------------------------------------

     public function get_department()
     {
        $out = array();
        $sql = "SELECT department, COUNT(1) AS count
                FROM department
                GROUP BY department
                ORDER BY COUNT DESC";
        
        foreach ($this->query($sql) as $obj) {
            if ("$obj->count" !== "0") {
                $obj->department = $obj->department ? $obj->department : 'Unknown';
                $out[] = $obj;
            }
        }
        return $out;
     }
	
	/**
	 * Process data sent by postflight
	 *
	 * @param string data
	 * 
	 **/
	function process($data)
	{		

		// Translate network strings to db fields
        $translate = array(
        	'Department = ' => 'department',
        	'Status = ' => 'status');

//clear any previous data we had
		foreach($translate as $search => $field) {
			$this->$field = '';
		}
		// Parse data
		foreach(explode("\n", $data) as $line) {
		    // Translate standard entries
			foreach($translate as $search => $field) {
			    
			    if(strpos($line, $search) === 0) {
				    
				    $value = substr($line, strlen($search));
				    
				    $this->$field = $value;
				    break;
			    }
			} 
		    
		} //end foreach explode lines				

		$this->save();
	}
}

