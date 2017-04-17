<?php

namespace App\Console\Commands;

use App\Entities\Users;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {password} {info}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user';

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
     * @return mixed
     */
    public function handle()
    {
        $validator = Validator::make($this->arguments(), [
            'name' => 'required|unique:App\Entities\Users|max:50',
            'password' => 'required|min:6',
            'info' => 'required'
        ]);

        if ($validator->fails()){
            $errMsg = '';
            foreach ($validator->errors()->all() as $error) {
                $errMsg .= $error . "\r";
            }

            $this->error($errMsg);
        } else {
            $name = $this->argument('name');
            $password = $this->argument('password');
            $info = $this->argument('info');

            $user = new Users($name, $password, $info);
            EntityManager::persist($user);
            EntityManager::flush();

            $this->info('Done');
        }
    }
}
