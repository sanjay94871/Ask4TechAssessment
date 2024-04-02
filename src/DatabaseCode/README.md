This program uses PostgreSQL as the database to store device and interface information.

# Installation

## PostgreSQL Setup

1. **Install PostgreSQL:**  
   If you don't have PostgreSQL installed, you can download and install PostgreSQL.app from [here](https://postgresapp.com/).
   
2. **Start PostgreSQL Server:**  
   After installation, start the PostgreSQL server from the PostgreSQL.app application.
   
3. **Create Database:**
   Once the PostgreSQL server is running, you need to create a database for the application. Follow these steps:
   
   - Open Terminal.
   - Run the following command to access the PostgreSQL command line interface:
     ```
     psql
     ```
   - In the PostgreSQL shell, execute the following command to create a new database named `networkdevices`:
     ```
     CREATE DATABASE networkdevices;
     ```

4. **Change Directory to Access Database:**  
   To access the `networkdevices` database and execute SQL commands, follow these steps:

   - Change directory to the location where PostgreSQL is installed. For example:
     ``` 
     \c networkdevices;
     ```
   
   - You are now in the PostgreSQL shell for the `networkdevices` database.

6. **Create Tables:**
   After accessing the database, execute the following SQL commands to create tables for storing device and interface information:

   ```sql
   -- Create table for devices
   CREATE TABLE devices (
       hostname VARCHAR(250) PRIMARY KEY,
       device_type VARCHAR(50) NOT NULL,
       os_type VARCHAR(50) NOT NULL,
       model_name VARCHAR(100),
       ram_amount INTEGER,
       management_interface VARCHAR(50),
       management_protocol VARCHAR(10)
   );

   -- Create table for network interfaces
   CREATE TABLE interfaces (
       id SERIAL PRIMARY KEY,
       device_hostname VARCHAR(250) REFERENCES devices(hostname),
       interface_name VARCHAR(50),
       mac_address VARCHAR(17),
       ipv4_address VARCHAR(15),
       is_management BOOLEAN,
       UNIQUE(device_hostname, interface_name)
   );

   -- Create table for device connections
   CREATE TABLE connections (
       id SERIAL PRIMARY KEY,
       device1_hostname VARCHAR(250) REFERENCES devices(hostname),
       device2_hostname VARCHAR(250) REFERENCES devices(hostname),
       interface1_id INTEGER REFERENCES interfaces(id),
       interface2_id INTEGER REFERENCES interfaces(id),
       UNIQUE(device1_hostname, device2_hostname)
   );

7. **Insert Data into Tables:**
    Once the tables are created, you can insert data into them using the following SQL commands:

    ```sql
    -- Insert data into devices table
    INSERT INTO devices (hostname, device_type, model_name, ram_amount, os_type, management_interface, management_protocol)
    VALUES 
    ('device1', 'server', 'Server Model A', 8192, 'LinuxOS', 'eth0', 'SSH'),
    ('device2', 'switch', 'Switch Model X', NULL, 'SwitchOS', 'vlan1', 'Telnet'),
    ('device3', 'server', 'Server Model Z', 16384, 'LinuxOS', 'eth1', 'Telnet');

    -- Insert data into interfaces table
    INSERT INTO interfaces (device_hostname, interface_name, mac_address, ipv4_address, is_management)
    VALUES 
    ('device1', 'eth0', '00:11:22:33:44:55', '192.168.1.1', TRUE),
    ('device1', 'eth1', 'AA:BB:CC:DD:EE:FF', '192.168.1.2', FALSE),
    ('device2', 'vlan1', '11:22:33:44:55:66', '192.168.1.3', TRUE),
    ('device3', 'eth1', '66:77:88:99:AA:BB', '192.168.1.4', TRUE),
    ('device3', 'eth2', 'CC:DD:EE:FF:00:11', '192.168.1.5', FALSE);
    
    -- Insert data into connections table
    INSERT INTO connections (device1_hostname, device2_hostname, interface1_id, interface2_id)
    VALUES 
    ('device1', 'device2', 1, 3),
    ('device1', 'device3', 2, 4);


