<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Authentication\Users;
use Illuminate\Support\Facades\Hash;

class CreateDevelopers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'developer:create-developer {--email= } {--password= }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an developer user from the console';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Access arguments
            $email = $this->option('email');
            $password = $this->option('password');
            if (Users::where('email', $email)->exists()) {
                $this->error("An account with the email {$email} already exists!");
                return 0;
            }

            // Create the user
            $user = Users::create([
                'email' => $email,
                'password' => Hash::make($password),
                'name' => 'dev',
                'roles' => 'Developer'
            ]);

            // Notify the user
            $this->info('Admin account successfully created!');
            $this->info("Email: {$email}");            
            $this->info('Password:'.$password);

        } catch (\Exception $err) {
            $this->error('Failed to create admin account: ' . $err->getMessage());
        }
    }
}
