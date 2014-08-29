<?php
/*
 * 	This function gets the message label from the existing language.
 *
 * 	when you ask for t('portName'), you will get the result acording to the active language.
 *
 * 	English: This is the Jeddah Port.
 * 	Arabic: هذا هو ميناء جدة.
 *
 */

function t($label, $param1 = false, $param2 = false, $param3 = false) {
	$ci =& get_instance();
	if (!empty($param1))
		$rs = sprintf($ci->lang->line($label), $param1, $param2, $param3);
	else
		$rs = $ci->lang->line($label);
	if ($rs)
		return $rs;
	else
		return $label;
}

function e($str) {
	return base64_encode($str);
}

function d($str) {
	return base64_decode($str);
}

/*function hR($role = '') {
	$ci = & get_instance();
	if ($ci->bitauth->has_role($role)) {
		return true;
	}

	return false;
}*/

function btn($text, $direction ='right', $class="primary", $bsClass='col-md-12'){
	return '
		<div class="form-group text-'.$direction.' margin-bottom-10 margin-top-10">
			<div class="'.$bsClass.'">
				<input type="submit" name="submit" value="'.$text.'" id="submit" class="btn btn-'.$class.'" style="font-weight: bold" sourceindex="10">
			</div>
		</div>';
}

function m($type = "e", $message) {
	$ci = & get_instance();
	if (strlen($type) > 1) {
		$m['messageTitle'] = t($type[0]);
		$m['messageBody']  = $message;
		switch ($type[0]) {
			case 'w':
				$m['messageClass'] = 'alert-warning';
				break;
			case 's':
				$m['messageClass'] = 'alert-success';
				break;
			case '':
				$m['messageClass'] = 'hidden';
				break;
			default:
				$m['messageClass'] = 'alert-danger';
				break;
		}
		if($type[1]=="n"){
			$m['nonAjax'] = 1;
		}
		return $m;
	} else {
		$ci->session->set_flashdata('messageTitle', t($type));
		$ci->session->set_flashdata('messageBody', $message);
	}
}

function mobile_format($mobile) {
	$newMobile = "+" .
		substr($mobile, 0, 3) . '-' . // 966
		substr($mobile, 3, 2) . '-' . // 56
		substr($mobile, 5, 3) . '-' . // 417
		substr($mobile, 8, 4); // 7717
	return $newMobile;
}

function phone_format($phone) {
	$newPhone = substr($phone, 0, 3) . '-' . // 011
		substr($phone, 3, 3) . '-' . // 464
		substr($phone, 6, 4); // 1600
	return $newPhone;
}

function email_format($email, $text) {
	return "<a href='mailto:" . $email . "'>" . $text . "</a>";
}

function dateFormat ($sqlDate, $format = 'd/m/Y'){
	$datetime = strtotime($sqlDate);
	return date($format, $datetime);
}

function icon ($color='success', $icon= 'user'){
	return '<span class="glyphicon glyphicon-'.$icon.' text-'.$color.'"></span>';
}

function titleAlt($text){
	return array('title'=> $text, 'alt'=> $text);
}

function array_unshift_assoc(&$arr, $key, $val)
{
    $arr = array_reverse($arr, true);
    $arr[$key] = $val;
    $arr = array_reverse($arr, true);
}

function submit_url() {
	//$current_url = current_url();
	return str_replace('/create', '/submit', current_url());
}










function options($data, $groupField) {
	$flag            = 0;
	$options[""]     = array("");
	$groupFieldLabel = '';

	foreach ($data as $key => $row) {

		if ($groupFieldLabel != $row->$groupField) {
			$flag = 0;
		}
		if (!empty($groupField) and $flag == 0) {
			$groupFieldLabel           = $row->$groupField;
			$options[$groupFieldLabel] = array();
			$flag                      = 1;
		}

		$options[$groupFieldLabel][$row->id] = $row->Variant . ' - ' . $row->Model_Year . ' ' . $row->Description;

	}

	return $options;
}

/**
 * Alpha space
 *
 * @access	public
 * @param	string
 * @return	bool
 */
function alpha_space($str)
{
	return ( ! preg_match("/^([a-z ])+$/i", $str)) ? FALSE : TRUE;
}

