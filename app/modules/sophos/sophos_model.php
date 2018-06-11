<?php

class Sophos_model extends \Model
{
    public function __construct($serial = '')
    {
        parent::__construct('id', 'sophos');
        $this->rs['id'] = '';
        $this->rs['serial_number'] = $serial;
        $this->rs['installed'] = '';
        $this->rs['running'] = '';
        $this->rs['product_version'] = '';
        $this->rs['engine_version'] = '';
        $this->rs['virus_data_version'] = '';
        $this->rs['user_interface_version'] = '';

        // Add indexes
        $this->idx[] = array('serial_number');
        $this->idx[] = array('installed');
        $this->idx[] = array('running');
        $this->idx[] = array('product_version');
        $this->idx[] = array('engine_version');
        $this->idx[] = array('virus_data_version');
        $this->idx[] = array('user_interface_version');

        // Schema version, incrememnt when creating a db migration
        $this->schema_version = 0;

        if ($serial) {
            $this->retrieve_record($serial);
        }

        $this->serial = $serial;
    }

    // ------------------------------------------------------------------------

    /**
     * Process data sent by postflight
     *
     * @param string data
     *
     **/
    public function process($data)
    {
		$parser = new CFPropertyList();
		$parser->parse($data);

		$plist = $parser->toArray();

		foreach (array('running', array('versions')) as $item) {
			if (isset($plist[$item])) {
				$this->$item = $plist[$item];
			} else {
				$this->$item = '';
			}
		}
		$this->save();
    }
}

?>
