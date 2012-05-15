Ubersmith API layer
MIT License (see LICENSE)

Basically what I intend to do here is make a nice layer for Ubersmith's 2.0 API, as the example shipped with the software is lacking in readability.

```php
<?
require 'ubersmith.php';

$api = new Ubersmith('1.2.3.4', 'apiuser', 'apipass');
$api->client_service_list('{"client_id":1001}')->execute(); # executes client.service_list
print_r($api->result());

```

The example result will more or less be a passthrough from the 2.0 API, it's just the actual implementation stuff above that I want to make easier.
```plain
{
"status":true,
"error_no":null,
"error_msg":"",
"data": "api_data (serialised)"
}
```