/*function theOptions($data, $groupField){
	$flag = 0;
	$options[""] = array("");

	foreach ($data as $key => $row) {

		if(!empty($groupField) and $flag == 0){
			$groupFieldLabel = $row->$groupField;
			$options[$groupFieldLabel] = array();
			$flag = 1;
		}

		$options[$groupFieldLabel][$row->id] = $row->Variant.' - '.$row->Model_Year.' '.$row->Description;

		if($groupFieldLabel != $row->$groupField){
			$flag = 0;
		}
	}
	return $options;
}*/

function appRequestMail($to, $quoteId, $from = false, $subject = "AUMCRM - Message regarding a quotation", $msg = '') {
	$ci = & get_instance();
	if (isset($from->email))
		$ci->email->from($from['email'], $from['fullname']);
	else
		$ci->email->from('admin@aumcrm.com', 'Administrator');

	$ci->email->to($to);
	$ci->email->subject($subject);

	$message = "Dear " . $to['fullname'] . "\n\nClick on the link bellow to " . $msg . ": \n" .
		$ci->config->base_url() . "quotations/edit/" . $quoteId . "\n\n\n" .
		"AUMCRM.Com System";
	$ci->email->message($message);

	if ($subject == 'AUMCRM - Request for Discount') {
		$comment = t('requestCommentMail', $to['fullname']);
		$insert  = $ci->comment_m->_addComment($quoteId, $comment);
	}

	return $ci->email->send();
}

function signRequestMail($to, $quoteId, $from = false, $subject = "AUMCRM - Request for Signature") {
	$ci = & get_instance();
	if (isset($from->email))
		$ci->email->from($from->email, $from->fullname);
	else
		$ci->email->from('admin@aumcrm.com', 'Administrator');

	$ci->email->to($to['email']);

	$ci->email->subject($subject);

	$message = "Dear " . $to['fullname'] . ",\n" .
		"Click on the link bellow to sign the quotation: \n" .
		$ci->config->base_url() . "quotations/edit/" . $quoteId . "\n\n\n" .
		"AUMCRM.Com System";

	$ci->email->message($message);

	return $ci->email->send();
}

function badge($string, $color, $type = 'colors', $name = '') {
	switch ($type) {
		case 'colors':
			$colors = array('default' => 'default', 'primary' => 'primary', 'success' => 'success', 'info' => 'info', 'warning' => 'warning', 'danger' => 'danger', 'off' => 'off');
			break;
		case 'status':
			$colors = array('New' => 'warning', 'Discount Requested' => 'info', 'Partially Approved' => 'success', 'Approved' => 'success', 'Declined' => 'danger', 'Signed' => 'warning', 'Submitted' => 'success', 'Ready to Submit' => 'primary');
			break;
		case 'level':
			$colors = array('0' => 'off', '1' => 'danger', '2' => 'warning', '3' => 'primary', '4' => 'info', '5' => 'success', '32' => 'off');
			break;
		default:
			$colors = array('default' => 'default');
			break;
	}

	$c = in_array($color, array_keys($colors)) ? $colors[$color] : 'default';
	if ($type == 'level') {
		$class  = 'signatures';
		$return = '<span class="' . $class . ' label label-' . $c . '" data-toggle="tooltip" title="' . $name . '" data-placement="left">' . $string . '</span>';
	} else
		$return = '<span class="label label-' . $c . '">' . $string . '</span>';

	return $return;
}

function alphaID($in, $to_num = false, $pad_up = false, $pass_key = null) {
	$out      = '';
	$index    = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$base     = strlen($index);
	$pass_key = 'kasjdf j239854#$rusfjsldfw!ret873%$498572wf&hjslg_0943-e10qieadjfskjg';

	if ($pass_key !== null) {
		// Although this function's purpose is to just make the
		// ID short - and not so much secure,
		// with this patch by Simon Franz (http://blog.snaky.org/)
		// you can optionally supply a password to make it harder
		// to calculate the corresponding numeric ID

		for ($n = 0; $n < strlen($index); $n++) {
			$i[] = substr($index, $n, 1);
		}

		$pass_hash = hash('sha256', $pass_key);
		$pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

		for ($n = 0; $n < strlen($index); $n++) {
			$p[] = substr($pass_hash, $n, 1);
		}

		array_multisort($p, SORT_DESC, $i);
		$index = implode($i);
	}

	if ($to_num) {
		// Digital number  <<--  alphabet letter code
		$len = strlen($in) - 1;

		for ($t = $len; $t >= 0; $t--) {
			$bcp = bcpow($base, $len - $t);
			$out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
		}

		if (is_numeric($pad_up)) {
			$pad_up--;

			if ($pad_up > 0) {
				$out -= pow($base, $pad_up);
			}
		}
	} else {
		// Digital number  -->>  alphabet letter code
		if (is_numeric($pad_up)) {
			$pad_up--;

			if ($pad_up > 0) {
				$in += pow($base, $pad_up);
			}
		}

		for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
			$bcp = bcpow($base, $t);
			$a   = floor($in / $bcp) % $base;
			$out = $out . substr($index, $a, 1);
			$in  = $in - ($a * $bcp);
		}
	}

	return $out;
}

