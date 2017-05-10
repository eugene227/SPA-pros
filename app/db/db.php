<?php

/*---------------------------------------------------------------------*\
|   WARNING!!!                                                          |
|   THIS CODE WILL **DELETE/RESET** THE EXISTING PROS DATABASE          |
|   DEVELOPMENT ONLY - DO NOT DEPLOY                                    |
\*---------------------------------------------------------------------*/

error_reporting(-1); // Report all PHP errors (E_ALL)
ini_set('display_errors', true);
ini_set('log_errors', false);

$db_name  = "pros";
$password = "team3password";

$db = new mysqli("localhost", "root", $password);
if ($error = $db->connect_error) {
    echo $error;
    exit();
}
$db->set_charset('utf8');

/*---------------------------------------------------------------------*\
|   function to create new empty database                               |
\*---------------------------------------------------------------------*/

function create_new_database($db, $name)
{
    $error = $db->query("DROP DATABASE IF EXISTS {$name};");
    $error = $db->query("CREATE DATABASE IF NOT EXISTS {$name};");
}

create_new_database($db, $db_name);

$error = $db->query("USE {$db_name};");

/*---------------------------------------------------------------------*\
|   function to drop all tables a database                              |
\*---------------------------------------------------------------------*/

function drop_all_tables($db)
{
    $db->query("SET foreign_key_checks = 0");

    if ($result = $db->query("SHOW TABLES")) {
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $db->query("DROP TABLE IF EXISTS " . $row[0]);
        }
    }

    $db->query("SET foreign_key_checks = 1");
}

/*---------------------------------------------------------------------*\
|   create `user` table                                                 |
\*---------------------------------------------------------------------*/

$sql = <<<SQL
CREATE TABLE `pros`.`user`
( `id`          INT UNSIGNED NOT NULL ,
  `email`       TEXT NOT NULL ,
  `first_name`  TEXT NOT NULL ,
  `last_name`   TEXT NOT NULL ,
  `password`    TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;

$result = $db->query($sql);

// add dummy users

/*---------------------------------------------------------------------*\
|   create `asset` table                                                |
\*---------------------------------------------------------------------*/

$sql = <<<SQL
CREATE TABLE `pros`.`asset`
( `id`          INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;

$result = $db->query($sql);

/*---------------------------------------------------------------------*\
|   create `version` table                                              |
\*---------------------------------------------------------------------*/

$sql = <<<SQL
CREATE TABLE `pros`.`version`
( `id`          INT UNSIGNED NOT NULL ,
  `asset`       INT UNSIGNED NOT NULL , # foreign key asset(id)
  `owner`       INT UNSIGNED NOT NULL , # foreign key user(id)
  `version`     TIMESTAMP NOT NULL ,
  `latest`      BOOLEAN NOT NULL DEFAULT TRUE ,
  `private`     BOOLEAN NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;

// FIXME
// $sql .= <<<SQL
// ALTER TABLE `pros`.`version` ADD FOREIGN KEY(asset)
// REFERENCES asset(id) ON UPDATE RESTRICT ON DELETE RESTRICT ;
// SQL;

$result = $db->query($sql);

/*---------------------------------------------------------------------*\
|   create `choice_list` table                                          |
\*---------------------------------------------------------------------*/

$sql = <<<SQL
CREATE TABLE `pros`.`choice_list`
( `id`          INT UNSIGNED NOT NULL ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `list`        TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;

$result = $db->query($sql);

/*---------------------------------------------------------------------*\
|   create `question` table                                             |
\*---------------------------------------------------------------------*/

$sql = <<<SQL
CREATE TABLE `pros`.`question`
( `id`          INT UNSIGNED NOT NULL ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `text`        TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;

$result = $db->query($sql);

/*---------------------------------------------------------------------*\
|   create `survey` table                                               |
\*---------------------------------------------------------------------*/

$sql = <<<SQL
CREATE TABLE `pros`.`survey`
( `id`          INT UNSIGNED NOT NULL ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `title`       TEXT NOT NULL ,
  `items`       TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;

// items is a CSV (ordered) list of list of survey_item(id)s

$result = $db->query($sql);

/*---------------------------------------------------------------------*\
|   create `survey_item` table                                          |
\*---------------------------------------------------------------------*/

$sql = <<<SQL
CREATE TABLE `pros`.`survey_item`
( `id`          INT UNSIGNED NOT NULL ,
  `question`    INT UNSIGNED NOT NULL , # foreign key question(id)
  `choices`     TEXT NOT NULL ,
  `explanation` BOOLEAN NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;

$result = $db->query($sql);

/*---------------------------------------------------------------------*\
|   create `process` table                                              |
\*---------------------------------------------------------------------*/

$sql = <<<SQL
CREATE TABLE `pros`.`process`
( `id`          INT UNSIGNED NOT NULL ,
  `survey`      INT UNSIGNED NOT NULL , # foreign key process(id)
  `begin`       TIMESTAMP NOT NULL ,
  `end`         TIMESTAMP NOT NULL ,
  `invitation`  TEXT NOT NULL ,
  `status`      TEXT NOT NULL ,
# status = "proposed", "cancelled", "running", "completed", "draft"
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;

$result = $db->query($sql);

/*---------------------------------------------------------------------*\
|   create `process_user` table                                         |
\*---------------------------------------------------------------------*/

$sql = <<<SQL
CREATE TABLE `pros`.`process_user`
( `process`     INT UNSIGNED NOT NULL , # foreign key process(id)
  `user`        INT UNSIGNED NOT NULL , # foreign key user(id)
  `accepted`    BOOLEAN NOT NULL DEFAULT FALSE ,
  `overseer`    BOOLEAN NOT NULL DEFAULT FALSE ,
  `peer`        BOOLEAN NOT NULL DEFAULT FALSE
) ENGINE = InnoDB;
SQL;

$result = $db->query($sql);

/*---------------------------------------------------------------------*\
|   create `evaluation` table                                           |
\*---------------------------------------------------------------------*/

$sql = <<<SQL
CREATE TABLE `pros`.`evaluation`
( `id`          INT UNSIGNED NOT NULL ,
  `process`     INT UNSIGNED NOT NULL , # foreign key process(id)
  `reviewer`    INT UNSIGNED NOT NULL , # foreign key user(id)
  `reviewee`    INT UNSIGNED NOT NULL , # foreign key user(id)
  `complete`    BOOLEAN NOT NULL DEFAULT FALSE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;

$result = $db->query($sql);

/*---------------------------------------------------------------------*\
|   create `evaluation_item` table                                      |
\*---------------------------------------------------------------------*/

$sql = <<<SQL
CREATE TABLE `pros`.`evaluation_item`
( `evaluation`  INT UNSIGNED NOT NULL , # foreign key evaluation(id)
  `item`        INT UNSIGNED NOT NULL , # foreign key survey(id)
  `choice`      TEXT NOT NULL ,
  `explanation` TEXT NOT NULL
) ENGINE = InnoDB;
SQL;

$result = $db->query($sql);

$db->close();

/*---------------------------------------------------------------------*\
|   sample query code                                                   |
\*---------------------------------------------------------------------*/

//         $result = $db->query($sql);
//         if (!$result) {
//             throw new Exception("improper query result");
//         }
//         if ($db->affected_rows > 1) {
//             // echo $db->affected_rows;
//             throw new Exception("improper number of affected_rows");
//         }
