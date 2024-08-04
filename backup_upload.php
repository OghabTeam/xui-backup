<?php

// FTP credentials
$ftp_username = 'user1';
$ftp_userpass = 'p1234';
$ftp_server = '85.10.193.11';

// Files
$local_file = '/etc/x-ui/x-ui.db';
$remote_file = '/DB-backups/x-ui.db';

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

?>
