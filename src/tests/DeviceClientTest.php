<?php

use PHPUnit\Framework\TestCase;

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once "$root/OSParsers/Parser.php";
require_once "$root/OSParsers/LinuxOS.php";
require_once "$root/OSParsers/SwitchOS.php";
require_once "$root/DeviceClient.php";

class DeviceClientTest extends TestCase
{
    public function testSSHClientSendCommand()
    {
        $client = new Ask4\Network\SSHClient();
        $output = $client->sendCommand('192.168.1.1', 'show interfaces', 'LinuxOS');
        $this->assertStringContainsString('enp3s0', $output);
        $this->assertStringContainsString('virbr0', $output);
        $this->assertStringContainsString('virbr1', $output);
    }

    public function testTelnetClientSendCommand()
    {
        $client = new Ask4\Network\TelnetClient();
        $output = $client->sendCommand('192.168.1.1', 'show interfaces', 'SwitchOS');
        $this->assertStringContainsString('Ethernet0/0', $output);
        $this->assertStringContainsString('GigabitEthernet0/1', $output);
    }
}

