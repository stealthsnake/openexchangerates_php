<?php

session_start();
// Requested file
// Could also be e.g. 'currencies.json' or 'historical/2011-01-01.json'

$file = 'latest.json';
$appId = '7b4ce7951de14ac0a55fc61471a021ab';
$currencies = ["USD","OMR","AED"];
$exchangeRates="null";
$base_currency = null;

	if(!isset($_SESSION['exchangeRates']))
	{
		$ch = curl_init("http://openexchangerates.org/api/".$file."?app_id=".$appId);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$json = curl_exec($ch);
		curl_close($ch);

		$exchangeRates = json_decode($json);
		$_SESSION['exchangeRates'] = $exchangeRates;
	}else{
		$exchangeRates = $_SESSION['exchangeRates'];
	}

/* function for Single-Currency Conversion to your base currency */
function convert_to($value=1,$to="OMR")
{
	global $exchangeRates;
	$currency1 = $exchangeRates->rates->$to;

	return $value * $currency1;


}

/* function to covert for one currnecy to another, using your base Currency as base to convert to
e.g currency 1 to base Currency to currency 2 */

function convert_from_to($value=1,$from,$to)
{
	global $exchangeRates;

	if($from!=$exchangeRates->base)
	{
		$base_currency = convert_to($value,$from);
		$return_currency = convert_to($base_currency,$to);

	}else{
		$return_currency = convert_to($value,$to);
	}
	return $return_currency;
}


/* get values of other currencies base on your base Currency
e,g 5.25 USD to other currencies values

you can set specific currencies by using predefined values on $currencies above
or set value of your_currencies when calling function
e.g = ["USD","OMR","AED"] 

if $currencies and $your_currencies are quual to null, it could convert to 
all currencies provided by openexchangerates.org */

function convert($currency_value=1,$your_currencies=null)
{
	global $exchangeRates, $currencies;


	if(isset($your_currencies)){
		$list_currencies = $your_currencies;
	}elseif (isset($currencies)){
		$list_currencies = $currencies;
	}else{
		$list_currencies = (array)$exchangeRates->rates;
	}

	foreach ($list_currencies as $key => $value) {
		if(is_assoc($list_currencies))
			$return_list[$key] = convert_to($currency_value,$key);
		else
			$return_list[$value] = convert_to($currency_value,$value);

	}
	return ($return_list);

}

function is_assoc(array $array)
{
    // Keys of the array
    $keys = array_keys($array);

    // If the array keys of the keys match the keys, then the array must
    // not be associative (e.g. the keys array looked like {0:0, 1:1...}).
    return array_keys($keys) !== $keys;
}


function get_rates()
{
	global $exchangeRates;

	return $exchangeRates->rates->AED;
}