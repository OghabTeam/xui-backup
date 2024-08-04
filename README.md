# FTP Backup Upload Script

This PHP script uploads a backup file to a remote FTP server. It is intended to be run periodically using `crontab` on an Ubuntu system.

## Prerequisites

To run this script, you need to have PHP installed on your server. Follow these steps to install PHP 8.1 and necessary extensions on Ubuntu:

1. Update the package list and upgrade existing packages:
    ```bash
    sudo apt update && sudo apt upgrade -y
    ```
2. Add the PHP repository:
    ```bash
    sudo add-apt-repository ppa:ondrej/php
    ```
3. Update the package list again:
    ```bash
    sudo apt update
    ```
4. Install PHP 8.1:
    ```bash
    sudo apt install php8.1 -y
    ```
5. Install additional PHP 8.1 extensions:
    ```bash
    sudo apt-get install -y php8.1-cli php8.1-common php8.1-mysql php8.1-zip php8.1-gd php8.1-mbstring php8.1-curl php8.1-xml php8.1-bcmath
    ```

## Usage

1. Clone the repository to your local machine.
2. Update the FTP credentials and file paths in `backup_upload.php`.
3. Make the script executable:
    ```bash
    chmod +x /path/to/backup_upload.php
    ```
4. Add a cron job to execute the script every minute:
    ```bash
    * * * * * /usr/bin/php /path/to/backup_upload.php
    ```

## Configuration

- **FTP credentials:**
  - `$ftp_username`: FTP username.
  - `$ftp_userpass`: FTP password.
  - `$ftp_server`: FTP server address.

- **File paths:**
  - `$local_file`: Path to the local file to be backed up.
  - `$remote_file`: Path on the FTP server where the file will be uploaded.

## Error Handling

The script includes basic error handling for:
- Connection to the FTP server.
- Login to the FTP server.
- File upload process.

## Example

Here's an example configuration for the script:

```php
// FTP credentials
$ftp_username = 'your_ftp_username';
$ftp_userpass = 'your_ftp_password';
$ftp_server = 'your_ftp_server_address';

// Files
$local_file = '/path/to/your/local/file';
$remote_file = '/path/on/ftp/server/file';

// Connect to FTP server
$ftp_conn = ftp_connect($ftp_server);
if (!$ftp_conn) {
    die("Couldn't connect to $ftp_server\n");
}

// Login to FTP server
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
if (!$login) {
    ftp_close($ftp_conn);
    die("FTP login failed\n");
}

// Upload file
if (ftp_put($ftp_conn, $remote_file, $local_file, FTP_BINARY)) {
    echo "Successfully uploaded $local_file to $remote_file\n";
} else {
    echo "Error uploading $local_file\n";
}

// Close FTP connection
ftp_close($ftp_conn);
