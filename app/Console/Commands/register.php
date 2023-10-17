<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class register extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Імя користувача:');
        while (strlen($name) < 4) {
            $name = $this->ask('Має містити більше ніж 4 символи, введіть імя користувача знову:');
        }

        $login = $this->ask('Введіть логін:');
        while (!preg_match("/^[a-zA-Z0-9_]{4,30}$/", $login)) {
            $login = $this->ask("Логін повинен містити лише літери, цифри і символ підкреслення, та мати довжину від 4 до 30 символів. Введіть логін знову:");
        }

        $email = $this->ask('Email:');
        while (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = $this->ask('Будьласка введіть email правильно:');
        }

        $password = $this->secret('Пароль:');
        while (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/", $password)) {
            $password = $this->secret('Пароль повинен містити більше 10 сімволів, 1 цифу та 1 спеціальний символ. Введіть пароль знову:');
        }

        $repeatPassword = $this->secret('Повторіть пароль:');

        if ($password === $repeatPassword) {
            \App\Models\User::factory()->create([
                'name' => $name,
                'login' => $login,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
        }
    }
}
