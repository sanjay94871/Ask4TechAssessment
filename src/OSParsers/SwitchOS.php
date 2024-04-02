<?php

/**
 * Class SwitchOS
 * Represents a parser implementation for SwitchOS devices.
 */
class SwitchOS implements Parser {
    /**
     * Parses the output response from a SwitchOS device.
     *
     * @param string       $ip              The IP address of the device.
     * @param object       $protocol_object The device client object used for communication.
     * @param string       $hostname        The hostname of the device.
     */
    public static function ParseHandler($ip,$protocol_object ,$hostname) {
        
        $command= "show interfaces";

        // Sending command to the device and getting the response
        $response=$protocol_object->sendCommand($ip,$command,"SwitchOS");

        //regex to extract attributes from SwitchOS response
        $pattern = '/(\w+\d+\/\d+)\s+is\s+up\s+.*?address\s+is\s+(\w{4}\.\w{4}\.\w{4})\s+.*?address\s+is\s+((?:\d{1,3}\.){3}\d{1,3})/';

        // Creating an instance of ParsingModule to parse and process the output
        $obj=new ParsingModule();
        $obj->parseOutput($response,$pattern,$hostname);

    }
}