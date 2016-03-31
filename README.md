# Sandbox
[![Build Status](https://travis-ci.org/johnnymast/Sandbox.svg?branch=master)](https://travis-ci.org/johnnymast/Sandbox)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/johnnymast/Sandbox/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/Sandbox/?branch=master)
[![Twitter URL](https://img.shields.io/twitter/url/http/shields.io.svg?style=social&label=Contact author)](https://twitter.com/intent/tweet?text=@mastjohnny)

Xxx allow you use Wordpress actions and filters in your own code. The syntax is easy to use as you expect it to be after seeing it in Wordpress it self.

***Have a look at***
* [Filters](FILTERS.md)
* [Actions](ACTIONS.md)

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

#Chaining actions

```php
Sandbox\Actions::add_action('say_hi', function($name='') {
    echo "Hi: ".$name."\n";
});

Sandbox\Actions::add_action('say_bye', function($name='') {
    echo "Bye: ".$name."\n";
});

Sandbox\Actions::do_action(['say_hi', 'say_bye'], 'GitHub');
```

```bash
$ php ./actions.php
Hi: GitHub
Bye: GitHub
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
