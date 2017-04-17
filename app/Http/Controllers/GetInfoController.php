<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use LaravelDoctrine\ORM\Facades\EntityManager;

class GetInfoController extends Controller
{
    public function __invoke($name)
    {
        if (Cache::has($name)){
            return Cache::get($name);
        }

        $user = EntityManager::getRepository('App\Entities\Users')->findOneBy(['name' => $name]);

        Cache::put($name, $user->getInfo(), 480);
        return $user->getInfo();
    }
}