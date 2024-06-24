### hello everybody this is acl ( access control list ) for laravel 😃

# [Getting Started]

1- Install the package using composer

```php
composer require nematollahi/laravel-acl
```
2- Publish the package configuartion files and add your own models to the list of ACL models

```php
php artisan vendor:publish --provider Nematollahi\ACL\ACLServiceProvider
```

- The items that are added are:

  1- added acl.php into folder config
  
  2- added acl into folder middleware
  
  3- added required migrations in the migration folder
  
  4- added role and permission model



3- migrate
```php
php artisan migrate
```

4- trait HasACLTools into model user
```php

//app/Models/User.php

use Nematollahi\ACL\Traits\HasACLTools;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasACLTools;

enother codes ...

```

5- add acl middleware to kernal
```php
//app/Http/Kernel.php

'acl' => \App\Http\Middleware\ACL::class,
```

6- call acl in provider

```php

//app/Providers/AppServiceProvider.php

use Nematollahi\ACL\ACL;

ACl::run();
```

7- use in route

```php
//routes/web.php

Route::get('/', function () {
    return view('welcome');
})->middleware("acl:admin");
```

## how we can use permission in project

 - you need have the databases ( permissions , permissions_user )



## how can i use role in projcect

  - you need have the database ( role , role_user )

    Uploading lv_0_20240624134213.mp4…



### Tips: You can also find a connection to roles and permisison in the permission_role table . 👌
  
# [For those who read to develop]
### Project Structure

but how it worked ? 🤔

- This package has an interface that the run method should be implemented by the child's classes

```php
interface IACL
{
    public static function run();
}
```

- This package contains a Trait in which there are methods for running the ACL

```php
<?php

trait ACLTools
{
    protected array $userPermissions = []; // It stores all the user's permissions in itself (role + permission )

    public function roles() // get all current user roles
    {
        return $this->belongsToMany(Config::get("acl.role"));
    }

    public function permissions() // get all permissions user permissions
    {
        return $this->belongsToMany(Config::get("acl.permission"));
    }

    public function hasRoles(...$roles): bool //Checks if the user already has these roles
    {
        foreach ($roles as $role) {
            if ($this->roles->contains("name", $role)) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission($permission): bool //This method checks whether the user currently has the permissions
    {
        $accessPermission = $this->setPermissions();
        if (in_array($permission, $accessPermission)) {
            return true;
        }

        return false;
    }

    protected function setPermissions(): array //Initializes the userPermissions variable
    {

        //We put a loop on all the user roles and put all the permissions that exist in it into the userPermissions variable
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                array_push($this->userPermissions, $permission->name);
            }
        }

        //We put all permissions in the userPermissions variable
        foreach ($this->permissions as $permission) {
            array_push($this->userPermissions, $permission->name);
        }

        return $this->userPermissions;
    }
}
```

- And finally, we designed a class called ACL that uses the IACL interface to imply and run the run method

```php
class ACL implements IACL
{
    use ACLTools;
    public static function run()
    {
        $modelPermission = Config::get("acl.permission");
        (new $modelPermission)->all()->map(function ($permission) {
            Gate::define($permission->name, function (User $user) use ($permission) {
                return $user->hasPermission($permission->name);
            });
        });
    }
}
```

how can we calle it? 🤔

- You can call the run method in the provider in the boot method

```php
public function boot()
{
    ACL::run();
}
```

- This method allows for the creation of gates called permissions

## Tips: This package is written in such a way that you can easily develop it or use design patterns such as proxy , (Just give it a proxy class) . 😎


Good Day ... ✔
