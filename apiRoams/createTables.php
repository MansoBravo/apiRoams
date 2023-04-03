<?php
$db = new SQLite3('palenciaRural.db');
$users = "CREATE TABLE IF NOT EXISTS users(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	dni TEXT NOT NULL,
	nombre TEXT NOT NULL,
	email TEXT NOT NULL,
	capital INTEGER NOT NULL
);";

$hipotecas = "CREATE TABLE IF NOT EXISTS hipotecas(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	dni TEXT NOT NULL,
	tae REAL NOT NULL,
    anos INTEGER NOT NULL
);";

$resultado = $db->exec($users);
$resultado = $db->exec($hipotecas);

echo json_encode(array('info' => " Tablas creadas correctamente"));
?>