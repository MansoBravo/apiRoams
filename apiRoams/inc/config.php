<?php
$db = new SQLite3('palenciaRural.db');
$db->busyTimeout(5000);
$db->exec('PRAGMA journal_mode = wal;');
$tablesquery = $db->query("SELECT name FROM sqlite_master WHERE type='table';");
$tables = $tablesquery->fetchArray(SQLITE3_ASSOC);
if ($tables == ''){
    echo json_encode(array('error' => " Tablas no creadas"));
    exit;
}
?>