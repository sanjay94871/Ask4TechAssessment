<?php

/**
 * Class LinuxOS
 * Represents a parser implementation for Linux operating systems.
 */
class LinuxOS implements Parser {
    /**
     * Parses the output response from a Linux operating system.
     *
     * @param string       $ip              The IP address of the device.
     * @param object       $protocol_object The device client object used for communication.
     * @param string       $hostname        The hostname of the device.
     */
    public static function ParseHandler($ip,$protocol_object ,$hostname) {

        $command= "ifconfig";

        // Sending command to the device and getting the response
        $response=$protocol_object->sendCommand($ip,$command,"LinuxOS");

        //regex to extract attributes from SwitchOS response
        $pattern='/\d+:\s*(\w+):.*?link\/ether\s*([\da-fA-F:]+).*?inet\s*(\d+\.\d+\.\d+\.\d+)\/\d+/ms';

        // Creating an instance of ParsingModule to parse and process the output
        $obj=new ParsingModule();
        $obj->parseOutput($response,$pattern,$hostname);

    }
}
