<?php

require_once 'config.php';

$tables = array();
$query = mysqli_query($conn, 'SHOW TABLES');
while ($row = mysqli_fetch_row($query)) {
    $tables[] = $row[0];
}
$result = "";
foreach ($tables as $table) {
    $query = mysqli_query($conn, 'SELECT * FROM ' . $table);
    $num_fields = mysqli_num_fields($query);

    $result .= 'DROP TABLE IF EXISTS ' . $table . ';';
    $row2 = mysqli_fetch_row(mysqli_query($conn, 'SHOW CREATE TABLE ' . $table));
    $result .= "\n\n" . $row2[1] . ";\n\n";

    for ($i = 0; $i < $num_fields; $i++) {
        while ($row = mysqli_fetch_row($query)) {
            $result .= 'INSERT INTO ' . $table . ' VALUES(';
            for ($j = 0; $j < $num_fields; $j++) {
                $row[$j] = addslashes($row[$j]);
                $row[$j] = str_replace("\n", "\\n", $row[$j]);
                if (isset($row[$j])) {
                    $result .= '"' . $row[$j] . '"';
                } else {
                    $result .= '""';
                }
                if ($j < ($num_fields - 1)) {
                    $result .= ',';
                }
            }
            $result .= ");\n";
        }
    }
    $result .= "\n\n";
}
//Create Folder
$folder = 'backups/';
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

chmod($folder, 0777);

$date = date('Y-m-d');
$filename = $folder . "db_backup_" . $date . "_" . time();
$handle = fopen($filename . '.sql', 'w+');
$backup_status = null;
if (fwrite($handle, $result)) {
    $backup_status = "success";
}
$sql = "INSERT INTO `database_backup`(`backup_file_name`, `backup_status`) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $filename, $backup_status);
$stmt->execute();
fclose($handle);
die;
