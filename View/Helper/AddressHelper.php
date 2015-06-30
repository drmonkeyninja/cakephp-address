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
 * @param array $fields array of field names to use for address
 * @param array $attributes options
 * @return string
 */
	public function format($data, $fields = null, $attributes = array()) {
		$defaults = array(
			'tag' => 'address'
		);

		$attributes = array_merge($defaults, $attributes);

		$address = array();

		$fields = !empty($fields) && is_array($fields) ? $fields : $this->settings['fields'];

		foreach ($fields as $field) {

			if (is_array($field)) {

				$line = array();

				foreach ($field as $item) {
					$val = Hash::get($data, $item);
					if (!empty($val)) {
						$line[] = $val;
					}
				}

				$address[] = implode(' ', $line);

			} else {

				$val = Hash::get($data, $field);
				if (!empty($val)) {
					$address[] = $val;
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
