<?php

require_once 'prelude.php';

reroute_guests(__FILE__);
reroute_users(__FILE__);

class DB extends SQLite3
{
    public function __construct($name)
    {
        $this->open($name);
    }

    public function tables()
    {
        $query  = $this->query("SELECT name FROM sqlite_master WHERE type='table';");
        $return = [];
        while ($table = $query->fetchArray(SQLITE3_ASSOC)) {
            $return[] = $table['name'];
        }
        return $return;
    }

    public function all($table)
    {
        $sql = "SELECT * FROM $table;";
        // echo $sql;
        $query  = $this->query($sql);
        $return = [];
        while ($row = $query->fetchArray()) {
            $return[] = $row;
        }
        return $return;
    }
}

$db_name = 'prs_dev_1_0.db';
if (file_exists($db_name)) {unlink($db_name);}
$db = new DB($db_name);

// USER

$sql = <<<SQL
create table user(
id         INTEGER PRIMARY KEY,
email      TEXT,
first_name TEXT,
last_name  TEXT,
password   TEXT);
SQL;
$db->exec($sql);

$sql = <<<SQL
INSERT INTO user (email, first_name, last_name, password)
VALUES ("david.i.richards.iii@gmail.com", "David", "Richards", "secret");
SQL;
$db->exec($sql);

function dummyUser($db)
{
    $email      = '';
    $first_name = '';
    $last_name  = '';
    $password   = 'secret';

    $json = file_get_contents('https://randomuser.me/api/');
    $data = json_decode($json, true)['results'][0];

    $email      = $data['email'];
    $first_name = ucfirst($data['name']['first']);
    $last_name  = ucfirst($data['name']['last']);
    $password   = $data['login']['password'];

    $sql = <<<SQL
INSERT INTO user (email, first_name, last_name, password)
VALUES ("{$email}", "{$first_name}", "{$last_name}", "{$password}");
SQL;
    $db->exec($sql);
}

dummyUser($db);
echo dump($db->all('user'));
echo dump($db->lastInsertRowID());

// ASSET

$sql = <<<SQL
create table asset(
id         INTEGER PRIMARY KEY);
SQL;
$db->exec($sql);

echo dump($db->tables());

$sql = <<<SQL
INSERT INTO asset (id)
VALUES (NULL);
INSERT INTO asset (id)
VALUES (NULL);
INSERT INTO asset (id)
VALUES (NULL);
SQL;
$db->exec($sql);

echo dump($db->all('asset'));

$sql = <<<SQL
create table version(
id         INTEGER PRIMARY KEY,
asset      INTEGER,
user       INTEGER,
updated    TEXT,
latest     BOOLEAN,
private    BOOLEAN,
FOREIGN KEY(asset) REFERENCES asset(id),
FOREIGN KEY(user)  REFERENCES user(id) );
SQL;
$db->exec($sql);

$sql = <<<SQL
INSERT INTO version (asset, user, updated, latest, private)
VALUES (1, 1, "2017-04-23 01:13:00.000", 0, 0);
INSERT INTO version (asset, user, updated, latest, private)
VALUES (1, 1, "2017-04-23 01:13:01.000", 1, 0);
SQL;
$db->exec($sql);

echo dump($db->all('version'));

// QUESTION

$sql = <<<SQL
create table question (
id         INTEGER PRIMARY KEY,
text       TEXT,
version    TEXT,
FOREIGN KEY(version) REFERENCES version(id) );
SQL;
$db->exec($sql);

$sql = <<<SQL
INSERT INTO question (version, text)
VALUES (1, "42?");
INSERT INTO question (version, text)
VALUES (2, "What is hip?");
SQL;
$db->exec($sql);

// TESTS

echo dump($db->tables());

echo dump($db->all('question'));

// A ChoiceList contains an encoded list of grades or other discrete values for each question.

// ChoiceList
//     ID  TEXT PRIMARY KEY
//     version Version:ID
//     list    TEXT (encoding of ordered list of strings)

// A User may create Surveys which will be presented to peer Users in a peer review Process.

// Survey
//     ID  TEXT PRIMARY KEY
//     version Version:ID
//     title   TEXT
//     items   TEXT (encoding of ordered list of SurveyItem:IDs)

// A Survey will contain one or more SurveyItems. Each SurveyItem comprises a Question, a ChoiceList and one or more optional evaluation types.

// SurveyItem
//     ID  INTEGER PRIMARY KEY
//     question    Question:ID
//     choices ChoiceList:ID
//     [explanation    BOOLEAN (default = TRUE)]

// An Version record is created each time an existing Question, ChoiceList, or Survey is edited, including an initial Version record when the first edition is created. All Versions of the same Question, ChoiceList, or Survey will point to an Asset:ID, identifying them as versions of the same Asset.

// An Asset record is created for every new Question, new ChoiceList, and new Survey. All Versions of this Question, ChoiceList, or Survey will point to this Asset:ID, identifying them as Versions of the same Asset.

// Asset
//     ID  INTEGER PRIMARY KEY

// A Process record contains all information needed by the system to administer/manage a peer review process.

// Process
//     ID  TEXT PRIMARY KEY
//     survey  Survey:ID
//     begin   TIMESTAMP
//     end TIMESTAMP
//     status  'proposed', 'cancelled', 'running', 'completed'

// A Process record links a User to a Process, and identifies the role(s) of that user in the Process. When a Process is proposed, a Process_User record is created for every User involved in that Process, specifying their role and permissions.

// Process_User
//     process Process:ID
//     user    User:ID
//     accepted    BOOLEAN
//     overseer    BOOLEAN
//     peer    BOOLEAN

// When a Process is accepted, an Evaluation record is created for the Cartesian product of peers (each reviewer-reviewee pair), and for each of these pairs an EvaluationItem record is created for every SurveyItem of the Survey associated with the Process.

// Evaluation
//     ID  INTEGER PRIMARY KEY
//     process Process:ID
//     reviewer    User:ID
//     reviewee    User:ID
//     complete    BOOLEAN (default = FALSE)

// EvaluationItem
//     evaluation  Evaluation:ID
//     item    SurveyItem:ID
//     choice  TEXT
//     explanation TEXT
