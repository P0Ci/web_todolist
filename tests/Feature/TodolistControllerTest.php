<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "andry",
            "todolist" => [
                "id" => "1",
                "todo" => "Luka"
            ],
            [
                "id" => "2",
                "todo" => "Doncic"
            ]
        ])->get('/todolist')
                ->assertSeeText("1")
                ->assertSeeText("Luka");
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
