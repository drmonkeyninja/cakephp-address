<?php
/**
 * Helper for easily rendering an address in a View template.
 *
 * e.g. echo $this->Address->format($data['CustomerAddress']);
 */

App::uses('AppHelper', 'View/Helper');

class AddressHelper extends AppHelper {

	public $helpers = array('Html');

	public $defaultFields = array(
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
		'Country.name'
	);

/**
 * Default Constructor
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $View, $settings = array()) {
		$settings['fields'] = !empty($settings['fields']) ? $settings['fields'] : $this->defaultFields;
		parent::__construct($View, $settings);
	}

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
			'tag' => 'address',
			'separator' => '<br />'
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

				if (!empty($line)) {
					$address[] = implode(' ', $line);
				}

			} else {

				$val = Hash::get($data, $field);
				if (!empty($val)) {
					$address[] = $val;
				}

			}

		}

		$formattedAddress = implode($attributes['separator'], $address);

		if (!empty($attributes['tag'])) {
			$tag = $attributes['tag'];
			unset($attributes['tag'], $attributes['separator']);
			$formattedAddress = $this->Html->tag($tag, $formattedAddress, $attributes);
		}

		return $formattedAddress;
	}

}
