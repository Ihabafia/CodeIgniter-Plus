<?php
/**
 * A base model with a series of CRUD functions (powered by CI's query builder),
 * validation-in-model support, event callbacks and more.
 *
 * @link      http://github.com/jamierumbelow/codeigniter-base-model
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */


function form_hidden($name, $value = '', $prop = '', $recursing = FALSE) {
	static $form;

	if ($recursing === FALSE) {
		$form = "\n";
	}

	if (is_array($name)) {
		foreach ($name as $key => $val) {
			form_hidden($key, $val, $prop, TRUE);
		}

		return $form;
	}

	if (!is_array($value)) {
		$form .= '<input type="hidden" name="' . $name . '" value="' . form_prep($value, $name) . '" ' . $prop . ' />' . "\n";
	} else {
		foreach ($value as $k => $v) {
			$k = (is_int($k)) ? '' : $k;
			form_hidden($name . '[' . $k . ']', $v, $prop, TRUE);
		}
	}

	return $form;
}

function form_input($data = '', $value = '', $extra = '') {
	$defaults = array('type' => 'text', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	return "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
}

function form_input_date($data = '', $value = '', $extra = '') {
	$defaults = array('type' => 'date', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	return "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
}

function form_input_dateTime($data = '', $value = '', $extra = '') {
	$defaults = array('type' => 'datetime-local', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	return "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
}

function form_input_email($data = '', $value = '', $extra = '') {
	$defaults = array('type' => 'email', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	return "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
}

function form_input_number($data = '', $value = '', $extra = '') {
	$defaults = array('type' => 'number', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	return "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
}

function form_input_range($data = '', $value = '', $extra = '') {
	$defaults = array('type' => 'range', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	return "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
}

function form_input_phone($data = '', $value = '', $extra = '') {
	$defaults = array('type' => 'tel', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	return "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
}

/******************************************************************************
 *                                Form Fields for BootStrap                                        *
 *******************************************************************************/
function form_input_b($data = '', $value = '', $col = '12', $extra = '') {
	$defaults = array('type' => 'text', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	$field = "<div class='col-sm-$col'>";
	$field .= "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
	$field .= "</div>";

	return $field;
}

function form_input_date_b($data = '', $value = '', $col = '12', $extra = '') {
	$defaults = array('type' => 'date', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	$field = "<div class='col-sm-$col'>";
	$field .= "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
	$field .= "</div>";

	return $field;
}

function form_input_dateTime_b($data = '', $value = '', $col = '12', $extra = '') {
	$defaults = array('type' => 'datetime-local', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	$field = "<div class='col-sm-$col'>";
	$field .= "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
	$field .= "</div>";

	return $field;
}

function form_input_email_b($data = '', $value = '', $col = '12', $extra = '') {
	$defaults = array('type' => 'email', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	$field = "<div class='col-sm-$col'>";
	$field .= "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
	$field .= "</div>";

	return $field;
}

function form_input_number_b($data = '', $value = '', $col = '12', $extra = '') {
	$defaults = array('type' => 'number', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	$field = "<div class='col-sm-$col'>";
	$field .= "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
	$field .= "</div>";

	return $field;
}

function form_input_range_b($data = '', $value = '', $col = '12', $extra = '') {
	$defaults = array('type' => 'range', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	$field = "<div class='col-sm-$col'>";
	$field .= "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
	$field .= "</div>";

	return $field;
}

function form_input_phone_b($data = '', $value = '', $col = '12', $extra = '') {
	$defaults = array('type' => 'tel', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	$field = "<div class='col-sm-$col'>";
	$field .= "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
	$field .= "</div>";

	return $field;
}

function form_password_b($data = '', $value = '', $col = '12', $extra = '') {
	if (!is_array($data)) {
		$data = array('name' => $data);
	}

	$data['type'] = 'password';

	return form_input_b($data, $value, $col, $extra);
}

function form_dropdown_b($name = '', $options = array(), $selected = array(), $col = '12', $extra = '') {
	if (!is_array($selected)) {
		$selected = array($selected);
	}

	// If no selected state was submitted we will attempt to set it automatically
	if (count($selected) === 0) {
		// If the form name appears in the $_POST array we have a winner!
		if (isset($_POST[$name])) {
			$selected = array($_POST[$name]);
		}
	}

	if ($extra != '') $extra = ' ' . $extra;

	$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

	$form = "<div class='col-sm-$col'>\n";

	$form .= '<select name="' . $name . '"' . $extra . $multiple . ">\n";

	foreach ($options as $key => $val) {
		$key = (string) $key;

		if (is_array($val) && !empty($val)) {
			$form .= '<optgroup label="' . $key . '">' . "\n";

			foreach ($val as $optgroup_key => $optgroup_val) {
				$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

				$form .= '<option value="' . $optgroup_key . '"' . $sel . '>' . (string) $optgroup_val . "</option>\n";
			}

			$form .= '</optgroup>' . "\n";
		} else {
			$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

			$form .= '<option value="' . $key . '"' . $sel . '>' . (string) $val . "</option>\n";
		}
	}

	$form .= "</select>\n";
	$form .= "</div>\n";

	return $form;
}

function form_submit_b($data = '', $value = '', $col = '12', $extra = '') {
	$defaults = array('type' => 'submit', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

	$field = "<div class='col-sm-$col'>";
	$field .= "<input " . _parse_form_attributes($data, $defaults) . $extra . " />";
	$field .= "</div>";

	return $field;
}


