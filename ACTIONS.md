# Excute action with callback

```php
function func_hello_world($text='') {
    echo "Hello World\n";
}
Sandbox\Actions::add_action('hello_world', 'func_hello_world');
Sandbox\Actions::do_action('hello_world');
```

***Output***

```bash
$ php ./actions.php
Hello World
```