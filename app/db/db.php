<?php

error_reporting(-1); // Report all PHP errors (E_ALL)
ini_set('display_errors', true);
ini_set('log_errors', false);

function out($value)
{
    print "<pre>";
    print_r($value);
    print "</pre>";
}

$password = "team3password";

class PROS
{
    public $server   = null; // mysqli connection
    public $database = "pros";

/*---------------------------------------------------------------------*\
|   error loggin                                                        |
\*---------------------------------------------------------------------*/

    public $error_log = [];

    public function out($value)
    {
        print "<pre>";
        print_r($value);
        print "</pre>";
    }

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
|   set the name of the active PROS database                            |
\*---------------------------------------------------------------------*/

    public function set_database($database)
    {
        $this->database = $database;
        return $this;
    }

/*---------------------------------------------------------------------*\
|   execute query and log errors                                        |
\*---------------------------------------------------------------------*/

    public function query($sql)
    {
        $result = $this->server->query($sql);
        if (!$result) {
            $this->log("Query Error: {$this->server->error}");
        }
        return $result;
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
            while ($row = $result->fetch_array(server_NUM)) {
                $this->query("DROP TABLE IF EXISTS " . $row[0]);
            }
        }

        $this->query("SET foreign_key_checks = 1");
    }

/*---------------------------------------------------------------------*\
|   close server connction on destruct                                  |
\*---------------------------------------------------------------------*/

    public function __destruct()
    {
        $this->server->close();
    }

/*---------------------------------------------------------------------*\
|   define schema                                                       |
\*---------------------------------------------------------------------*/

    public $schema = [
        "user"           => <<<SQL
CREATE TABLE `user`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `email`       TEXT NOT NULL ,
  `first_name`  TEXT NOT NULL ,
  `last_name`   TEXT NOT NULL ,
  `password`    TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL
        ,
        "asset"          =><<<SQL
CREATE TABLE `asset`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL
        ,
        "version"        =><<<SQL
CREATE TABLE `version`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `asset`       INT UNSIGNED NOT NULL , # foreign key asset(id)
  `owner`       INT UNSIGNED NOT NULL , # foreign key user(id)
  `timestamp`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `private`     BOOLEAN NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL
        ,
        "choice_list"    =><<<SQL
CREATE TABLE `choice_list`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `list`        TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL
        ,
        "question"       =><<<SQL
CREATE TABLE `question`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `text`        TEXT NOT NULL ,
  `analysis`    TEXT,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL
        ,
        "survey"         =><<<SQL
CREATE TABLE `survey`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `title`       TEXT NOT NULL ,
  `items`       TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL
        ,
        "survey_item"    =><<<SQL
CREATE TABLE `survey_item`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `question`    INT UNSIGNED NOT NULL , # foreign key question(id)
  `choices`     TEXT NOT NULL ,
  `explanation` BOOLEAN NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL
        ,
        "process"        =><<<SQL
CREATE TABLE `process`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `survey`      INT UNSIGNED NOT NULL , # foreign key process(id)
  `begin`       DATETIME ,
  `end`         DATETIME ,
  `invitation`  TEXT ,
  `status`      TEXT NOT NULL ,
# status = "proposed", "cancelled", "running", "completed", "draft"
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL
        ,
        "process_user"   =><<<SQL
CREATE TABLE `process_user`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `process`     INT UNSIGNED NOT NULL , # foreign key process(id)
  `user`        INT UNSIGNED NOT NULL , # foreign key user(id)
  `accepted`    BOOLEAN NOT NULL DEFAULT FALSE ,
  `overseer`    BOOLEAN NOT NULL DEFAULT FALSE ,
  `peer`        BOOLEAN NOT NULL DEFAULT FALSE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL
        ,
        "evaluation"     =><<<SQL
CREATE TABLE `evaluation`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `process`     INT UNSIGNED NOT NULL , # foreign key process(id)
  `reviewer`    INT UNSIGNED NOT NULL , # foreign key user(id)
  `reviewee`    INT UNSIGNED NOT NULL , # foreign key user(id)
  `complete`    BOOLEAN NOT NULL DEFAULT FALSE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL
        ,
        "evaluation_item"=><<<SQL
CREATE TABLE `evaluation_item`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `evaluation`  INT UNSIGNED NOT NULL , # foreign key evaluation(id)
  `item`        INT UNSIGNED NOT NULL , # foreign key survey(id)
  `choice`      TEXT ,
  `explanation` TEXT ,
  `analysis`    TEXT ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL
    ];

/*---------------------------------------------------------------------*\
|   create `user` table                                                 |
\*---------------------------------------------------------------------*/

    public function create_table_user()
    {
        $sql = <<<SQL
CREATE TABLE `user`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `email`       TEXT NOT NULL ,
  `first_name`  TEXT NOT NULL ,
  `last_name`   TEXT NOT NULL ,
  `password`    TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;
        $this->query($sql);
        return $this;
    }

/*---------------------------------------------------------------------*\
|   create `asset` table                                                |
\*---------------------------------------------------------------------*/

    public function create_table_asset()
    {
        $sql = <<<SQL
CREATE TABLE `asset`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;
        $this->query($sql);
        return $this;
    }

/*---------------------------------------------------------------------*\
|   create `version` table                                              |
\*---------------------------------------------------------------------*/

    public function create_table_version()
    {
        $sql = <<<SQL
CREATE TABLE `version`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `asset`       INT UNSIGNED NOT NULL , # foreign key asset(id)
  `owner`       INT UNSIGNED NOT NULL , # foreign key user(id)
# `timestamp`   TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP, # MySQL 5.6.4+
  `timestamp`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
# `latest`      BOOLEAN NOT NULL DEFAULT TRUE ,
  `private`     BOOLEAN NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;
        $this->query($sql);
        return $this;
    }

