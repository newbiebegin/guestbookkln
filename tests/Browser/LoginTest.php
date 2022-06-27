<?php

namespace Tests\Browser;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class LoginTest extends DuskTestCase
{
	use RefreshDatabase;
	
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
		// Kita memiliki 1 user terdaftar
        $user = User::factory()->create([
            'email'    => 'username@example.net',
            'password' => bcrypt('secret'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
					->type('@login-email', 'username@example.net')
                    ->type('@login-password', 'secret')
					->press('Sign In')
                    ->assertPathIs('/dashboard')
					;
        });
    }
	
	/**
	 * Get the element shortcuts for the page.
	 *
	 * @return array
	 */
	// public function elements()
	// {
		// return [
			// '@login-email' => 'input[name=email]',
			// '@login-password' => 'input[name=password]',
		// ];
	// }
}
