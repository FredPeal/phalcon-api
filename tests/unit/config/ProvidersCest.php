<?php

namespace Gewaer\Tests\unit\config;

use Canvas\Providers\CliDispatcherProvider;
use Gewaer\Providers\ConfigProvider;
use Gewaer\Providers\DatabaseProvider;
use Gewaer\Providers\ErrorHandlerProvider;
use Canvas\Providers\LoggerProvider;
use Canvas\Providers\ModelsMetadataProvider;
use Canvas\Providers\RequestProvider;
use Gewaer\Providers\RouterProvider;
use UnitTester;
use function Canvas\Core\appPath;

class ProvidersCest
{
    public function checkApiProviders(UnitTester $I)
    {
        $providers = require appPath('api/config/providers.php');

        $I->assertEquals(ConfigProvider::class, $providers[0]);
        $I->assertEquals(LoggerProvider::class, $providers[1]);
        $I->assertEquals(ErrorHandlerProvider::class, $providers[2]);
        $I->assertEquals(DatabaseProvider::class, $providers[3]);
        $I->assertEquals(ModelsMetadataProvider::class, $providers[4]);
        $I->assertEquals(RequestProvider::class, $providers[5]);
        $I->assertEquals(RouterProvider::class, $providers[6]);
    }

    public function checkCliProviders(UnitTester $I)
    {
        $providers = require appPath('cli/config/providers.php');

        $I->assertEquals(ConfigProvider::class, $providers[0]);
        $I->assertEquals(LoggerProvider::class, $providers[1]);
        $I->assertEquals(ErrorHandlerProvider::class, $providers[2]);
        $I->assertEquals(DatabaseProvider::class, $providers[3]);
        $I->assertEquals(ModelsMetadataProvider::class, $providers[4]);
        $I->assertEquals(CliDispatcherProvider::class, $providers[5]);
    }
}
