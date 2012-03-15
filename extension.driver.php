<?php
	
	require_once(EXTENSIONS . '/useragent_details/class/class.browser.php');
	require_once(EXTENSIONS . '/useragent_details/class/class.os.php');
	
	Class extension_useragent_details extends Extension{
	
		public function about(){
			return array(
				'name' => 'Useragent Details',
				'version' => '1.1.2',
				'release-date' => '2012-01-19',
				'author' => array(
				 		'name' => 'Phill Gray',
						'email' => 'pixel.ninjad@gmail.com'
					),
				'description' => 'Detects the users browser/version and OS/version, and outputs as data into a custom datasource.'
		 		);
		}

		public function getSubscribedDelegates() {
			return array(
				array(
					'page' => '/system/preferences/',
					'delegate' => 'AddCustomPreferenceFieldsets',
					'callback' => 'appendPreferences'
				),
				array(
					'page' => '/system/preferences/',
					'delegate' => 'Save',
					'callback' => 'savePreferences'
				)
			);
		}
		
		public function install() {
			// Add defaults to config.php
			if (!Symphony::Configuration()->get('geoplugin', 'useragent_details')) {
				Symphony::Configuration()->set('geoplugin', 'no', 'useragent_details');
			}
			
			return Administration::instance()->saveConfig();
		}
		
		public function uninstall() {
			Symphony::Configuration()->remove('useragent_details');
			return Administration::instance()->saveConfig();
		}
		
		
		public function appendPreferences($context) {
			$fieldset = new XMLElement('fieldset');
			$fieldset->setAttribute('class', 'settings');
			$fieldset->appendChild(new XMLElement('legend', __('Useragent Details')));
			$context['wrapper']->appendChild($fieldset);
			
			$div = new XMLElement('div');
			
			$label = Widget::Label();
			$input = Widget::Input('settings[useragent_details][geoplugin]', 'yes', 'checkbox');
			if(Symphony::Configuration()->get('geoplugin', 'useragent_details') == 'yes') $input->setAttribute('checked', 'checked');
			$label->setValue($input->generate() . ' ' . __('Utilise Geoplugin'));			

			$help = new XMLElement('p', __('Check the box to utilise Geoplugin to display user location details based on IP address'), array('class'=>'help'));

			$div->appendChild($label);
			$div->appendChild($help);
			
			$fieldset->appendChild($div);
		}
		
		/**
		 * Save preferences
		 *
		 * @param array $context
		 *  delegate context
		 */
		public function savePreferences($context) {

			// Disable maintenance mode by default
			if(!is_array($context['settings'])) {
				$context['settings'] = array('useragent_details' => array('geoplugin' => 'no'));
			}
			
			// Disable maintenance mode if it has not been set to 'yes'
			elseif(!isset($context['settings']['useragent_details'])) {
				$context['settings']['useragent_details'] = array('geoplugin' => 'no');
			}			
		}

	}
?>