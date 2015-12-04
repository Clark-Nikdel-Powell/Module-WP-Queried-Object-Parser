## Queried Object Parser

Provides shorthand access to a standard description of the WordPress object being requested.

## Filter

You can filter the output with the hook `cnp_queried_object_filter` like so:

```php
add_filter( 'cnp_queried_object_filter', 'function_to_filter_output' );
```

### Usage

```php
$object = cnp_parse_queried_object();
```

### Return Values

```php
(stdClass) [
    type      -> '',
    wp_object -> '',
    slug      -> '',
    ID        -> 0
]
```
