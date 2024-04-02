# Starting the Network Manager Program

To start the Network Manager program, follow these steps:

1. Make sure you have PHP installed on your system. If not, you can download and install it from [php.net](https://www.php.net/downloads).

2. Open your terminal or command prompt.

3. Navigate to the directory where the NetworkManager.php file is located.

4. Run the following command:

    ```bash
    php NetworkManager.php <hostname>
    ```

Replace `<hostname>` with the hostname you want to use for the program.

5. Press Enter to execute the command.

6. The Network Manager program should start and begin its operations.

## Running PHPUnit Tests

To run PHPUnit tests for the Network Manager program, follow these additional steps:

1. Make sure you have PHPUnit installed globally on your system. If not, you can install it using Composer or download it directly from [phpunit.de](https://phpunit.de/).

2. Navigate to the directory where the PHPUnit tests for the Network Manager program are located.

3. Run the following command to execute the tests:

    ```bash
    phpunit --testdox
    ```

4. Press Enter to execute the command.

5. PHPUnit will run the tests and display the results in the terminal.

## Extending the Program to Support Additional Operating Systems

1. Create a new class that implements the `Parser` interface.

2. Define the `ParseHandler` method within the class.

3. This method should parse the output response specific to the new operating system.

4. Determine the command needed to retrieve interface information from devices running the new operating system.

5. Develop regular expressions to extract relevant interface details from the command output.

6. Utilize the provided DeviceClient object for communication with devices over SSH or telnet.

7. Use the appropriate methods from the DeviceClient object to send commands and receive responses from devices

8. Create an instance of `ParsingModule` to further process the response from the device.

9. Pass the response, regex pattern, and hostname to the  ParsingModule `parseOutput` method for parsing and processing.
