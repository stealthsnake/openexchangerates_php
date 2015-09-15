# openexchangerates_php
small php lib for open exchange rates

before you start you would need to setup application values on the openexchangerates_config.php. Those values are:

- file = 'latest.json. 
- appId = 'your ApppId'. Your application ID, which you could get on openexchangerates.org;
- $currencies = ["USD","OMR","AED"]. currencies you would like to get value by defualt.  

Include the openexchangerates_config.php into your php file.

How to Use:

To get Single Currency Conversion use the function convert_to(value,"Currency"), the funtion would retun string of Currency value.
e.g convert_to(1,"OMR");


To convert from one Currency value to another use convert_from_to(value,"Currency 1","Currency 2"), this would return string of the Currency 2 value. BTW, this would use your base Currency to do calculation.

e.g. convert_from_to(100,"AED","OMR");

To get Multiable Currency Conversion use convert(value,your_currencies), where
- value: your base currency you would like to convert.
- your_currencies: list of currencies you would like to convert it e.g["USD","OMR","AED"], uf you pass value null, you would get currencies values you define on $currencies. And if the $currencies = null; you would get all currencies provided by openexchangerates.org.


Note:
- this script uses session store values of currencies provided by openexchangerates.org on the time call.