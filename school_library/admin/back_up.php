<?php
//// Database connection parameters
//$host = 'localhost';
//$username = 'root';
//$password = 'root';
//$database = 'lab';
//
//// Backup file path and name
//$backupFile = 'backup_file.sql';
//
//// Create the command to execute mysqldump
//$command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$backupFile}";
//echo $command;
//// Execute the command
//exec($command, $output, $returnStatus);
//
//
//// Check if the command executed successfully
//if ($returnStatus === 0) {
//    echo 'Backup created successfully.';
//} else {
//    echo 'Backup creation failed.';
$phpUser = get_current_user();
echo "PHP User: " . $phpUser;

//}
//?>
