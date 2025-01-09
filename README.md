# PHP Framework

PHP framework entirely made by AI with Windsurf IDE and Claude in a few hours (2025-01-08).

I included the most basic framework classes in the initial [prompt](ai.md) to reduce some complexity at first - currently all is file-based, db could be added. A bunch of methods was missing in AI's code but the AI was able to fix that with a series of prompts. Basically we have a framework with nearly no effort.

Possible extensions

- detail check of AI's code
- maybe improve some code or add some methods
- further framework classes could be added
- things that the AI missed as seen so far: see [text](tasks.md)

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

1. Run composer install to get dependencies:
   ```bash
   composer install
   ```

2. Ensure these directories exist and are writable:
   - /data
   - /data/cache
   - /data/config
   - /data/users

3. Start the PHP development server:
   ```bash
   php -S localhost:8000
   ```

## Directory Structure

```
/data              # File-based storage
/pages             # Application pages
  /PAGE_NAME
    /ajax         # AJAX handlers
    controller.php
    controller.js
    style.css
    /view         # Page views
/src
  /Core           # Framework core classes
ajax.php          # AJAX request handler
index.php         # Application entry point
```

## Creating a New Page

1. Create a directory under /pages with your page name
2. Add these files:
   - controller.php (extends App\Core\Controller)
   - controller.js (optional)
   - style.css (optional)
   - view/your-view.php

## Making AJAX Calls

1. Create an AJAX handler in your page's ajax directory
2. Use the fetch API to make calls to ajax.php
3. Set the X-Requested-With header
4. Send and receive JSON data

## Error Handling

Errors are automatically caught and displayed:
- For AJAX requests: JSON response with error details
- For regular requests: Error page with details (in debug mode)

## Configuration

Edit data/config/config.yml to change:
- Application name
- Debug mode
- Default page
- Other settings

## Captions

Edit data/config/captions.yml to manage text in different languages.


LICENSE
----------------------------------------------------------

Copyright (C) Walter A. Jablonowski 2025, free under [MIT license](LICENSE)

This app is build upon PHP and free software (see [credits](credits.md))

[Privacy](https://walter-a-jablonowski.github.io/privacy.html) | [Legal](https://walter-a-jablonowski.github.io/imprint.html)
