<?php

namespace Phonglg\LaravelSelfCreated\Tests;  

use Phonglg\LaravelSelfCreated\LaravelSelfCreatedServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  protected $loadEnvironmentVariables = true;

  public function setUp(): void
  {
    parent::setUp();
    // additional setup
  }

  protected function getPackageProviders($app)
  {
    return [
      LaravelSelfCreatedServiceProvider::class,
    ];
  }
 

  protected function getEnvironmentSetUp($app)
  {
    // perform environment setup
  }

 
}