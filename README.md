# Sandbox
[![Build Status](https://travis-ci.org/johnnymast/Sandbox.svg?branch=master)](https://travis-ci.org/johnnymast/Sandbox)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/johnnymast/Sandbox/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/Sandbox/?branch=master)
[![Twitter URL](https://img.shields.io/twitter/url/http/shields.io.svg?style=social&label=Contact author)](https://twitter.com/intent/tweet?text=@mastjohnny)

Xxx allow you use Wordpress actions and filters in your own code. The syntax is easy to use as you expect it to be after seeing it in Wordpress it self.

***Have a look at***
* [Filters](FILTERS.md)
* [Actions](ACTIONS.md)

#Fun fact
I a am not a TDD guy but 50% of this code was written with the TDD concept in mind. Actually i was pretty mutch surprised on how it worked out and the speed the development came in.

# Chaining filters

```php
Sandbox\Filters::add_filter('prepend_at', function($text='') {
    return '@@'.$text;
});

Sandbox\Filters::add_filter('append_at', function($text='') {
    return $text.'@@';
});


$out = Sandbox\Filters::apply_filter(['prepend_at', 'append_at'], 'This is a text');
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

+ PHP 5.6
+ PHP 7.0
+ PHP 7.1
+ HHVM

## Author

This package is created and maintained by [Johnny Mast](https://github.com/johnnymast).

## License

The MIT License (MIT)

Copyright (c) 2016 Johnny Mast

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

