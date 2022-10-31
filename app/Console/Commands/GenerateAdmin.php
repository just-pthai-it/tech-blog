<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class GenerateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generate-admin {name} {nickname} {email} {password}';

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
    public function handle()
    {
        $inputs = $this->arguments();
        $inputs['password'] = bcrypt($inputs['password']);
        Admin::create(Arr::except($inputs, ['command']));

        return CommandAlias::SUCCESS;
    }
}
