<?php

use Illuminate\Support\Facades\Artisan;


Artisan::command('test:reza {user}', function ($user) {
    $this->info("Sending email to: {$user}!");
});