function convert_number_to_words($number) {

	$hyphen      = '-';
	$conjunction = ' and ';
	$separator   = ', ';
	$negative    = 'negative ';
	$decimal     = ' point ';
	$dictionary  = array(
		0                   => 'zero',
		1                   => 'One',
		2                   => 'Two',
		3                   => 'Three',
		4                   => 'Four',
		5                   => 'Five',
		6                   => 'Six',
		7                   => 'Seven',
		8                   => 'Eight',
		9                   => 'Nine',
		10                  => 'Ten',
		11                  => 'Eleven',
		12                  => 'Twelve',
		13                  => 'Thirteen',
		14                  => 'Fourteen',
		15                  => 'Fifteen',
		16                  => 'Sixteen',
		17                  => 'Seventeen',
		18                  => 'Eighteen',
		19                  => 'Nineteen',
		20                  => 'Twenty',
		30                  => 'Thirty',
		40                  => 'Fourty',
		50                  => 'Fifty',
		60                  => 'Sixty',
		70                  => 'Seventy',
		80                  => 'Eighty',
		90                  => 'Ninety',
		100                 => 'Hundred',
		1000                => 'Thousand',
		1000000             => 'Million',
		1000000000          => 'Billion',
		1000000000000       => 'Trillion',
		1000000000000000    => 'Quadrillion',
		1000000000000000000 => 'Quintillion'
	);

	if (!is_numeric($number)) {
		return false;
	}

	if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
// overflow
		trigger_error(
			'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
			E_USER_WARNING
		);

		return false;
	}

	if ($number < 0) {
		return $negative . convert_number_to_words(abs($number));
	}

	$string = $fraction = null;

	if (strpos($number, '.') !== false) {
		list($number, $fraction) = explode('.', $number);
	}

	switch (true) {
		case $number < 21:
			$string = $dictionary[$number];
			break;
		case $number < 100:
			$tens   = ((int) ($number / 10)) * 10;
			$units  = $number % 10;
			$string = $dictionary[$tens];
			if ($units) {
				$string .= $hyphen . $dictionary[$units];
			}
			break;
		case $number < 1000:
			$hundreds  = $number / 100;
			$remainder = $number % 100;
			$string    = $dictionary[$hundreds] . ' ' . $dictionary[100];
			if ($remainder) {
				$string .= $conjunction . convert_number_to_words($remainder);
			}
			break;
		default:
			$baseUnit     = pow(1000, floor(log($number, 1000)));
			$numBaseUnits = (int) ($number / $baseUnit);
			$remainder    = $number % $baseUnit;
			$string       = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
			if ($remainder) {
				$string .= $remainder < 100 ? $conjunction : $separator;
				$string .= convert_number_to_words($remainder);
			}
			break;
	}

	if (null !== $fraction && is_numeric($fraction)) {
		$string .= $decimal;
		$words = array();
		foreach (str_split((string) $fraction) as $number) {
			$words[] = $dictionary[$number];
		}
		$string .= implode(' ', $words);
	}

	return $string;
}

function brs($number=1){

	for ($i=0; $i < $number; $i++) {
		echo '<br />'."\n";
	}
}





/*class Cipher {
	private $securekey, $iv;
	function __construct($textkey) {
		$this->securekey = hash('sha256',$textkey,TRUE);
		$this->iv = mcrypt_create_iv(32);
	}
	function encrypt($input) {
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->securekey, $input, MCRYPT_MODE_ECB, $this->iv));
	}
	function decrypt($input) {
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->securekey, base64_decode($input), MCRYPT_MODE_ECB, $this->iv));
	}
}*/
