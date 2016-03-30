# Sandbox


# Filters callback functions

```php
function func_prepend_at($text='') {
    return '@@'.$text;
}
Sandbox\Filters::add_filter('prepend_at', 'func_prepend_at');

$out = Sandbox\Filters::apple_filter(['prepend_at', 'append_at'], 'This is a text');
echo "Output: ".$out."\n";
```
***Output***

```bash
$ php ./functions.php
Output: @@This is a text
```

