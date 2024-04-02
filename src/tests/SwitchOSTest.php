<?php

use PHPUnit\Framework\TestCase;

class SwitchOSTest extends TestCase
{
    public function testSwitchOSParseHandler()
    {
        $mockSSHClient = $this->createMock(Ask4\Network\SSHClient::class);
        $mockSSHClient->method('sendCommand')
            ->willReturn("Ethernet0/0 is up
            Hardware is AmdP2, address is 0003.e39b.9220
            Internet address is 10.1.0.1/24
            MTU 1500 bytes
        GigabitEthernet0/1 is up
            Hardware is BCM1125, address is 0015.5b46.5300
            Internet address is 1.2.0.1/20
            MTU 1500 bytes");

        $hostname=   "device2";

        $outputFilePath = "output/$hostname.csv";;
        if (file_exists($outputFilePath)) {
            unlink($outputFilePath);
        }

        ob_start();
        SwitchOS::ParseHandler('192.168.1.1',$mockSSHClient, $hostname);
        $output = ob_get_clean();


        $this->assertFileExists($outputFilePath);
        $this->assertStringContainsString('Ethernet0/0,10.1.0.1,0003.e39b.9220', file_get_contents($outputFilePath));

        $expectedOutput = "Interface|   IP Address         |   MAC Address
        Ethernet0/0   |   10.1.0.1   |   0003.e39b.9220
        GigabitEthernet0/1   |   1.2.0.1   |   0015.5b46.5300";
        
        $expectedOutput = preg_replace('/\s+/', '', $expectedOutput);
        $output = preg_replace('/\s+/', '', $output);

        $this->assertEquals($expectedOutput, $output);
    }
}