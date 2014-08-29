<?php
/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 *
 * @author  Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
	function dump($var, $label = 'Dump', $echo = TRUE) {
		// Store dump in variable
		ob_start();
		var_dump($var);
		$output = ob_get_clean();

		// Add formatting
		$output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
		$output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';

		// Output
		if ($echo == TRUE) {
			echo $output;
		} else {
			return $output;
		}
	}
}


if (!function_exists('dump_exit')) {
	function dump_exit($var, $label = 'Dump', $echo = TRUE) {
		dump($var, $label, $echo);
		exit;
	}
}

/**
 * Filter input based on a whitelist. This filter strips out all characters that
 * are NOT:
 * - letters
 * - numbers
 * - Textile Markup special characters.
 *
 * Textile markup special characters are:
 * _-.*#;:|!"+%{}@
 *
 * This filter will also pass cyrillic characters, and characters like é and ë.
 *
 * Typical usage:
 * $string = '_ - . * # ; : | ! " + % { } @ abcdefgABCDEFG12345 éüртхцчшщъыэюьЁуфҐ ' . "\nAnd another line!";
 * echo textile_sanitize($string);
 *
 * @param string $string
 * @return string The sanitized string
 * @author Joost van Veen
 */
/*function textile_sanitize($string){
	$whitelist = '/[^a-zA-Z0-9а-яА-ЯéüртхцчшщъыэюьЁуфҐ \.\*\+\\n|#;:!"%@{} _-]/';
	return preg_replace($whitelist, '', $string);
}

function escape($string){
	return textile_sanitize($string);
}*/

function log_file($message, $other = Null) {
	$ci = & get_instance();
	log_message('error', $ci->router->class . '/' . $ci->router->method . ' - ' . $message . ' - ' . $ci->agent->referrer());

	return;
}


							/*function allowed_to($role) {
								$ci = & get_instance();
								if (!$ci->bitauth->logged_in()) {
									$ci->session->set_userdata('redir', current_url());
									redirect('/login');
								}
								if (is_array($role)) {
									$i = count($role);
									for ($x = 0; $x < $i; $x++) {
										if ($ci->bitauth->has_role($role[$x])) {
											return true;
										}
									}

									return false;
								} else {
									if (!$ci->bitauth->has_role($role)) {
										return false;
									}

									return true;
								}


							}*/
