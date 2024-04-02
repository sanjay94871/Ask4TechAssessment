<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once 'GetManagementInt.php'; 
require_once "$root/OSParsers/Parser.php"; 
require_once "$root/OSParsers/LinuxOS.php"; 
require_once "$root/OSParsers/SwitchOS.php"; 
require_once "$root/DeviceClient.php"; 

// Check for command-line arguments
if ($argc != 2) {
    die("Usage: php script.php <hostname>\n");
}

// Get the hostname from command-line argument
$hostname = $argv[1];



$manager = new GetManagementInt('localhost', 'networkdevices');

// Get management interface details for the specified hostname
$result = $manager->getManagementInterfaceDetails($hostname);

if (is_array($result)) {

    // Display management interface details
    echo "Management Interface: " . $result['management_interface'] . "\n";
    echo "MAC Address: " . $result['mac_address'] . "\n";
    echo "IPv4 Address: " . $result['ipv4_address'] . "\n";
    echo "OS Type: " . $result['os_type'] . "\n";
    echo "Management Protocol: " . $result['management_protocol'] . "\n";

    // Set protocol object based on management protocol
    $protocol_object = setProtocol($result['management_protocol']);
    
    if ($protocol_object) {
        try {
            // Call the ParseHandler method of the respective OS type class
            $result['os_type']::ParseHandler($result['ipv4_address'], $protocol_object, $hostname);
        } catch (Error $e) {
            echo "Class not found: " . $e->getMessage();
        }
    } else {
        // Output error if management protocol is not recognized
        die("Error with 'management_protocol");
    }
} else {
    // Output error message or "No data found" message if result is not an array
    echo $result;
}

/**
 * Sets the protocol object based on the management protocol.
 *
 * @param string $management_protocol The management protocol.
 * @return object The protocol object for the specified protocol.
 */
function setProtocol($management_protocol){

    switch ($management_protocol) {
        case 'SSH':
            $protocol_object = new Ask4\Network\SSHClient();  
            break;     
        case 'Telnet':
            $protocol_object = new Ask4\Network\TelnetClient();
            break;
        default:
            echo "No specific handler for this protocol type.\n";
        
        $protocol_object = null;
    }
    return $protocol_object;
}
