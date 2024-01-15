<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body>
    <h1>Welcome to {{ config('app.name') }},  $user->name !</h1>

    <p>We're excited to have you join our community.</p>

    <p>You're now registered with the email address  $user->email .</p>

    <p>You're registred by owner:  $user->owner </p>

    <p>If you have any questions, please feel free to reach out to our support team.</p>

    <p>Thanks,<br>
    {{ config('app.name') }}</p>
</body>
</html>
