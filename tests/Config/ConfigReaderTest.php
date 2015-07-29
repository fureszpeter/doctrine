<?php

use Furesz\Doctrine\Config\ConfigReader;

class ConfigReaderTest extends TestCase
{
    /**
     * @var \Furesz\Doctrine\Config\ConfigReader
     */
    private $config;

    public function setUp()
    {
        parent::setUp();
        $this->config = new ConfigReader();
    }

    /**
     * @dataProvider connectionNameProvider
     *
     * @param string $name
     */
    public function testGetDefaultConnectionName($name)
    {
        Config::shouldReceive('get')
            ->withArgs(['doctrine.dbal.default_connection', ''])
            ->andReturn($name);

        $result = $this->config->getDefaultConnectionName();

        $this->assertEquals($name, $result);
    }

    public function testGetDefaultConnectionNameThrowsException()
    {
        $this->setExpectedException(OutOfBoundsException::class);

        Config::shouldReceive('get')
            ->withArgs(['doctrine.dbal.default_connection', ''])
            ->andReturn(null);

        $this->config->getDefaultConnectionName();
    }

    public function testGetConnection()
    {
        $expectedConfig = $this->getConnectionArray('someName');

        Config::shouldReceive('get')
            ->withArgs(['doctrine.dbal.default_connection', ''])
            ->andReturn('someName');

        Config::shouldReceive('get')
            ->withArgs(['doctrine.dbal.connections', []])
            ->andReturn($expectedConfig);

        $configResult = $this->config->getConnection('someName');

        $this->assertEquals($expectedConfig['someName'], $configResult);
    }

    public function testGetConnectionThrowsException()
    {
        $this->setExpectedException(OutOfBoundsException::class);

        $expectedConfig = $this->getConnectionArray('default');

        Config::shouldReceive('get')
            ->withArgs(['doctrine.dbal.default_connection', ''])
            ->andReturn('default');

        Config::shouldReceive('get')
            ->withArgs(['doctrine.dbal.connections', []])
            ->andReturn($expectedConfig);

        $this->config->getConnection('nonExistent');
    }

    public function testGetConnectionGetTheDefaultIfNoParameterSet()
    {
        Config::shouldReceive('get')
            ->withArgs(['doctrine.dbal.default_connection', ''])
            ->andReturn('defaultConnectionName');

        $expectedConfig = $this->getConnectionArray('defaultConnectionName');

        Config::shouldReceive('get')
            ->withArgs(['doctrine.dbal.connections', []])
            ->andReturn($expectedConfig);

        $configResult = $this->config->getConnection();

        $this->assertEquals($expectedConfig['defaultConnectionName'], $configResult);
    }

    /**
     * @return array
     */
    public function connectionNameProvider()
    {
        return [
            ['default'],
            ['mockConnection'],
            ['noMore'],
        ];
    }

    /**
     * @param string $name The name of the connection.
     *
     * @return array
     */
    protected function getConnectionArray($name)
    {
        $expectedConfig = [
            $name => [
                'driver' => '%database_driver%',
                'host' => '%database_host%',
                'port' => '%database_port%',
                'dbname' => '%database_name%',
                'user' => '%database_user%',
                'password' => '%database_password%',
                'charset' => 'UTF8',
            ],
        ];

        return $expectedConfig;
    }
}
