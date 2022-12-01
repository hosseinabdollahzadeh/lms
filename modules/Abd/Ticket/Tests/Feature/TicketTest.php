<?php

namespace Abd\Ticket\Tests\Feature;

use Abd\RolePermissions\Database\Seeders\RolePermissionTableSeeder;
use Abd\RolePermissions\Models\Permission;
use Abd\Ticket\Models\Ticket;
use Abd\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_can_see_tickets()
    {
        $this->actingAsUser();
        $this->get(route("tickets.index"))->assertOk();
    }

    public function test_user_can_see_create_tickets()
    {
        $this->actingAsUser();
        $this->get(route("tickets.create"))->assertOk();
    }

    public function test_user_can_store_ticket()
    {
        $this->actingAsUser();
        $this->createTicket();
        $this->assertEquals(1, Ticket::all()->count());
    }

    public function test_permitted_user_can_delete_ticket()
    {
        $this->actingAsAdmin();
        $this->createTicket();
        $this->assertEquals(1, Ticket::all()->count());

        $this->delete(route('tickets.destroy', 1))->assertOk();
    }

    public function test_not_permitted_user_can_not_delete_ticket()
    {
        $this->actingAsUser();
        $this->createTicket();
        $this->assertEquals(1, Ticket::all()->count());

        $this->delete(route('tickets.destroy', 1))->assertStatus(403);
    }

    private function actingAsAdmin()
    {
        // create user
        $this->actingAs(User::factory()->create());
        // seed roles and give permission
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_TICKETS);

    }
    private function actingAsUser()
    {
        // create user
        $this->actingAs(User::factory()->create());
        // seed roles and give permission
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function createTicket()
    {
        $this->post(route('tickets.store', ['title'=> $this->faker->word, 'body'=> $this->faker->text]));

    }
}
