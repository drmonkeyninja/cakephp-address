CakePHP Address
===============

[![License](https://poser.pugx.org/drmonkeyninja/cakephp-address/license.png)](https://packagist.org/packages/drmonkeyninja/cakephp-address) [![Build Status](https://travis-ci.org/drmonkeyninja/cakephp-address.svg)](https://travis-ci.org/drmonkeyninja/cakephp-address)

This plugin provides a CakePHP 2 View helper for formatting addresses.


Installation
------------

This plugin can be installed using Composer:-

    composer require drmonkeyninja/cakephp-address

Alternatively copy the plugin to your app/Plugin directory and rename the plugin's directory 'Address'.

Then add the following line to your bootstrap.php to load the plugin.

    CakePlugin::load('Address');


Usage
-----

### AddressHelper::format(array $address, array $fields=null, array $options=array())

Returns a formatted address with line breaks:-

    $data['CustomerAddress'] = array(
            'house_name' => 'Winter Gardens',
            'house_number' => '90',
            'address_line_1' => 'Surrey Street',
            'city' => 'Sheffield',
            'county' => 'South Yorkshire',
            'postcode' => 'S1 2LH'
        );
    echo $this->Address->format($data['CustomerAddress']);

Output:-

    <address>Winter Gardens<br />90 Surrey Street<br />Sheffield<br />South Yorkshire<br />S1 2LH</address>

You can define the field names to be used for the address by passing an array of field names as the second parameter:-

    $fields =array(
        'address_line_1',
        'city',
        'postcode'
    );
    echo $this->Address->format($data['CustomerAddress'], $fields);

Output:-

    <address>90 Surrey Street<br />Sheffield<br />S1 2LH</address>

You can change the wraptag using the tag option in the third parameter and set other attributes like class:-

    echo $this->Address->format($data['CustomerAddress'], $fields, array('tag' => 'div', 'class' => 'address'));

Output:-

    <div class="address">90 Surrey Street<br />Sheffield<br />S1 2LH</div>

The field names support the Hash direct path syntax so that you can use slightly more complex address arrays with the formatter. For example, we can handle an associated Country model like this:-

    $data['CustomerAddress'] = array(
        'house_name' => 'Winter Gardens',
        'address_line_1' => '90 Surrey Street',
        'city' => 'Sheffield',
        'postcode' => 'S1 2LH',
        'Country' => array(
            'name' => 'United Kingdom'
        )
    );
    $fields = array(
        'house_name',
        'address_line_1',
        'city',
        'postcode',
        'Country.name'
    );
    echo $this->Address->format($data['CustomerAddress'], $fields);

Output:-

    <address>Winter Gardens<br />90 Surrey Street<br />Sheffield<br />S1 2LH<br />United Kingdom</address>

You can change the output markup by passing values for `tag` and `separator`:-

	echo $this->Address->format($data['CustomerAddress'], $fields, array('tag' => 'p', 'separator' => ', '));

Output:-

    <p>Winter Gardens, 90 Surrey Street, Sheffield, S1 2LH, United Kingdom</p>
