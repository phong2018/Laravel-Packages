=====================================
using
- sail composer require phonglg/laravelselfcreated
=====================================
Build
- composer init => composer.json
- in composer.json add: autoload: src/
- in composer.json add: extra: providers
- add tesing 

====================================
can research again!
- in phpunit.xml in root project
<directory suffix="Test.php">./vendor/phonglg/laravelselfcreated/tests/Unit</directory>  
<directory suffix="Test.php">./vendor/phonglg/laravelselfcreated/tests/Feature</directory>
- **** laravel801\composer.json: because: autoload-dev (root only)
"autoload-dev": {"psr-4": {...."Phonglg\\LaravelSelfCreated\\Tests\\": "vendor/phonglg/laravelselfcreated/tests"}},
- sail composer update vendor/phonglg
- sail composer dump-autoload
- sail php artisan test
- sail php ./vendor/bin/testbench package:test
- sail php ./vendor/bin/testbench package:test --parallel
