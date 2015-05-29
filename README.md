# Meta
A PHP 5.4 Page-Meta Container that is easily extensible

Installation & Requirements
---------------------------
This package requires PHP 5.4 or above. To install, simply add this line to
your `composer.json` file under the require key

```json
"require": {
    "coreplex/meta": "0.*"
}
```

Laravel Integration
-------------------
To use this package with Laravel, just take the following steps after
installation:

Add the service provider to the providers array in your `config/app.php` file

```php
'Coreplex\Meta\MetaServiceProvider',
```

You then need to publish the required assets using the command line. Run this
command to provision this action

```shell
php artisan vendor:publish --provider="Coreplex\Meta\MetaServiceProvider"
```

You will then want to migrate the database tables which will act as a store
for any meta items

```shell
php artisan migrate
```

Once you've done this, you can go ahead and start using the package, and
populating the database with some example meta information.

To start, let's add in a default meta group to see it in action. Run this piece
of code to create a default piece of meta:

```php
$meta = Coreplex\Meta\Eloquent\Meta::create([
    'identifier' => 'default',
    'default' => true
]);

$meta->items()->insert(['key' => 'title', 'data' => 'Welcome to this website']);
$meta->items()->insert(['key' => 'description', 'data' => 'This is a fantastic website with lots of features and even a walrus gallery']);
```

This will insert the default meta record into the database, which will be used
on every single page, with any addition records merged on top (unless it is
overwritten, which is easy to do!). You don't have to do this, but it is a nice
way to add a default set of meta data.

To render the meta data in your view, all you have to do is echo out the meta
container that is bound to the app, and it will be turned into clean html.

```php
<html>
<head>
<?php
// You will probably want to use a view composer for this line, as it is
// actually bad practice!
$meta = $app['coreplex.meta'];

// Render the meta items from the container
echo $meta;
?>
</head>
<body>
</body>
</html>
```

Using default configuration, this would output:

```html
<title>Welcome to this website | MyWebsite.com</title>
<meta name="description" content="This is a fantastic website with lots of features and even a walrus gallery">
```

> Don't forget, if you are using laravel blade, you must use the non-escaping
> blade echo tags (`{!! !!}`) or the meta will not be output correctly.

If you want to completely overwrite the meta, retrieve the meta container from
your application and use the `set()` method to override it. You can pass in
an instance of a `Coreplex\Meta\Contracts\Group` (The `Coreplex\Meta\Eloquent\Meta`
model implements this), or just a string identifier which will be used to find
it from the store.

```php
$meta = Coreplex\Meta\Eloquent\Meta::create([
    'identifier' => 'login_page'
]);

$meta->items()->insert(['key' => 'title', 'data' => 'Please login to your account...']);
```

```php
use Coreplex\Meta\Contracts\Container as MetaContainer;

class LoginController extends Controller {
    
    public function login(MetaContainer $container)
    {
        $container->set('login_page');
    }

}
```

Will then output this to the page when the meta is echoed out:

```html
<title>Please login to your account... | MyWebsite.com</title>
```

If you only wish to merge but not overwrite the default styles, instead use the
`add()` method on the container.

```php
    public function login(MetaContainer $container)
    {
        $container->add('login_page');
    }
```

Which will then output a merged variant of the two meta groups we inserted

```html
<title>Please login to your account... | MyWebsite.com</title>
<meta name="description" content="This is a fantastic website with lots of features and even a walrus gallery">
```

You can merge as many meta groups together, keeping in mind that the group
which was last merged will overwrite any meta items that precede it which it
also has

Configurating Meta Templates
----------------------------

The meta library knows how to render out each type of meta element differently.
It does this through the config file.

In your config folder, you will find `meta.php` and `drivers.php`. Inside
meta.php, you will see something similar to this:

```php
    'elements' => [
        'title' => [
            'element' => 'title',
            'empty' => false,
            'content' => ':content | MyWebsite.com',
        ],
        'charset' => [
            'keyAttribute' => false,
            'valueAttribute' => 'charset'
        ]
    ],
```

This array defines how every element is display on the page. Here are each of
the configuration keys you can use on each element:

- **element**: Specifies which element will be rendered, for example, a value of `title` would render a `<title>` element. This is required
- **empty**: Specifies whether or not the element has an opening or closing tag. If set to `false`, the element will always add an ending tag of the element specified
- **keyAttribute**: Specifies if an attribute is applied to the element which holds the value of the key of the meta. For example, if you have a `description` element, you would usually set the `keyAttribute` property to `name`, as this would output `<meta name="description" content="..."></meta>` on the page. If set to false, no attribute will be added with the meta key
- **valueAttribute**: Same behaviour as the `keyAttribute` property, except it places the "data" value of the meta item isntance into this attribute.
- **content**: Allows you to create a template for a meta item. Especially useful when you want to add something like " | MyWebsite.com" after a title. Simply use `:content` within the string, and this will be replaced with the data value of the meta item when rendered. If your meta item has JSON Encoded data, and `empty` is set to false, you can use the `:` identifier followed by any of the keys in the JSON object to replace it with the value.
- **extends**: Works like class extension, where you specify the key of another meta element template, and it will merge it's own properties into the one it is extending. Especially useful so that you don't repeat yourself with elements like 'og:title'. You can see examples of this by looking into the default config provided

If there is no template for the key specified in the meta_items table, it will use the `meta.default` value as the template, which by default renders a `<meta name="{key}" content="{data}">` element, unless you choose to change this behaviour.

More data in a single meta item
--------------------------------

If a meta is empty (has no closing tag), and the string in the "data" column of the meta_items record is JSON encoded, it will loop around each key and put it in as an attribute:

```php
$meta = Coreplex\Meta\Eloquent\Meta::create([
    'identifier' => 'new_page'
]);

$meta->items()->insert(['key' => 'keywords', 'data' => '{content: "hello world", rel: "keywords-tag"}']);
```

Would yield this when rendered

```html
<meta name="keywords" content="hello world" rel="keywords-tag">
```

You can just pass a standard string to the data column if you don't want multiple
attributes.

Non-Laravel Usage
-----------------
A non-laravel usage guide isn't currently available. If you are however
integrating with Laravel 5, follow the above steps