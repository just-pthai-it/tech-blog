<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;
use const App\Helpers\ROLES;

class GenerateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:admin {name} {nickname} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate admin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        $inputs = $this->arguments();
        $inputs['password'] = bcrypt($inputs['password']);
        $inputs['role'] = ROLES['admin'];
        User::create(Arr::except($inputs, ['command']));

        return CommandAlias::SUCCESS;
    }
}
