### Example Usage

#### Create an instance of the DnsMadeEasy class

```php
// log into your DNS Made Easy account to generate/obtain your API key and secret key.
// specify TRUE for the last parameter if you want to make test API calls.
$dme = new DnsMadeEasy('yourApiKey', 'yourSecretKey', TRUE);

#### Adding a domain

```
php $result = $dme->domains->add('foobar.com');

if ($errors = $result->errors()) {
	print_r($errors);
}
else {
	// outputs the raw results
	print_r($result->rawBody());

	// grab the JSON decoded results.
	// use TRUE to return an associative array, FALSE to return an object.
	$domain = $result->body(FALSE);

	// output the name servers associated with this domain.
	print_r($domain->nameServer);
}
```

#### Adding a DNS record

```php
$record = array(
	'name' => '',
	'type' => 'A',
	'data' => '2.4.8.16',
	'ttl' => 1800,
);

$result = $dme->records->add('foobar.com', $record);

if ($errors = $result->errors()) {
	print_r($errors);
}
else {
	// grab the JSON decoded results.
	// use TRUE to return an associative array, FALSE to return an object.
	$record = $result->body(FALSE);

	// output the assigned record ID
	print_r($record->id);
}
```