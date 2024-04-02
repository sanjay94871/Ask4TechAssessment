# Requirements

1. **Single Argument Input:**  
   The script should accept a single argument: the hostname of the device.

2. **Database Query:**  
   Upon receiving the hostname, the script should query the database to retrieve essential information about the device management interface.

3. **Client Selection:**  
   Depending on the type of management interface, the script should dynamically select either the `SSHClient` or `TelnetClient` class to establish a connection to the device.

4. **Command Execution and Parsing:**  
   Once connected, the script should execute a command to list interface configurations on the device. It should then parse the command output according to the operating system of the device and extract relevant interface details.

5. **CSV Output:**  
   The script should print the name, MAC address, and IP address of each interface in CSV format, with one interface per line.

6. **Extensibility for Multiple Operating Systems:**  
   The code should be designed to be easily extendable to accommodate additional operating systems with varying command formats and response structures. This ensures flexibility in handling devices with diverse configurations.

7. **Modularity and Abstraction:**  
   Emphasis should be placed on modularity and abstraction in the script design. This facilitates future modifications or additions.

The script should combine database interaction, network communication, and data parsing to provide a comprehensive solution for managing network devices' interface information. 
