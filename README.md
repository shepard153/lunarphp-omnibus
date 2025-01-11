# LunarPHP Omnibus

A package to track historical prices of purchasable items in [LunarPHP](https://lunarphp.io/) for compliance with the [EU Omnibus Directive](https://eur-lex.europa.eu/eli/dir/2019/2161).

## Features
- Track historical prices for all purchasable models.
- Support for multi-currency and customer group pricing.
- Automatically log price changes.
- Retrieve the lowest price within the last 30 days.

## Installation
1. Install the package using Composer:
    ```bash
    composer require kkosmider/lunarphp-omnibus
    ```
   
2. Publish the migrations and configurations:
    ```bash
    php artisan vendor:publish --tag=omnibus.migrations
    ```
3. Add the `HasHistoricalPrices` trait to your purchasable models.

## Usage
This package automatically listens to price changes and records them in the historical_prices table.
Use the HasHistoricalPrices trait in your purchasable models:

```php
use Kkosmider\Omnibus\Traits\HasHistoricalPrices;

class ProductVariant extends \Lunar\Models\ProductVariant
{
    use HasHistoricalPrices;
}

```

Retrieve the lowest price within the last 30 days:

```php
$variant = ProductVariant::find(1);

$lowestPrice = $variant->getHistoricalLowestPrice();
$variantHistoricalPrices = $variant->historicalPrices()->get();
```

## Configuration
Customize configurations in `config/omnibus.php` after publishing:
```bash
php artisan vendor:publish --tag=omnibus.migrations
```
