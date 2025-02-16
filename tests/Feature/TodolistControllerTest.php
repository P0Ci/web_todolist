<?php

namespace Tests\Feature;

use Database\Seeders\TodoSeeder;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodolistControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("delete from todos");
    }

    public function testTodolist()
    {
        $this->seed(TodoSeeder::class);
        $this->withSession([
            "user" => "andry"
        ])->get('/todolist')
                ->assertSeeText("1")
                ->assertSeeText("Andry")
                ->assertSeeText("2")
                ->assertSeeText("Febri");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "andry"
        ])->post('/todolist', [])
            ->assertSeeText("Tambahkan Todo");
    }

    public function testAddTodoSukses()
    {
        $this->withSession([
            "user" => "andry"
        ])->post("/todolist", [
            "todo" => "Doncic"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "andry",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Andry"
                ],
                [
                    "id" => "2",
                    "todo" => "Luka"
                ]
            ]
        ])->post("/todolist/1/delete")
                    ->assertRedirect("/todolist");
    }

}
