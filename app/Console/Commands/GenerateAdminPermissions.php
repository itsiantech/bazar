<?php

namespace App\Console\Commands;

use App\Services\PermissionGeneratorService;
use Illuminate\Console\Command;

class GenerateAdminPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:permissions_admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Admin Permission. If needed default user will be created and assign the admin role to that user. user email:gdnayeem1996@gmail.com password:12345678';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $status = (new PermissionGeneratorService)->generate();

        if($status == True)
            $this->info('Permissions generated successfully');
        else
            $this->error($status);
    }
}
