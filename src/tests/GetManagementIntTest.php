<?php

use PHPUnit\Framework\TestCase;

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/GetManagementInt.php";

class GetManagementIntTest extends TestCase
{
    private $host = 'localhost';
    private $dbname = 'networkdevices';
    private $instance;

    public function setUp(): void
    {
        // Create a new instance of the class before each test
        $this->instance = new GetManagementInt($this->host, $this->dbname);
    }

    public function testConstructor()
    {
        // Test that the instance is created successfully
        $this->assertInstanceOf(GetManagementInt::class, $this->instance);
    }

    public function testGetManagementInterfaceDetailsWithValidHostname()
    {
        // Prepare expected result
        $expected = [
            'management_interface' => 'eth0',
            'mac_address' => '00:11:22:33:44:55',
            'ipv4_address' => '192.168.1.1',
            'os_type' => 'LinuxOS',
            'management_protocol' => 'SSH'
        ];

        // Call the method with a known valid hostname
        $result = $this->instance->getManagementInterfaceDetails('device1');

        // Assert that the result matches the expected data
        $this->assertEquals($expected, $result);
    }

    public function testGetManagementInterfaceDetailsWithInvalidHostname()
    {
        // Call the method with an invalid hostname
        $result = $this->instance->getManagementInterfaceDetails('invalidhost.example.com');

        // Assert that the expected error message is returned
        $this->assertEquals('No data found for hostname: invalidhost.example.com', $result);
    }

}