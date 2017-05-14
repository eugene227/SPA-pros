<?php

define("PROS_PASSWORD", "team3password"); // FIXME

class PROS
{
    public function ping($msg = "")
    {$this->out("ping $msg");}

    public $server   = null; // mysqli connection
    public $database = "pros";

/*---------------------------------------------------------------------*\
|   define schema                                                       |
\*---------------------------------------------------------------------*/

    public $schema = [

        "user"            => "
CREATE TABLE `user`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `email`       TEXT NOT NULL ,
  `first_name`  TEXT NOT NULL ,
  `last_name`   TEXT NOT NULL ,
  `password`    TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;",

        "asset"           => "
CREATE TABLE `asset`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;",

        "version"         => "
CREATE TABLE `version`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `asset`       INT UNSIGNED NOT NULL , # foreign key asset(id)
  `owner`       INT UNSIGNED NOT NULL , # foreign key user(id)
  `timestamp`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `private`     BOOLEAN NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;",

        "choice_list"     => "
CREATE TABLE `choice_list`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `list`        TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;",

        "question"        => "
CREATE TABLE `question`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `text`        TEXT NOT NULL ,
  `analysis`    TEXT,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;",

        "survey"          => "
CREATE TABLE `survey`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `title`       TEXT NOT NULL ,
  `items`       TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;",

        "survey_item"     => "
CREATE TABLE `survey_item`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `question`    INT UNSIGNED NOT NULL , # foreign key question(id)
  `choices`     TEXT NOT NULL ,
  `explanation` BOOLEAN NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;",

        "process"         => "
CREATE TABLE `process`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `survey`      INT UNSIGNED NOT NULL , # foreign key process(id)
  `begin`       DATETIME ,
  `end`         DATETIME ,
  `invitation`  TEXT ,
  `status`      TEXT NOT NULL ,
# status = (string) proposed, cancelled, running, completed, draft
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;",

        "process_user"    => "
CREATE TABLE `process_user`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `process`     INT UNSIGNED NOT NULL , # foreign key process(id)
  `user`        INT UNSIGNED NOT NULL , # foreign key user(id)
  `accepted`    BOOLEAN NOT NULL DEFAULT FALSE ,
  `overseer`    BOOLEAN NOT NULL DEFAULT FALSE ,
  `peer`        BOOLEAN NOT NULL DEFAULT FALSE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;",

        "evaluation"      => "
CREATE TABLE `evaluation`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `process`     INT UNSIGNED NOT NULL , # foreign key process(id)
  `reviewer`    INT UNSIGNED NOT NULL , # foreign key user(id)
  `reviewee`    INT UNSIGNED NOT NULL , # foreign key user(id)
  `complete`    BOOLEAN NOT NULL DEFAULT FALSE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;",

        "evaluation_item" => "
CREATE TABLE `evaluation_item`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `evaluation`  INT UNSIGNED NOT NULL , # foreign key evaluation(id)
  `item`        INT UNSIGNED NOT NULL , # foreign key survey(id)
  `choice`      TEXT ,
  `explanation` TEXT ,
  `analysis`    TEXT ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;",
    ];

/*---------------------------------------------------------------------*\
|   connect to server on construct                                      |
\*---------------------------------------------------------------------*/

    public function __construct($password)
    {
        $this->server = new mysqli("localhost", "root", $password);
        if ($this->server->connect_error) {
            $this->log("Connect Failed: {$server->connect_error}");
            return $this;
        }
        $this->server->set_charset('utf8');
        return $this;
    }

/*---------------------------------------------------------------------*\
|   close server connection on destruct                                 |
\*---------------------------------------------------------------------*/

    public function __destruct()
    {
        $this->server->close();
    }

/*---------------------------------------------------------------------*\
|   execute query and log errors                                        |
\*---------------------------------------------------------------------*/

    public function query($sql)
    {
        $result = $this->server->query($sql);
        if ($result) {return $result;}
        $this->log("Query Error: {$this->server->error}");
        return false;
    }

/*---------------------------------------------------------------------*\
|   set the name of the active PROS database                            |
\*---------------------------------------------------------------------*/

    public function set_database($database)
    {
        $this->database = $database;
        return $this;
    }

/*---------------------------------------------------------------------*\
|   drop or create active database                                      |
\*---------------------------------------------------------------------*/

    public function drop_database($name)
    {
        $name = $name ?: $this->database;
        // $this->query("SET foreign_key_checks = 0");
        $this->query("DROP DATABASE IF EXISTS {$name};");
        // $this->query("SET foreign_key_checks = 1");
        return $this;
    }

    public function create_database($name)
    {
        $name = $name ?: $this->database;
        $this->query("CREATE DATABASE IF NOT EXISTS {$name};");
        return $this;
    }

    public function use_database($name)
    {
        $name = $name ?: $this->database;
        $this->query("USE {$name};");
        return $this;
    }

/*---------------------------------------------------------------------*\
|   drop all existing tables in current database                        |
\*---------------------------------------------------------------------*/

