# posProject

Something I'm putting together for a friend

Base Yii System for deployment
=============

    $ cd common/composer/
    $ php composer install
    $ git submodule init
    $ git submodule update

Modify common/config/db.php as necessary, if local create: common/config/db-local.php

```php
<?php

return array(
    'pdoClass'              => 'NestedPDO',
    'connectionString'      => 'pgsql:host=localhost;port=5432;dbname=360Parent',
    'username'              => '',
    'password'              => '',
    'charset'               => 'utf8',
    'emulatePrepare'        => true,
    'enableProfiling'       => YII_DEBUG_PROFILING,
    'enableParamLogging'    => YII_DEBUG_PARAM_LOGGING,
);
```

Change system variables as necessary.
    common/config/systemVariables.php

    $ phpmamp yiic migrate --migrationPath=frontend.modules.user.migrations

goto {site}/rights/install and follow prompts
once tables are generated in frontend/config/main.php change modules/rights/install to false

login and do stuff.
