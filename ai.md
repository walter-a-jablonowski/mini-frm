
Intentionally few details. Let AI decide. had to add a list of classes cause AI was did only an app class without.

--

Make a PHP framework that I can use to make web apps

## Common

- important: Make nice and easy to read code
- maintaining simplicity and avoiding unnecessary complexity
- maintain clear separation of concerns

## Restrictions

- We use no databse but save all data file based in /data
- We have no file uploads
- We use no restful urls, just query params instead
- We currently have no migration system
- Make no template engine, PHP is your template engine (PHP's alternative syntax)

## Code

- PHP code: implement typical framework classes at least (but no limited to)

  - App
  - Config
  - Routing
  - Request
  - Response
  - Session which has a cache (saved as json)
  - Cache
  - User
  - Controller
  - ErrorHandler
  - Captions
  - Entity class model base class
    - holds a multi dim array in $data
    - provides CRUD functions for single values, nested values and array actions
    - we can access values by using a point seperated string like `get('sub.elem')`
    - the loading and saving of the data is implemeted in derived classes as needed, provide abstract methods for this
  - File: (derived from Entity) a class for accessing and working with file data (json, yml, images) that provides CRUD functions
    - we use the middle of the full path to load the file like `my/file`, this might be `data/my/file.txt` in file system
    - the class is responsible for finding the right file extension (per definition we may only have one file of a certain name on one level of the file system)
    - add a method fullPath() that returns the full path of the file
    - in the framework use this as where appropriate
  - make more framework classes if something important is missing here
  - add helper functions if needed

- JS code:        use no jquery but plain js code, prefer making classes
- Ajax:           send json during ajax calls
- Error handling: we need to consider PHP errors, PHP errors during ajax calls ans js errors

The following classes should be accessible from anywhere in the code: App, Config, Session cache, User, Captions. You could use a a static method that delivers a app object (singleton)

## Also make a minimal demo app with the following pages

- Login and Register page
- Single start page top nav, demo content and a logout button
- Use bootstrap 5.3
