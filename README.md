# Bridge - Bringing HTML UI closer #


## Usage Examples

```php
$bridge = new Bridge\Bridge(new Bridge\Skins\Bootstrap());

body = [
		[1,2,3,4,5,6
	],
    	[
        new Bridge\Html\Tag('td', '21', ['class' => 'danger']),
        [
            'content'    => '22',
            'attributes' => ['class' => 'success']
        ],
        23,
        24,
        25,
        26
    ]
];

$thead = [
    'jedan',
    'dva',
    'tri',
    'četiri',
    'pet',
    'šest'
];

$tfoot = [

];

$table  = $bridge->component('grid', $tbody, $thead, $tfoot);
echo $table->striped()->hover()->responsive();

echo Bridge\Bridge::button('CANCEL')->danger();


```

### List

```php

$bridge = new Bridge\Bridge(new Bridge\Skins\Bootstrap());

$list = [
    'item 1',
    'item 2',
    'item 3',
    'item 4' => [
        'item 5',
        'item 6',
        'item 7',
        'item 8' => [
            'item 9',
            'item 10',
            'item 11',
            'item 12'
        ]
    ]
];

echo Bridge\Bridge::listgroup($list);

```

### Total Flexibility

```php
$list = new Bridge\Html\Ul($list);
$list->add('Item 13');
$list->add([
   'item 14' => [
       new Bridge\Html\Tag('a', 'Some Link', ['href' => '#some-link'])
   ]
]);

echo $list;
```


### Contribution guidelines ###
TODO

### Currently supported UI frameworks ###

* Twitter Bootstrap
* ......
* Decorator