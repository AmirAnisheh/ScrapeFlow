
# Gregorian-Jalali Converter for Laravel

A simple **pure PHP package** to convert **Gregorian dates to Jalali (Persian) dates** and vice versa, designed to work easily with Laravel projects.  
No external libraries required.

---

## Features

- Convert **Gregorian → Jalali**  
- Convert **Jalali → Gregorian**  
- Pure PHP implementation, no dependencies  
- Easy to integrate into Laravel  

---

## Installation

### Via Composer (GitHub repository)

Add the repository to your Laravel project `composer.json` if not on Packagist:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/AmirAnisheh/gregorian-jalali.git"
        }
    ],
    "require": {
        "amir-anisheh/gregorian-jalali": "dev-main"
    }
}
````

Then run:

```bash
composer update
```

---

## Usage

### 1. Import the converter

```php
use AmirAnisheh\GregorianJalali\JalaliConverter;
```

### 2. Convert Gregorian to Jalali

```php
$jalali = JalaliConverter::toJalali(2025, 9, 6);
echo $jalali; // Output: 1404/06/15
```

### 3. Convert Jalali to Gregorian

```php
$gregorian = JalaliConverter::toGregorian(1404, 6, 15);
echo $gregorian; // Output: 2025-09-06
```

---

## Example in Laravel Controller

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AmirAnisheh\GregorianJalali\JalaliConverter;

class DateController extends Controller
{
    public function convert(Request $request)
    {
        $gregorianDate = $request->input('gregorian', '2025-09-06'); // default value
        [$gy, $gm, $gd] = explode('-', $gregorianDate);

        $jalali = JalaliConverter::toJalali((int)$gy, (int)$gm, (int)$gd);

        return response()->json([
            'gregorian' => $gregorianDate,
            'jalali' => $jalali,
        ]);
    }

    public function convertJalali(Request $request)
    {
        $jalaliDate = $request->input('jalali', '1404/06/15'); // default value
        [$jy, $jm, $jd] = explode('/', $jalaliDate);

        $gregorian = JalaliConverter::toGregorian((int)$jy, (int)$jm, (int)$jd);

        return response()->json([
            'jalali' => $jalaliDate,
            'gregorian' => $gregorian,
        ]);
    }
}
```

---

## Example Routes

```php
use App\Http\Controllers\DateController;

Route::get('/convert-gregorian', [DateController::class, 'convert']);
Route::get('/convert-jalali', [DateController::class, 'convertJalali']);
```

Visit these URLs to test:

```
http://your-app.test/convert-gregorian?gregorian=2025-09-06
http://your-app.test/convert-jalali?jalali=1404/06/15
```

---

## License

This package is **MIT licensed**.
Feel free to use and modify it in your projects.


