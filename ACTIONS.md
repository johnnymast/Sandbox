# Excute action with callback

```php
function func_hello_world($text) {
    echo $text."\n";
}
Sandbox\Actions::add_action('hello_world', 'func_hello_world');
Sandbox\Actions::do_action('hello_world', 'Hello World');
```

***Output***

```bash
$ php ./actions.php
Hello World
```

#Actions with closures

```php
Sandbox\Actions::add_action('hello_world', function () {
    echo "The callback is called\n";
});
Sandbox\Actions::do_action('hello_world');
```
***Output***

```bash
$ php ./actions.php
The callback is called
```

#Actions with priority

```php
function func_second($text) {
    echo "Called second\n";
}

function func_first($text) {
    echo "Called first\n";
}

Sandbox\Actions::add_action('say_hello', 'func_second', 1);
Sandbox\Actions::add_action('say_hello', 'func_first', 0);
Sandbox\Actions::do_action('say_hello');
```

***Output***

```bash
$ php ./actions.php
Called first
Called second
```

