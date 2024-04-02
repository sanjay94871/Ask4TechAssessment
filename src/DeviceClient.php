<?php

namespace Ask4\Network;

interface DeviceClient
{
    /**
     * Synchronously executes the given command and returns the output
     *
     * A connection to the specified IP will be opened (ignore authentication), and the
     * command will be sent.  The response will be returned verbatim as a string.
     *
     * @param string $ip IP of device to connect to
     * @param string $command Command to execute
     * @return string Response from the device
     */
    public function sendCommand(string $ip, string $command,string $ostype): string;
}


/**
 * Class SSHClient
 * Represents a client for communicating with devices over SSH protocol.
 */
class SSHClient implements DeviceClient
{
    /**
     * Synchronously executes the given command over SSH and returns the output.
     *
     * @param string $ip IP of device to connect to.
     * @param string $command Command to execute.
     * @param string $ostype The operating system type of the device.
     * @return string Response from the device.
     */
    public function sendCommand(string $ip, string $command, string $ostype): string
    {
        // Placeholder for SSH connection and command execution
        return sendSampleResponse($ostype);
    }
}

/**
 * Class TelnetClient
 * Represents a client for communicating with devices over Telnet protocol.
 */
class TelnetClient implements DeviceClient
{
    /**
     * Synchronously executes the given command over Telnet and returns the output.
     *
     * @param string $ip IP of device to connect to.
     * @param string $command Command to execute.
     * @param string $ostype The operating system type of the device.
     * @return string Response from the device.
     */
    public function sendCommand(string $ip, string $command, string $ostype): string
    {
        // Placeholder for Telnet connection and command execution
        return sendSampleResponse($ostype);
    }
}

/**
 * Simulates the response from a device based on the operating system type.
 *
 * @param string $ostype The operating system type of the device.
 * @return string Simulated response from the device.
 */
function sendSampleResponse(string $ostype): string
{
    if ($ostype == "LinuxOS") {
        // Simulated response for LinuxOS
        return "1: enp3s0: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc fq_codel state UP group default qlen 1000 link/ether fc:aa:14:6d:39:ae brd ff:ff:ff:ff:ff:ff inet 10.50.245.40/24 brd 10.50.245.255 scope global dynamic enp3s0 valid_lft 30401sec preferred_lft 30401sec 2: virbr0: <NO-CARRIER,BROADCAST,MULTICAST,UP> mtu 1500 qdisc noqueue state DOWN group default qlen 1000 link/ether 52:54:00:e7:dd:dc brd ff:ff:ff:ff:ff:ff inet 192.168.122.1/24 brd 192.168.122.255 scope global virbr0 valid_lft forever preferred_lft forever 3: virbr1: <NO-CARRIER,BROADCAST,MULTICAST,UP> mtu 1500 qdisc noqueue state DOWN group default qlen 1000 link/ether 52:54:00:12:0d:4a brd ff:ff:ff:ff:ff:ff inet 192.168.125.1/24 brd 192.168.125.255 scope global virbr1 valid_lft forever preferred_lft forever";
    } else {
        // Simulated response for SwitchOS
        return "Ethernet0/0 is up
        Hardware is AmdP2, address is 0003.e39b.9220
        Internet address is 10.1.0.1/24
        MTU 1500 bytes
    GigabitEthernet0/1 is up
        Hardware is BCM1125, address is 0015.5b46.5300
        Internet address is 1.2.0.1/20
        MTU 1500 bytes";
    }
}