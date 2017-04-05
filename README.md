# laravel-unshitty-flash

Highly opinionated flash message service for Laravel. In contrast to practically all other similar libraries I've seen, 
this one:

* Supports multiple messages
* Supports multiple identical messages
* Let's you configure the session key used
* Forces you to inject the service, no magic facade
* Forces you to operate on the `Request` object itself

## Installation

Install the package:

```bash
composer require jalle19/laravel-unshitty-flash
```

Register the service provider:

```php
'providers' => [
	...
	Jalle19\Laravel\UnshittyFlash\FlashServiceProvider::class,
	...
]
```

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Jalle19\Laravel\UnshittyFlash\FlashServiceProvider"
```

## Usage

Inject `FlashService` into the controller you want to create flash messages from, then use it like this:

```php
$this->flashService->success($request, 'Some successful message');
$this->flashService->info($request, 'Some informational message');
$this->flashService->warning($request, 'Some warning');
$this->flashService->danger($request, 'Some dangerous message');
```

If the message levels above are not enough for you, you can use an arbitrary level using the `message()` method:

```php
$this->flashService->message($request, 'Some rant about libraries', 'rant);
```

To render the flash messages in your views, you can use something like the following snippet:

```blade
@foreach (session()->get(config('flash.session_key'), []) as $notification)
    <div class="alert alert-{{ $notification['level'] }} alert-dismissible in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        {!! $notification['message'] !!}
    </div>    
@endforeach
```
