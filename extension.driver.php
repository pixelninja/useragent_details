<?php
	
	
	Class extension_browser_detection extends Extension{
	
		public function about(){
			return array(
				'name' => 'Browser Detection',
				'version' => '1.0',
				'release-date' => '2011-07-18',
				'author' => array(
				 		'name' => 'Phill Gray',
						'email' => 'phill@randb.com.au'
					),
				'description' => 'Detects the users browser and OS, and outputs as params in the param pool.'
		 		);
		}
		
	}
?>