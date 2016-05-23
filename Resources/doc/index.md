Getting Started With MigrationBundle
====================================

## Installation and usage

Installation and usage are easy:

1. Download MigrationBundle using composer
2. Enable the bundle
3. Create a migration file
4. Migration commands
5. Use Symfony Container in migrations
6. Usage with [Capifony](http://capifony.org/)

### Step 1: Download MigrationBundle using composer

Add MigrationBundle to your composer.json file:

```js
{
    "require": {
        "fdevs/migration-bundle": "*"
    }
}
```

Now tell Composer to download the bundle by running the next command:

``` bash
$ php composer.phar update fdevs/migration-bundle
```

Composer will install the bundle into your project's `vendor/fdevs` directory.


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

Add config

``` yaml
# app/config/config.yml
f_devs_migration:
    configuration: 'mongodb'
```



### Step 3: Create a migration file

#####Allowed folders

* `%kernel.root_dir%/Resources/Migrations`
* `YouBestBundle/Migrations`

You can check naming convention in the Migrations library [documentation](https://github.com/4devs/migrations/blob/master/Resources/doc/index.md#create-a-migration-class)

```php
// src/AppBundle/Migrations/Version20150601103845.php
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

### Step 4: Migration commands

####Info about migrations

```bash
$ bin/console fdevs:migrations:info
current version 20150601103847.
allowed migrations to execute.
20150601103845 class AppBundle\Migrations\Version20150601103845
20150601103846 class AppBundle\Migrations\Version20150601103846
20150601103847 class AppBundle\Migrations\Version20150601103847
```
#### Migrate to the latest version

```bash
$ bin/console fdevs:migrations:migrate
```
#### Migrate to a particular version

```bash
$ bin/console fdevs:migrations:migrate 20150601103846
```

#### Revert migrations down

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

### Step 6: Usage with Capifony

#### Add the migrations:migrate command

```ruby
# app/config/deploy.rb
namespace :migrations do
    task :migrate do
        desc "Migration to the latest available version"
        run "cd #{latest_release} && #{php_bin} #{symfony_console} fdevs:migrations:migrate --env=#{symfony_env_prod}"
    end
end
```

#### Use the command

```bash
$ cap migrations:migrate
```