// FIXME
    // $sql .= <<<SQL
    // ALTER TABLE `{$this->database}`.`version` ADD FOREIGN KEY(asset)
    // REFERENCES asset(id) ON UPDATE RESTRICT ON DELETE RESTRICT ;
    // SQL;

/*---------------------------------------------------------------------*\
|   create `choice_list` table                                          |
\*---------------------------------------------------------------------*/

    public function create_table_choice_list()
    {
        $sql = <<<SQL
CREATE TABLE `choice_list`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `list`        TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;
        $this->query($sql);
        return $this;
    }

/*---------------------------------------------------------------------*\
|   create `question` table                                             |
\*---------------------------------------------------------------------*/

    public function create_table_question()
    {
        $sql = <<<SQL
CREATE TABLE `question`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `text`        TEXT NOT NULL ,
  `analysis`    TEXT,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;
        $this->query($sql);
        return $this;
    }

/*---------------------------------------------------------------------*\
|   create `survey` table                                               |
\*---------------------------------------------------------------------*/

    public function create_table_survey()
    {
        $sql = <<<SQL
CREATE TABLE `survey`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `version`     INT UNSIGNED NOT NULL , # foreign key version(id)
  `title`       TEXT NOT NULL ,
  `items`       TEXT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;

// items is a CSV (ordered) list of list of survey_item(id)s

        $this->query($sql);
        return $this;
    }

/*---------------------------------------------------------------------*\
|   create `survey_item` table                                          |
\*---------------------------------------------------------------------*/

    public function create_table_survey_item()
    {
        $sql = <<<SQL
CREATE TABLE `survey_item`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `question`    INT UNSIGNED NOT NULL , # foreign key question(id)
  `choices`     TEXT NOT NULL ,
  `explanation` BOOLEAN NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;
        $this->query($sql);
        return $this;
    }

/*---------------------------------------------------------------------*\
|   create `process` table                                              |
\*---------------------------------------------------------------------*/

    public function create_table_process()
    {
        $sql = <<<SQL
CREATE TABLE `process`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `survey`      INT UNSIGNED NOT NULL , # foreign key process(id)
  `begin`       DATETIME ,
  `end`         DATETIME ,
  `invitation`  TEXT ,
  `status`      TEXT NOT NULL ,
# status = "proposed", "cancelled", "running", "completed", "draft"
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;
        $this->query($sql);
        return $this;
    }

/*---------------------------------------------------------------------*\
|   create `process_user` table                                         |
\*---------------------------------------------------------------------*/

    public function create_table_process_user()
    {
        $sql = <<<SQL
CREATE TABLE `process_user`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `process`     INT UNSIGNED NOT NULL , # foreign key process(id)
  `user`        INT UNSIGNED NOT NULL , # foreign key user(id)
  `accepted`    BOOLEAN NOT NULL DEFAULT FALSE ,
  `overseer`    BOOLEAN NOT NULL DEFAULT FALSE ,
  `peer`        BOOLEAN NOT NULL DEFAULT FALSE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;
        $this->query($sql);
        return $this;
    }

/*---------------------------------------------------------------------*\
|   create `evaluation` table                                           |
\*---------------------------------------------------------------------*/

    public function create_table_evaluation()
    {
        $sql = <<<SQL
CREATE TABLE `evaluation`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `process`     INT UNSIGNED NOT NULL , # foreign key process(id)
  `reviewer`    INT UNSIGNED NOT NULL , # foreign key user(id)
  `reviewee`    INT UNSIGNED NOT NULL , # foreign key user(id)
  `complete`    BOOLEAN NOT NULL DEFAULT FALSE ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;
        $this->query($sql);
        return $this;
    }

/*---------------------------------------------------------------------*\
|   create `evaluation_item` table                                      |
\*---------------------------------------------------------------------*/

    public function create_table_evaluation_item()
    {
        $sql = <<<SQL
CREATE TABLE `evaluation_item`
( `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `evaluation`  INT UNSIGNED NOT NULL , # foreign key evaluation(id)
  `item`        INT UNSIGNED NOT NULL , # foreign key survey(id)
  `choice`      TEXT ,
  `explanation` TEXT ,
  `analysis`    TEXT ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
SQL;
        $this->query($sql);
        return $this;
    }

/*---------------------------------------------------------------------*\
|   create_table(table) --> (error_code)                                |
\*---------------------------------------------------------------------*/

    public function create_table($table)
    {
        // $this->out("create_table($table)");
        $result = $this->query($this->schema[$table]);
        // $this->out("$result");
        return $this;
    }

/*---------------------------------------------------------------------*\
|   WARNING!!!                                                          |
|   init_database()                                                     |
|   THIS CODE WILL **NUKE** THE ACTIVE PROS DATABASE                    |
\*---------------------------------------------------------------------*/

    // public function init_database($name)
    // {
    //     $this
    //         ->drop_database($name)
    //         ->create_database($name)
    //         ->use_database($name)
    //         ->create_table_user()
    //         ->create_table_asset()
    //         ->create_table_version()
    //         ->create_table_choice_list()
    //         ->create_table_question()
    //         ->create_table_survey()
    //         ->create_table_survey_item()
    //         ->create_table_process()
    //         ->create_table_process_user()
    //         ->create_table_evaluation()
    //         ->create_table_evaluation_item()
    //     ;
    //     return $this;
    // }

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
        return intval($this->query($sql)->fetch_assoc()["COUNT(*)"]);
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

}

/*---------------------------------------------------------------------*\
|   class PROS finis                                                    |
\*---------------------------------------------------------------------*/
