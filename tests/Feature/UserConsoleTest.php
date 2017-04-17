<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class UserConsoleTest extends TestCase
{
    const NAME = 'Test5478983Test';
    const PASSWORD = 'qwerty';
    const INFO = '42424242424242';
    const UPDATED_INFO = 'Test5478983TestInfo';

    public function testWork()
    {
        //создание поьзователя
        Artisan::call('user:create', [
            'name' => self::NAME,
            'password' => self::PASSWORD,
            'info' => self::INFO,
        ]);

        $this->assertDatabaseHas('users', [
            'name' => self::NAME,
            'info' => self::INFO,
        ]);

        $user = EntityManager::getRepository('App\Entities\Users')->findOneBy(['name' => self::NAME]);

        //проверка пароля
        $this->assertTrue(Hash::check(self::PASSWORD, $user->getPasswordHash()));

       //обновления поля info
        Artisan::call('user:update', [
            'name' => self::NAME,
            'info' => self::UPDATED_INFO
        ]);
        $this->assertEquals($user->getInfo(), self::UPDATED_INFO);

        //проверка /user-info/{name}
        $this->get('/user-info/' . self::NAME)->assertSee(self::UPDATED_INFO);

        //удаление тестовой записи из базы и кэша
        Cache::forget(self::NAME);
        EntityManager::remove($user);
        EntityManager::flush();

        $this->assertTrue(true);
    }
}
