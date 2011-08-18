<?php
	
	require_once(EXTENSIONS . '/support_details/class/class.browser.php');
	require_once(EXTENSIONS . '/support_details/class/class.os.php');
	
	Class extension_support_details extends Extension{
	
		public function about(){
			return array(
				'name' => 'Support Details',
				'version' => '1.0',
				'release-date' => '2011-07-18',
				'author' => array(
				 		'name' => 'Phill Gray',
						'email' => 'phill@randb.com.au'
					),
				'description' => 'Detects the users browser and OS, and outputs as params in the param pool.'
		 		);
		}
		
		public function getSubscribedDelegates() {
			return array(
				array(
					'page' => '/backend/',
					'delegate' => 'InitaliseAdminPageHead',
					'callback' => 'initaliseAdminPageHead'
				),
		        array(
		            'page'      => '/backend/',
		            'delegate'  => 'DashboardPanelRender',
		            'callback'  => 'render_panel'
		        ),
		        array(
		            'page'      => '/backend/',
		            'delegate'  => 'DashboardPanelOptions',
		            'callback'  => 'dashboard_panel_options'
		        ),
		        array(
		            'page'      => '/backend/',
		            'delegate'  => 'DashboardPanelTypes',
		            'callback'  => 'dashboard_panel_types'
		        )
			);
		}
		
		public function initaliseAdminPageHead($context) {
			$callback = Symphony::Engine()->getPageCallback();
			
			if($callback['pageroot'] == '/extension/dashboard/') {
				Symphony::Engine()->Page->addScriptToHead(URL . '/extensions/support_details/assets/support_details.flashdetect.js', 10001);
				Symphony::Engine()->Page->addScriptToHead(URL . '/extensions/support_details/assets/support_details.dashboard.js', 10001);
			}
		}
		
		public function dashboard_panel_types($context) {
		    $context['types']['support_details'] = __('Support Details Panel');
		}
		
		public function dashboard_panel_options($context) {
		    // make sure it's your own panel type, as this delegate fires for all panel types!
		    if ($context['type'] != 'support_details') return;

		    $config = $context['existing_config'];
		}
		
		public function render_panel($context) {
		    if ($context['type'] != 'support_details') return;
			
			// Get the ip address
			//$ip = $_SERVER['REMOTE_ADDR'];
			$ip = '203.144.8.51';
			
			// get contents from external api
			$content = file_get_contents('http://api.hostip.info/get_xml.php?ip='.$ip);
			// process data into variables
			if ($content != FALSE) {
				$xml = new SimpleXmlElement($content);
				
				$parent = $xml->children('gml', TRUE)->featureMember->children('', TRUE)->Hostip;
				$coordinates = $parent->ipLocation->children('gml', TRUE)->pointProperty->Point->coordinates;
				
				$longlat = explode(',', $coordinates);
				$location['longitude'] = $longlat[0];
				$location['latitude'] = $longlat[1];	
					
			    $location['city'] = $parent->children('gml', TRUE)->name;
				$location['country'] =  $parent->countryName;
				$location['country_abbr'] =  $parent->countryAbbrev;
				$location['ip'] =  $ip;
			}
			
			$div = new XMLElement('div');
			
			$browser = new Browser();
			$os = new OS();
			
			$dl = new XMLElement('dl');
			$dl->appendChild(new XMLElement('dt', __('Platform')));
			$dl->appendChild(new XMLElement('dd', __($browser->getPlatform())));
		
			$dl->appendChild(new XMLElement('dt', __('Operating system')));
			$dl->appendChild(new XMLElement('dd', __($os->getOS())));
			
			$dl->appendChild(new XMLElement('dt', __('Browser')));
			$dl->appendChild(new XMLElement('dd', __($browser->getBrowser().' '.$browser->getVersion())));
		
			$dl->appendChild(new XMLElement('dt', __('IP address')));
			//$dl->appendChild(new XMLElement('dd', __($_SERVER['REMOTE_ADDR'])));
			$dl->appendChild(new XMLElement('dd', __('203.144.8.51')));
		
			$dl->appendChild(new XMLElement('dt', __('Mobile device?')));
			$dl->appendChild(new XMLElement('dd', __($browser->isMobile() ? 'Yes' : 'No')));
		
			$dl->appendChild(new XMLElement('dt', __('Chrome Frame enabled?')));
			$dl->appendChild(new XMLElement('dd', __($browser->isChromeFrame() ? 'Yes' : 'No')));
		
		   	$div->appendChild(new XMLElement('h4', __('Configuration')));
			$div->appendChild($dl);
			
			
			$dl = new XMLElement('dl');
			$dl->appendChild(new XMLElement('dt', __('Screen Resolution'), array('class'=>'screen')));
			$dl->appendChild(new XMLElement('dd', ''));
		
			$dl->appendChild(new XMLElement('dt', __('Browser Size'), array('class'=>'browser')));
			$dl->appendChild(new XMLElement('dd', ''));
		
		   	$div->appendChild(new XMLElement('h4', __('Resolutions')));
			$div->appendChild($dl);
			
			
			$dl = new XMLElement('dl');
			$dl->appendChild(new XMLElement('dt', __('enabled?'), array('class'=>'flash-enabled')));
			$dl->appendChild(new XMLElement('dd', ''));
		
			$dl->appendChild(new XMLElement('dt', __('Version'), array('class'=>'flash-version')));
			$dl->appendChild(new XMLElement('dd', ''));
		
		   	$div->appendChild(new XMLElement('h4', __('Flash')));
			$div->appendChild($dl);
			
			
			$dl = new XMLElement('dl');
			$dl->appendChild(new XMLElement('dt', __('enabled?'), array('class'=>'js')));
			$dl->appendChild(new XMLElement('dd', 'No'));
		
		   	$div->appendChild(new XMLElement('h4', __('Javascript')));
			$div->appendChild($dl);
			
			
			$dl = new XMLElement('dl');
			$dl->appendChild(new XMLElement('dt', __('Colour Depth'), array('class'=>'depth')));
			$dl->appendChild(new XMLElement('dd', ''));
		
		   	$div->appendChild(new XMLElement('h4', __('Colour Depth')));
			$div->appendChild($dl);
			
			
			$dl = new XMLElement('dl');
			$dl->appendChild(new XMLElement('dt', __('Location')));
			$dl->appendChild(new XMLElement('dd', $location['city'].', '.$location['country_abbr']));
		
			$dl->appendChild(new XMLElement('dt', __('Latitude/Longitude')));
			$dl->appendChild(new XMLElement('dd', $location['latitude'].' / '.$location['longitude']));
		
			$dl->appendChild(new XMLElement('dt', __('Flag')));
			$dl->appendChild(new XMLElement('img', '', array('src'=>'http://api.hostip.info/flag.php?ip='.$ip)));
		
		   	$div->appendChild(new XMLElement('h4', __('Location')));
			$div->appendChild($dl);

			$context['panel']->appendChild($div);
		}

		
	}
?>