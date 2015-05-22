<?php
App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('AddressHelper', 'Address.View/Helper');

class AddressHelperTest extends CakeTestCase {

	public function setUp() {
		parent::setUp();
		$Controller = new Controller();
		$View = new View($Controller);
		$this->Address = new AddressHelper($View);
	}

	public function testFormat() {
		// Test basic address format
		$address = array(
			'house_name' => 'Winter Gardens',
			'address_line_1' => '90 Surrey Street',
			'city' => 'Sheffield',
			'county' => 'South Yorkshire',
			'postcode' => 'S1 2LH'
		);
		$expected = '<address>Winter Gardens<br />90 Surrey Street<br />Sheffield<br />South Yorkshire<br />S1 2LH</address>';
		$this->assertEquals($expected, $this->Address->format($address));

		// Test overridding of field names
		$fields = array(
			'address_line_1',
			'city',
			'postcode'
		);
		$expected = '<address>90 Surrey Street<br />Sheffield<br />S1 2LH</address>';
		$this->assertEquals($expected, $this->Address->format($address, $fields));

		// Test address format with combined fields
		$address = array(
			'house_number' => '221B',
			'address_line_1' => 'Baker Street',
			'address_line_2' => 'Marylebone',
			'city' => 'London',
			'postcode' => 'NW1 6XE'
		);
		$expected = '<address>221B Baker Street<br />Marylebone<br />London<br />NW1 6XE</address>';
		$this->assertEquals($expected, $this->Address->format($address));

		// Test class attribute on address tag
		$expected = '<address class="delivery-address">221B Baker Street<br />Marylebone<br />London<br />NW1 6XE</address>';
		$this->assertEquals($expected, $this->Address->format($address, null, array('class' => 'delivery-address')));

		// Test non-wrapped address
		$expected = '221B Baker Street<br />Marylebone<br />London<br />NW1 6XE';
		$this->assertEquals($expected, $this->Address->format($address, null, array('tag' => false)));

		return;
	}

}