    public function drop_all_tables()
    {
        $this->query("SET foreign_key_checks = 0");

        if ($result = $this->query("SHOW TABLES")) {
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $this->query("DROP TABLE IF EXISTS " . $row[0]);
            }
        }

        $this->query("SET foreign_key_checks = 1");
    }

/*---------------------------------------------------------------------*\
|   create_table(table) --> (error_code)                                |
\*---------------------------------------------------------------------*/

    public function create_table($table)
    {
        $result = $this->query($this->schema[$table]);
        return $this;
    }

/*---------------------------------------------------------------------*\
|   init_database()                                                     |
|   WARNING!!!                                                          |
|   THIS METHOD WILL **NUKE** THE ACTIVE PROS DATABASE                  |
\*---------------------------------------------------------------------*/

    public function init_database($name)
    {
        $this
            ->drop_database($name)
            ->create_database($name)
            ->use_database($name);
        foreach ($this->schema as $table => $_) {
            $this->create_table($table);
        }
        return $this;
    }

    public function lexify($value)
    {
        $quote = substr($value, 0, 1);
        $value = substr($value, 1);
        $value = $this->server->real_escape_string($value);
        $value = $quote . $value . $quote;
        $value = trim($value);
        return $value;
    }

    public function sql_keys($array)
    {
        return implode(", ", array_keys($array));
    }

    public function sql_values($array)
    {
        $callback = array("PROS", "lexify");
        return implode(", ", array_map($callback, array_values($array)));
    }

    public function sql_updates($array)
    {
        foreach ($array as $key => $value) {
            $array[$key] = "{$key} = " . $this->lexify($value);
        }
        return implode(", ", $array);
    }

/*---------------------------------------------------------------------*\
|   fetch_all($result) --> rows                                         |
\*---------------------------------------------------------------------*/

    public function fetch_all($result)
    {
        $rows = [];
        while ($row = $result->fetch_assoc()) {$rows[] = $row;}
        return $rows;
    }

/*---------------------------------------------------------------------*\
|   table_count(table) --> (integer)                                    |
|   return the number of rows in a table                                |
\*---------------------------------------------------------------------*/

    public function table_count($table)
    {
        $sql = "SELECT COUNT(*) FROM {$table};";
        return intval($this->query($sql)["COUNT(*)"]);
    }

/*---------------------------------------------------------------------*\
|   table_insert(table, data) --> id                                    |
|   returns id of the inserted row                                      |
\*---------------------------------------------------------------------*/

    public function table_insert($table, $data)
    {
        $names  = $this->sql_keys($data);
        $values = $this->sql_values($data);
        $sql    = "INSERT INTO {$table} ({$names}) VALUES ({$values});";
        $result = $this->query($sql);
        return $this->server->insert_id;
    }

/*---------------------------------------------------------------------*\
|   table_update(table, data, where) --> id                             |
|   returns id of the updated row                                       |
\*---------------------------------------------------------------------*/

    public function table_update($table, $data, $where)
    {
        $updates = $this->sql_updates($data);
        $sql     = "UPDATE {$table} SET {$updates} WHERE {$where};";
        $result  = $this->query($sql);
        return $this->server->insert_id;
    }

/*---------------------------------------------------------------------*\
|   table_select(table, columns [, where]) --> rows                     |
\*---------------------------------------------------------------------*/

    public function table_select($table, $columns, $where = null)
    {
        $where  = ($where) ? "WHERE {$where}" : "";
        $sql    = "SELECT {$columns} FROM {$table} {$where} ;";
        $result = $this->query($sql);
        return $this->fetch_all($result);
    }

/*---------------------------------------------------------------------*\
|   get_question_versions($id)                                          |
\*---------------------------------------------------------------------*/

    // public function get_question_versions($id)
    // {
    //     $result = $this->table_select("question", "version", "id = $id");
    //     $id     = $result["version"];
    //     $result = $this->table_select("version", "asset", "id = $id");
    //     $asset  = $result["asset"];
    //     $result = $this->table_select("version", "*", "asset = $asset");
    // }

/*---------------------------------------------------------------------*\
|   error logging                                                       |
\*---------------------------------------------------------------------*/

    public $error_log = [];

    public function log($error_message)
    {
        $this->error_log[] = $error_message;
        return $this;
    }

    public function print_log()
    {
        foreach ($this->error_log as $_ => $error_message) {
            echo "<p>{$error_message}</p>";
        }
        return $this;
    }

/*---------------------------------------------------------------------*\
|   miscellaneous methods                                               |
\*---------------------------------------------------------------------*/

    public function out($value)
    {
        print "<pre>";
        print_r($value);
        print "</pre>";
    }

}

/*---------------------------------------------------------------------*\
|   class PROS finis                                                    |
\*---------------------------------------------------------------------*/
