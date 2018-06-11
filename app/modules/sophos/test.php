<?php

require_once '/Users/rickheil/Development/munkireport-php/vendor/autoload.php';
use CFPropertyList\CFPropertyList;

$myfile = fopen("/usr/local/munki/preflight.d/cache/sophos.plist", "r") or die("unable to open file");
$data = fread($myfile, filesize("/usr/local/munki/preflight.d/cache/sophos.plist")); 
fclose($myfile);

$parser = new CFPropertyList();
$parser->parse($data);
$plist = $parser->toArray();
print_r($plist);

        $translate = array(
            'Installed' => 'installed',
            'Running' => 'running',
            'Engine version' => 'engine_version',
            'Product version' => 'product_version',
            'User interface version' => 'user_interface_version',
            'Virus data version' => 'virus_data_version',
        );

$installed = $plist['Installed'];
print $installed;

$productversion = $plist['Versions']['Product version'];
print $productversion;
