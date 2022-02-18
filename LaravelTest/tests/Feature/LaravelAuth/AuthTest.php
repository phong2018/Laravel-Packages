<?php

namespace Phonglg\LaravelTest\Tests\Feature\LaravelAuth;

use Mews\Captcha\Captcha;
use App\Service;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class AuthTest extends TestCase
{ 
    /**
     * A basic test example.
     *
     * @return void
     */
    // sail php artisan test --filter test_redirect_dashboard_to_login
    public function test_redirect_dashboard_to_login()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    
    }


     // sail php artisan test --filter test_after_login_redirect
    public function test_after_login_redirect()
    { 
          $user = [
            'username' => 'admin', 
            'password' => '1234',   
          ];
      
          $response = $this->post('/login', $user); 

          $response->assertRedirect('/dashboard'); 
    }
     

    // sail php artisan test --filter test_after_register_redirect
    public function test_after_register_redirect()
    {       
          $u=time();
          $user = [
            'username' => $u,
            'name' => $u,
            'email' => $u.'@gmail.com', 
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'identity_card_number'=>'111111',
            'status' => 'enable',
            'captcha'=>'1234',
          ]; 
           
          $response = $this->post('/register', $user);   
          
          $response->assertRedirect('/account/edit'); 
    }
    
}
