<?php
	
	require_once(EXTENSIONS . '/useragent_details/class/class.browser.php');
	require_once(EXTENSIONS . '/useragent_details/class/class.os.php');
	
	Class extension_useragent_details extends Extension{
	
		public function about(){
			return array(
				'name' => 'Useragent Details',
				'version' => '1.0',
				'release-date' => '2011-08-30',
				'author' => array(
				 		'name' => 'Phill Gray',
						'email' => 'pixel.ninjad@gmail.com'
					),
				'description' => 'Detects the users browser/version and OS/version, and outputs as data into a custom datasource.'
		 		);
		}

	}
?>