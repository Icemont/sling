<img src="https://raw.githubusercontent.com/Icemont/sling-docs/main/assets/screenshots/sling.png">

## Sling - Simple Laravel Invoice Generator
[![Tests](https://github.com/Icemont/sling/actions/workflows/laravel.yml/badge.svg?branch=main)](https://github.com/Icemont/sling/actions/workflows/laravel.yml)
[![Psalm Static Analysis](https://github.com/Icemont/sling/actions/workflows/psalm.yml/badge.svg)](https://github.com/Icemont/sling/actions/workflows/psalm.yml)
[![GitHub license](https://img.shields.io/github/license/Icemont/sling)](https://github.com/Icemont/sling/blob/main/LICENSE)

Sling — open-source web application that helps you create invoices and track income.

## Table of Contents

1. [About](#about)
2. [Features](#features)
3. [Installation](#installation)
4. [Installation with Docker](#installation-with-docker)
5. [Customization](#customization)
6. [Roadmap](#roadmap)
7. [License](#license)

## About
**Sling** was originally created for personal use, for convenient accounting of income and invoice generation for Individual Entrepreneur with "Small Business" status in Georgia (tax is paid on total revenue every month). 

This application will be useful for businesses and individuals with a similar taxation system, or just for generating invoices and income accounting. Sling is based on the Laravel PHP framework.

Screenshots of the deployed app are available [here](https://github.com/Icemont/sling-docs/tree/main/assets/screenshots).

Sling page on the developer's website: [https://icemont.dev/my-scripts/sling](https://icemont.dev/my-scripts/sling)

## Features
- Client Accounting.
- Separate invoice number prefix for each customer with the ability to set the initial number index.
- Generate invoices & Download invoices as PDF.
- Invoicing model: "one invoice = one service"
- One main currency for accounting with the ability to invoice in other currencies. If the invoice is billed in a non-primary currency, it is possible to get an exchange rate from an exchange rate provider for the invoice payment date. At the moment only exchange rate provider for GEL (Georgian Lari) is available, but providers for other currencies can be easily added.
- Unlimited number of payment methods can be created. Different payment method can be selected for each invoice. Information about the selected payment method will be added to the generated invoice.
- Reports generation for the selected period with grouping by clients.

## Installation
Clone the project repository:

	$ git clone https://github.com/Icemont/sling.git


Next, go to the project data directory and install the dependencies using the composer:

    $ cd ./sling
    $ composer install --no-dev


Then create in the project root directory a settings file `.env` by copying it from `.env.example` and edit the necessary options in it, such as database connection settings.

Generate your application key with the command:

    $ php artisan key:generate --ansi

Perform database migrations to create the initial database tables structure:

    $ php artisan migrate 

Complete installation by adding currencies to the database using one of the commands of your choice:

    $ php artisan sling:install
    # Or:
    $ php artisan db:seed --class=CurrenciesSeeder

Minimized JS and CSS assets are already available in the current repository, but you can install development versions of assets by installing dependencies and executing commands:

    $ npm install
    $ npm run dev

Then you can generate production-ready assets using the command:

    $ npm run build

Initial configuration does not differ from the typical Laravel project configuration, so you can refer to the official [Laravel framework documentation](https://laravel.com/docs/9.x/configuration) in case of difficulties.

## Installation with Docker
Install Docker on your host by using this guide: [https://docs.docker.com/install/](https://docs.docker.com/install/)

Install Docker Compose by using this guide: [https://docs.docker.com/compose/install/](https://docs.docker.com/compose/install/)

Clone the project repository:

	$ git clone https://github.com/Icemont/sling.git

Next, go to the project data directory and create in the project root directory a settings file `.env` by copying it from `.env.example` and edit the necessary options in it:

    $ cd sling
    $ cp .env.example .env

Next, run commands below:

    $ docker-compose up -d
    $ ./docker-compose/setup.sh

## Customization
#### Base settings
You can change some basic application settings in the file: `config/app.php`, such as pagination or default currency:

```php
    /*
    |--------------------------------------------------------------------------
    | Sling config options
    |--------------------------------------------------------------------------
    */

    'per_page' => [
        'clients' => 25,
        'invoices' => 25,
        'payment_methods' => 25,
    ],

    'default_currency' => 'GEL',
    'invoice_index_length' => 5,

```

#### New currency
If you need to add a new currency to the database, you can add it to the `$currencies` array in the `database/seeders/CurrenciesSeeder.php` file and then run the command:

    $ php artisan db:seed --class=CurrenciesSeeder


## Roadmap

    📌 There are no specific deadlines and guarantees for the implementation.

- [ ] Sending invoices to the client's email
- [ ] Adding exchange rate providers for other currencies
- [ ] Abandoning the jQuery library in favor of native JS

## License

The contents of this repository is released under the [MIT license](https://opensource.org/licenses/MIT).
