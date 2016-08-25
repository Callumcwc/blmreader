# BLM Reader

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Install

Via Composer

``` bash
$ composer require renedekat/blmreader
```

## Usage

``` php
$blmReader = Reader::create()->loadFromFile("path/to/blmFile")
// OR
$blmReader = Reader::create()->loadFromString($blmContents)

$rawContents = $blmReader->getRawContents();
$collection = $blmReader->getDate();
$array = $blmReader->toArray();

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [Rene de Kat][renedekat@9lives-development.cm]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
