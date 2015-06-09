Getting Started With MigrationBundle
====================================

## Installation and usage

Installation and usage is a quick:

1. Download MigrationBundle using composer
2. Enable the Bundle

### Step 1: Download MigrationBundle using composer

Add MigrationBundle in your composer.json:

```js
{
    "require": {
        "fdevs/migration-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update fdevs/migration-bundle
```

Composer will install the bundle to your project's `vendor/fdevs` directory.


### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FDevs\MigrationBundle\FDevsMigrationBundle(),
    );
}
```

add config

``` yaml
# app/config/config.yml
f_devs_migration:
    configuration: 'mongodb'
```



### Step 3: Create file migration

#####allowed folders

* `%kernel.root_dir%/Resources/Migrations` 
* `YouBestBundle/Migrations` 

```php
namespace AppBundle\Migrations;

use FDevs\Migrations\Migration\MongodbMigration;

class Version20150601103845 extends MongodbMigration
{
    /**
     * {@inheritDoc}
     */
    public function up()
    {

    }

    /**
     * {@inheritDoc}
     */
    public function down()
    {
    }
}
```

### Step 4: Migration command

####info about migrations

```bash
$ bin/console fdevs:migrations:info
current version 20150601103847.
allowed migrations to execute.
20150601103845 class AppBundle\Migrations\Version20150601103845
20150601103846 class AppBundle\Migrations\Version20150601103846
20150601103847 class AppBundle\Migrations\Version20150601103847
```
#### run migrations latest version

```bash
$ bin/console fdevs:migrations:migrate
```
#### run migrations current version

```bash
$ bin/console fdevs:migrations:migrate 20150601103846
```

#### run migrations down

```bash
$ bin/console fdevs:migrations:migrate 20150601103845 down
```

### Step 5: Use Symfony Container in migrations


```php
<?php

namespace AppBundle\Migrations;

use FDevs\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Version20150601103847 extends AbstractMigration implements ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function up()
    {

    }

    /**
     * {@inheritDoc}
     */
    public function down()
    {

    }
}
```
