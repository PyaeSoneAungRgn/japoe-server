## Installation

To start tracking errors with JaPoe Client, follow the steps below:

### Step 1: Install JaPoe Client

Use Composer to install the JaPoe Client package:

```bash
composer require pyaesoneaung/japoe-client
```

### Step 2: Register JaPoe Client

In `bootstrap/app.php`, register the `JaPoeClient` to handle exceptions in your application:

```php
->withExceptions(function (Exceptions $exceptions) {
    \PyaeSoneAung\JaPoeClient\Facades\JaPoeClient::handles($exceptions);
})->create();
```

### Step 3: Update Your Environment Configuration

Next, update the `.env` file with the following configurations:

```.env
JAPOE_ENABLE=true
JAPOE_HOST=your-japoe-host
JAPOE_KEY=your-japoe-key
```

Make sure to replace your-japoe-host and your-japoe-key with your actual server information and API key.

### Step 4: Test JaPoe Client

Once everything is set up, test the JaPoe Client by running:

```bash
php artisan japoe:test
```

If the setup is successful, your Laravel application will now begin tracking errors and sending them to your self-hosted JaPoe server.
