<?php

namespace Tests\Feature;

use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
   private UserService $userService;

   public function setUp():void
   {
    parent::setUp();

    DB::delete("delete from users");

    $this->userService = $this->app->make(UserService::class);
   }

   public function testLoginSuccess()
   {
    $this->seed(UserSeeder::class);
    self::assertTrue($this->userService->login("andry@gmail.com", 'rahasia'));
   }

   public function testLoginNotFound()
   {
    self::assertFalse($this->userService->login('eko', 'eko'));
   }

   public function testLoginWrongPassword()
   {
    self::assertFalse($this->userService->login('andry', 'salah'));
   }
}
