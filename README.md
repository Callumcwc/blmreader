[![Latest Stable Version](https://poser.pugx.org/renedekat/blmreader/v/stable)](https://packagist.org/packages/renedekat/blmreader)
[![Total Downloads](https://poser.pugx.org/renedekat/blmreader/downloads)](https://packagist.org/packages/renedekat/blmreader)
[![License](https://poser.pugx.org/renedekat/blmreader/license)](https://packagist.org/packages/renedekat/blmreader)
[![composer.lock](https://poser.pugx.org/renedekat/blmreader/composerlock)](https://packagist.org/packages/renedekat/blmreader)


[![Build Status](https://scrutinizer-ci.com/g/renedekat/blmreader/badges/build.png?b=master)](https://scrutinizer-ci.com/g/renedekat/blmreader/build-status/master)
[![StyleCI](https://styleci.io/repos/66577700/shield)](https://styleci.io/repos/66577700)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/renedekat/blmreader/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/renedekat/blmreader/?branch=master)

# BLM Reader



## Install

Via Composer

``` bash
$ composer require renedekat/blmreader
```

## Usage

``` php
use ReneDeKat\Blm\Drivers\Simple
use ReneDeKat\Blm\Drivers\Csvq

$simple = Simple::create()->loadFromFile("path/to/blmFile")
// OR
$simple = Simple::create()->loadFromString($blmContents)

$rawContents = $simple->getRawContents();
$output = $simple->getOutput();
$data = $output['data'];
$definitions = $output['definitions']
$headers = $output['headers;


$csv = Simple::create()->loadFromFile("path/to/blmFile")
$output = $csv->getOutput();

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
