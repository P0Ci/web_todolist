<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    public function testLogin()
    {
        $this->get('/login')
            ->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "andry"
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "andry",
            "password" => "rahasia"
        ])->assertRedirect('/')
            ->assertSessionHas("user", "andry");
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText("User atau Password belum di isi");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => 'wrong',
            'password' => 'wrong'
        ])->assertSeeText("User atau Password salah");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "andry"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }

}
