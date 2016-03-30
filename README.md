# Sandbox

Xxx allow you use Wordpress actions and filters in your own code. The syntax is easy to use as you expect it to be after seeing it in Wordpress it self.


* [Filters](FILTERS.md)


# Chaining filters

```php
Sandbox\Filters::add_filter('prepend_at', function($text='') {
    return '@@'.$text;
});

Sandbox\Filters::add_filter('append_at', function($text='') {
    return $text.'@@';
});


$out = Sandbox\Filters::apple_filter(['prepend_at', 'append_at'], 'This is a text');
echo "Output: ".$out."\n";
```

***Output***

```bash
$ php ./functions.php
Output: @@This is a text@@

```

## Requirements

The following versions of PHP are supported by this version.

+ PHP 5.4
+ PHP 5.5
+ PHP 5.6
+ HHVM

## Author

This package is created and maintained by [Johnny Mast](https://github.com/johnnymast).

## License

xxx is released under the MIT public license.

[LICENSE](LICENSE.md)