# PHP Framework

PHP framework entirely made by AI with Windsurf IDE and Claude in a few hours (2025-01-08).

I included the most basic framework classes in the initial [prompt](ai.md) to reduce some complexity at first - currently all is file-based (db could be added). A bunch of methods was missing in AI's code but the AI was able to fix that with a series of prompts. Basically we have a framework with nearly no effort.

Possible extensions

- detail check of AI's code
- maybe improve some code or add some methods
- further framework classes could be added

## Features

- File-based data storage (no database required)
- Simple routing system using query parameters
- Session management with caching
- User authentication
- AJAX handling
- Error handling
- Configuration management
- Multilingual support
- Bootstrap 5.3 UI

## Installation

1. Run composer install to get dependencies
   ```bash
   composer install
   ```

2. Ensure these directories exist and are writable
   - /data
   - /data/cache
   - /data/config
   - /data/users

3. Start the PHP development server
   ```bash
   php -S localhost:8000
   ```

## Directory Structure

```
/data                   # File-based storage
/pages                  # Application pages
  /PAGE_NAME
    /ajax               # AJAX handlers
    controller.php
    controller.js
    style.css
    /view/-this.php     # Page view
    /view.php           # or
    /view/login.php     # or multiple
    /view/register.php
/src
  /Core                 # Framework core classes
ajax.php                # AJAX request handler
index.php               # Application entry point
```


LICENSE
----------------------------------------------------------

Copyright (C) Walter A. Jablonowski 2025, free under [MIT license](LICENSE)

This app is build upon PHP and free software (see [credits](credits.md))

[Privacy](https://walter-a-jablonowski.github.io/privacy.html) | [Legal](https://walter-a-jablonowski.github.io/imprint.html)
