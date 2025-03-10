<?php

use KairosPublisher\Connections;
use PHPUnit\Framework\TestCase;

class ConnectionsTest extends TestCase
{
    /**
     * @covers \KairosPublisher\Connections::__construct
     */
    public function testCanBeInstanciated()
    {
        $config = [];
        $connections = new Connections($config);
        $this->assertInstanceOf(Connections::class, $connections);
    }

    /**
     * @covers \KairosPublisher\Connections::createConnections
     */
    public function testCreateConnections()
    {
        $config = [
            [
                'host'   => 'localhost',
                'port'   => 6379,
            ],
            [
                'host'   => 'localhost',
                'port'   => 6380,
            ]
        ];
        $client = new \stdClass();
        $connectionsPartialMock = Mockery::mock(Connections::class, [$config])->makePartial();
        $connectionsPartialMock->shouldReceive('newClient')
            ->twice()
            ->withAnyArgs()
            ->andReturn($client);
        $result = $connectionsPartialMock->createConnections();
        $this->assertInternalType('array', $result);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
