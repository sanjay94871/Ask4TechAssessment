<?php

use PHPUnit\Framework\TestCase;

class LinuxOSTest extends TestCase
{
    public function testLinuxOSParseHandler()
    {
        $mockSSHClient = $this->createMock(Ask4\Network\SSHClient::class);
        $mockSSHClient->method('sendCommand')
            ->willReturn("1: enp3s0: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc fq_codel state UP group default qlen 1000 link/ether fc:aa:14:6d:39:ae brd ff:ff:ff:ff:ff:ff inet 10.50.245.40/24 brd 10.50.245.255 scope global dynamic enp3s0 valid_lft 30401sec preferred_lft 30401sec");        

        $hostname =   "device1";
        $outputFilePath = "output/$hostname.csv";

        if (file_exists($outputFilePath)) {
            unlink($outputFilePath);
        }

        ob_start();
        LinuxOS::ParseHandler('192.168.1.1',$mockSSHClient, $hostname);
        $output = ob_get_clean();

        $this->assertFileExists($outputFilePath);
        $this->assertStringContainsString('enp3s0,10.50.245.40,fc:aa:14:6d:39:ae', file_get_contents($outputFilePath));

        $expectedOutput = "Interface|   IP Address         |   MAC Address
        enp3s0   |   10.50.245.40   |   fc:aa:14:6d:39:ae";
        
        $expectedOutput = preg_replace('/\s+/', '', $expectedOutput);
        $output = preg_replace('/\s+/', '', $output);

        $this->assertEquals($expectedOutput, $output);
    }
}