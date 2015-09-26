<?php
class Savingthrow_model extends Model {
	
	function __construct($serial='')
	{
		parent::__construct('id', 'savingthrow'); //primary key, tablename
		$this->rs['id'] = '';
		$this->rs['serial_number'] = $serial;
		$this->rs['malware_name'] = ''; // Name of malware
		$this->rs['malware_file'] = ''; // Infected file
		$this->rs['timestamp'] = 0; // Timestamp of last update
		
		// Schema version, increment when creating a db migration
		$this->schema_version = 0;
		
		//indexes to optimize queries
		$this->idx[] = array('serial_number');
		$this->idx[] = array('malware_name');
		$this->idx[] = array('malware_file');
		
		// Create table if it does not exist
		$this->create_table();
				  
	}

	// ------------------------------------------------------------------------
	/**
	 * Process data sent by postflight
	 *
	 * @param string data
	 * 
	 **/
	function process($data)
	{		
		// Delete previous entries
		$this->delete_where('serial_number=?', $this->serial_number);
        
		// Check if we've found anything
		if(strpos($data, '<result>False</result>') !== FALSE)
		{
			return; // Nothing found
		}
        
		// Parse log data
		$name = ''; // malware name
        foreach(explode("\n", $data) as $line)
        {
			// Skip result tags
			if($line == '<result>' or $line == '</result>')
			{
				continue;
			}
			
			// Look for name
			if(strpos($line, 'Name: ') === 0)
			{
				$name = substr($line, 6);
				continue;
			}
			
			// Look for files
			if(preg_match('/File \d+: (.+)/', $line, $matches))
        	{
				$this->malware_name = trim($name);
				$this->malware_file = trim($matches[1]);
				$this->id = '';
				$this->timestamp = time();
				$this->create();
				
        	}
        }

	} // end process()
	
	/**
	 * Get malware items totals per Name
	 *
	 * Retrieves malware items totals
	 *
	 **/
	public function get_items()
	{
		$out = array();
		$where = get_machine_group_filter('WHERE');
		$sql= "SELECT malware_name, COUNT(DISTINCT savingthrow.serial_number) as count 
			FROM savingthrow 
			LEFT JOIN reportdata USING(serial_number)
			$where
			GROUP BY malware_name";
		foreach($this->query($sql) AS $obj)
		{
			$out[] = $obj;
		}
		return $out;
	}
}
