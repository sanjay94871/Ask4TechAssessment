<?php
use Ask4\Network\DeviceClient;

interface Parser{
    /**
     * Interface Parser
     * Defines a common method for parsing handler implementations.
     *
     * @param string $ip
     * @param DeviceClient $protocol_object
     * @param string $hostname
     * @return mixed
     */
    public static function ParseHandler(string $ip, DeviceClient $protocol_object , string $hostname);
}

/**
 * Class ParsingModule
 * Responsible for parsing output data and performing operations on the parsed data.
 */
class ParsingModule{
    /**
     * Parses the output data, writes it to a file, and prints it.
     *
     * @param string $response The response data to parse.
     * @param string $pattern  The pattern to match for extracting interface details.
     * @param string $hostname The hostname.
     */
    public function parseOutput(string $response, string $pattern, string $hostname)
    {
        $interfaces = $this->extractInterfaceDetails($response, $pattern);
        $this->writeToFile($interfaces, $hostname);
        $this->printOutput($interfaces);
    }

    /**
     * Extracts interface details from the response using the specified pattern.
     *
     * @param string $response The response data to parse.
     * @param string $pattern  The pattern to match for extracting interface details.
     * @return array An array containing the extracted interface details.
     */
    private function extractInterfaceDetails(string $response, string $pattern): array
    {
        $interfaces = [];
        preg_match_all($pattern, $response, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $interface = [
                'interface' => $match[1],
                'ip_address' => $match[3],
                'mac_address' => $match[2],
   
            ];
            $interfaces[] = $interface;
        }

        return $interfaces;
    }

    /**
     * Writes the interface details to a CSV file.
     *
     * @param array  $interfaces An array containing the interface details.
     * @param string $hostname   The hostname.
     */
    private function writeToFile(array $interfaces, string $hostname)
    {
        $file = fopen("output/$hostname.csv", 'w');
        fputcsv($file, ['Interface', 'IP Address', 'MAC Address']);

        foreach ($interfaces as $interface) {
            fputcsv($file, $interface);
        }

        fclose($file);
    }

    /**
     * Prints the interface details to the console.
     *
     * @param array $interfaces An array containing the interface details.
     */
    private function printOutput(array $interfaces){

        echo "\nInterface|   IP Address         |   MAC Address\n";
        foreach ($interfaces as $interface) {
            echo "{$interface['interface']}   |   {$interface['ip_address']}   |   {$interface['mac_address']}\n";
        }
    }
}