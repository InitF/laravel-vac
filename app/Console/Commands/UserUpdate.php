<?php

namespace App\Console\Commands;

use App\Entities\Users;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UserUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update {name} {info}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user';

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
            'name' => 'required|max:50|exists:App\Entities\Users',
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
            $info = $this->argument('info');

            $user = EntityManager::getRepository('App\Entities\Users')->findOneBy(['name' => $name]);
            $user->setInfo($info);
            EntityManager::persist($user);
            EntityManager::flush();

            $this->info('Done');
        }
    }
}
