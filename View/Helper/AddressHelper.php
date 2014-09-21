<?php
/**
 * Helper for easily rendering an address in a View template.
 * 
 * e.g. echo $this->Address->format($data['CustomerAddress']);
 */

App::uses('AppHelper', 'View/Helper');

class AddressHelper extends AppHelper {

	public $helpers = array('Html');

	public $settings = array(
		'fields' => array(
			'house_name',
			array(
				'house_number',
				'address_line_1'
			),
			'address_line_2',
			'address_line_3',
			'city',
			'county',
			'postcode',
			'country'
		)
	);

/**
 * Returns a formatted address excluding empty address fields.
 * 
 * @param array $data array containing the address
 * @param array $attributes options
 * @return string
 */
	public function format($data, $attributes = array()) {

		$defaults = array(
			'tag' => 'address'
		);

		$attributes = array_merge($defaults, $attributes);

		$address = array();

		foreach ($this->settings['fields'] as $field) {

			if (is_array($field)) {

				$line = array();

				foreach ($field as $item) {
					if (!empty($data[$item])) {
						$line[] = $data[$item];
					}
				}

				$address[] = implode(' ', $line);

			} else {

				if (!empty($data[$field])) {
					$address[] = $data[$field];
				}

			}

		}

		$formattedAddress = implode('<br />', $address);

		if (!empty($attributes['tag'])) {
			$tag = $attributes['tag'];
			unset($attributes['tag']);
			$formattedAddress = $this->Html->tag($tag, $formattedAddress, $attributes);
		}

		return $formattedAddress;

	}

}