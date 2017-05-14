<?php

error_reporting(-1); // Report all PHP errors (E_ALL)
ini_set('display_errors', true);
ini_set('log_errors', false);

require "db.php";

$password = "team3password";

$db = new PROS($password);
$db->init_database("pros");
$db->use_database("pros");

/*---------------------------------------------------------------------*\
|   test user table                                                     |
\*---------------------------------------------------------------------*/

// $data = [
//     "id"         => " NULL",
//     "first_name" => "'Elvis",
//     "last_name"  => "'Peersley",
//     "email"      => "'ep@isp.com",
//     "password"   => "'0123456789ABCDEF",
// ];

// $id = $db->table_insert("user", $data);
// $id = $db->table_insert("user", $data);
// $id = $db->table_insert("user", $data);

// // $rows = $db->table_select("user", "*", "id = 2");
// $rows = $db->table_select("user", "*");
// // out($rows);

// $data = [
//     "last_name"  => "'O'Peersley",
// ];

// $id = $db->table_update("user", $data, "id = 2");

// $rows = $db->table_select("user", "*");
// // out($rows);

// // out($db->count("user"));
// // out($id);

/*---------------------------------------------------------------------*\
|   test asset table                                                    |
\*---------------------------------------------------------------------*/

// $id = $db->table_insert("asset", ["id" => " NULL"]);
// $id = $db->table_insert("asset", ["id" => " NULL"]);
// $id = $db->table_insert("asset", ["id" => " NULL"]);
// $id = $db->table_insert("asset", ["id" => " NULL"]);

// out("asset:id = $id");
// out("asset(count) = " . $db->table_count("asset"));

// $rows = $db->table_select("asset", "*");
// out($rows);

/*---------------------------------------------------------------------*\
|   test version table                                                  |
\*---------------------------------------------------------------------*/

$data = [
    "id"        => " NULL",
    "asset"     => " 1",
    "owner"     => " 1",
    "timestamp" => " NULL",
    "private"   => " TRUE",
];

$id = $db->table_insert("version", $data);
$id = $db->table_insert("version", $data);
$id = $db->table_insert("version", $data);

$rows = $db->table_select("version", "*");
out($rows);

/*---------------------------------------------------------------------*\
\*---------------------------------------------------------------------*/
