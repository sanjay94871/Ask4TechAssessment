<?php
/**
 * Class GetManagementInt
 * Retrieves management interface details from the database.
 */
class GetManagementInt {
    private $pdo;

    /**
     * Constructor to establish database connection.
     *
     * @param string $hostdb The database host.
     * @param string $dbname The database name.
     */
    public function __construct($hostdb, $dbname) {
        try {
            // Establish PDO connection
            $this->pdo = new \PDO("pgsql:host=$hostdb;dbname=$dbname");
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Handle connection error
            die("Error: " . $e->getMessage());
        }
    }

    /**
     * Function to fetch management interface details for a given hostname.
     *
     * @param string $hostname The hostname of the device.
     * @return array|string The management interface details if found, otherwise an error message.
     */
    public function getManagementInterfaceDetails($hostname) {
        try {
            // Prepare SQL statement to fetch data
            $stmt = $this->pdo->prepare("
                SELECT d.management_interface, i.mac_address, i.ipv4_address, d.os_type, d.management_protocol
                FROM devices d
                INNER JOIN interfaces i ON d.hostname = i.device_hostname
                WHERE d.hostname = :hostname AND d.management_interface = i.interface_name
            ");

            // Bind parameters and execute
            $stmt->bindParam(':hostname', $hostname, \PDO::PARAM_STR);
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Check if data found
            if ($result) {
                return $result;
            } else {
                return "No data found for hostname: $hostname";
            }
        } catch (PDOException $e) {
            // Handle database error
            return "Error: " . $e->getMessage();
        }
    }
}

