# LS-WP-Logger

## How to use
In any php file you can use methods: 

```php
Ls\Wp\Log::info("My Title", [any object]);
Ls\Wp\Log::error("My Title", [any object]);
```

or add namespace

```php
use Ls\Wp\Log as Log;

Log::info("My Title", [any object]);
Log::error("My Title", [any object]);
```

## Release Notes:
### 2.0.0
Add `namespace` usage. \
Add pritty view for `array` and `object` values