# Allow actions in your laravel model

[![Latest Version on Packagist](https://img.shields.io/packagist/v/narcisonunez/laravel-actionable-model.svg?style=flat-square)](https://packagist.org/packages/narcisonunez/laravel-actionable-model)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/narcisonunez/laravel-actionable-model/run-tests?label=tests)](https://github.com/narcisonunez/laravel-actionable-model/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/narcisonunez/laravel-actionable-model/Check%20&%20fix%20styling?label=code%20style)](https://github.com/narcisonunez/laravel-actionable-model/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/narcisonunez/laravel-actionable-model.svg?style=flat-square)](https://packagist.org/packages/narcisonunez/laravel-actionable-model)


Allow models to perform or receive actions.

## Installation

You can install the package via composer:

```bash
composer require narcisonunez/laravel-actionable-model
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Narcisonunez\LaravelActionableModel\LaravelActionableModelServiceProvider" --tag="actionable-model-migrations"
php artisan migrate
```

## Basic Setup

### Register your actions

Add your action in your `AppServiceProvider`

```php
use Narcisonunez\LaravelActionableModel\Facades\ActionableActionTypes;
use App\ActionTypes\KudosActionType;

ActionableActionTypes::register([
    'like',
    'kudos' => KudosActionType::class,
    'celebrate'
]);
``` 
You can implement your own class extending `ActionableTypeRecord` to add more logic to your records.   
Ex. `icon` method to get that specific action type icon.
Now, Any `kudos` action will have a method named `icon`.  

Your actions will be used as dynamic method calls. See below.

### Create a new Actionable Action Type (OPTIONAL)
```php
php artisan actionable:type LikeActionType
```

### Add aliases to your models (OPTIONAL)

Add your aliases in your `AppServiceProvider`

```php
use App\Models\Cause;
use App\Models\User;
use Narcisonunez\LaravelActionableModel\Facades\ActionableModelAliases;

ActionableModelAliases::register([
    User::class => 'user',
    Cause::class => 'cause'
]);
``` 

Storing aliases in the database will prevent losing the reference if you move your models to another directory.

### Update existing models references to use the new alias

In case you already have data in the database, after adding the aliases you can run:  

```php
php artisan actionable:update-aliases // Update all the records
```
If you want just to update a specific value
```php
php artisan actionable:update-aliases --from="App\\User" --to="App\\Models\\User"
```

To update all your existing records.

## Traits
A model that can perform actions you need to include:

```php
// Imports 
class User extends Authenticatable
{
    use ActionableModel;
    use CanPerformActions;
    ...
}
```

The model that can receive the actions must implement `CanBeActionable`
```php
...
use Narcisonunez\LaravelActionableModel\Traits\ActionableModel;

class Cause extends Model implements CanBeActionable
{
    use ActionableModel;
    ...
}
```

## Basic Usage

### Perform an action
```php
// You will use your actions as methods call.
$user->performActionOn($cause)->like();
$user->performActionOn($cause)->kudos();
$user->performActionOn($cause)->celebrate();
```

## Check if the action was already made
```php
// returns False or an ActionableTypeRecord
$user->hasPerformedAction('like')->on($cause);
```

## Toggle your actions
```php
// remove if exists the action, otherwise creates a new like
$user->performActionOn($cause)->toggle('like');
// OR
// toggleACTIONTYPE
$user->performActionOn($cause)->toggleLike(); 
$user->performActionOn($cause)->toggleKudos(); 
$user->performActionOn($cause)->toggleCelebrate(); 
```

## Manually delete an action (See Toggle above)
```php
if ($action  = $user->hasPerformedAction('like')->on($cause) ) {
    $action->delete();
}
```

## Get all the actions
```php
$user->actions;

// To help you out filtering your actions. You can use the actionsFilter method
$user->actionsFilter()->get();
$user->actionsFilter()->latest(10);
$user->actionsFilter()->given()->get();
$user->actionsFilter()->received()->get();
$user->actionsFilter()->ofType('like')->get();
$cause->actionsFilter()->by($user)->ofType('like')->get();
$cause->actionsFilter()->by($user)->ofType('like')->count();
```

#### - Available methods -
| Method | Description |
| --- | --- |
| get | Returns a collection of `ActionableTypeRecord` |
| count | Returns the number of records |
| given | Filters all the records where the current model performed the actions |
| received | Filters all the records where the current model received the actions |
| ofType | Filters by the actionType|
| by | Filters all the actions in the current model where the model passed to this method performed the action |
| latest | Get the collection sorted by the latest ones. |

### Actionable Record
The methods above will return a collection of `ActionableRecord`.  
The access the owner or the actionable models, you can do it like this:
```php
$actionRecord = $user->actionsFilter()->ofType('like')->get()->first();

$actionRecord->owner; // The model that performed the action
$actionRecord->actionable; // The model that received the action
$actionRecord->action; // Action that was performed. ex. like, kudos, celebrate, etc.
$actionRecord->type; // An alias to action
```

## 💖 Support the development
**Do you like this project? Support it by donating**

- PayPal: [Donate](https://www.paypal.com/donate?hosted_button_id=AHCCCPMWR66YL)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
