# ScrapeFlow

**ScrapeFlow** is a chainable, SOAP-like HTML parser for Laravel using pure PHP.  
It allows you to parse HTML from URLs or strings in a fluent, readable way.

Package: `amir-anisheh/scrapeflow`

---

## Features

- Chainable syntax for fluent HTML parsing
- Select elements by **tag**, **class**, **id**, or **attribute**
- Get **text** or **HTML** of elements
- Pure PHP, no external parsing libraries required
- Ready to use in Laravel with automatic package discovery

---

## Installation

Require the package via Composer:

```bash
composer require amir-anisheh/scrapeflow
````

Or for local development:

```json
"repositories": [
    {
        "type": "path",
        "url": "../scrapeflow"
    }
]
```

Then require it:

```bash
composer require amir-anisheh/scrapeflow:@dev
```

---

## Usage

### Basic Example

```php
use AmirAnisheh\ScrapeFlow\HtmlParserService;

$parser = new HtmlParserService();

// Get all titles by class
$titles = $parser->url('https://example.com')
                 ->getByClass('title')
                 ->texts();

// Get the first <h1> text
$firstH1 = $parser->url('https://example.com')
                  ->getByTag('h1')
                  ->text();

print_r($titles);
echo $firstH1;
```

### Chainable Syntax

```php
$parser->url('https://example.com')
       ->getByClass('container')
       ->getByTag('h2')
       ->texts();
```

---

## Methods

| Method                                        | Description                        |
| --------------------------------------------- | ---------------------------------- |
| `url(string $url)`                            | Load HTML from a URL               |
| `loadHtml(string $html)`                      | Load HTML from a string            |
| `getByTag(string $tag)`                       | Select nodes by tag name           |
| `getByClass(string $class)`                   | Select nodes by class name         |
| `getById(string $id)`                         | Select nodes by ID                 |
| `getByAttribute(string $attr, string $value)` | Select nodes by attribute          |
| `text()`                                      | Get text of the first matched node |
| `texts()`                                     | Get text of all matched nodes      |
| `html()`                                      | Get HTML of the first matched node |
| `allHtml()`                                   | Get HTML of all matched nodes      |

---

## License

ScrapeFlow is **open-sourced software licensed under the MIT license**.

---

## Author

**Amir Anisheh**
Email: [amirtaja@yahoo.com](mailto:amirtaja@yahoo.com)
GitHub: [https://github.com/AmirAnisheh](https://github.com/AmirAnisheh)

