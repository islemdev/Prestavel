<?php
use Orchestra\Testbench\TestCase;
use Islemdev\Prestavel\Facades\PrestavelConnector;
use Islemdev\Prestavel\PrestavelServiceProvider;

class GlobalTest extends TestCase
{

    protected function getEnvironmentSetUp($app)
    {
        # Setup default database to use sqlite :memory:
        $app['config']->set('prestavel.api_url', 'http://localhost/prestashop');
        $app['config']->set('prestavel.api_token', 'WS3JKDKJD37MZ6KAP8S6AHQJ8EK1QIB3');

    }

    protected function getPackageProviders($app)
    {
        return [
            PrestavelServiceProvider::class
        ];
    }
    //

    /** @test */
    public function test_authorization()
    {
        //
    }
}