<?php

require_once "./Database.php";
require_once "../config.php";

$USERS = [
    "name" => "user_app",
    "rows" => [
        "id VARCHAR(13) PRIMARY KEY,",
        "username VARCHAR(30) NOT NULL UNIQUE,",
        "psw VARCHAR(512) NOT NULL,",
        "created_datetime BIGINT(10) NOT NULL,",
        "updated_datetime BIGINT(10) NOT NULL,",
        "first_name VARCHAR(200) NULL,",
        "last_name VARCHAR(200) NULL,",
        "email VARCHAR(200) NOT NULL UNIQUE,",
        "avatar VARCHAR(300) NULL,",
        "validated TINYINT(1) DEFAULT 0",
    ],
    "fks" => [],
    "characterSet" => "utf8"
];

$WEBCARDS = [
    "name" => "webcard",
    "rows" => [
        "id VARCHAR(13) PRIMARY KEY,",
        "created_datetime BIGINT(10) NOT NULL,",
        "updated_datetime BIGINT(10) NOT NULL,",
        "is_active TINYINT(1) DEFAULT 1,",
        "theme VARCHAR(10),",
        "show_share TINYINT(1) DEFAULT 1,",
        "auto_play TINYINT(1) DEFAULT 1,",
        "opens_new_tab TINYINT(1) DEFAULT 1,",
        "public TINYINT(1) DEFAULT 1,",
        "owner_id VARCHAR(13) NOT NULL,",
        "title VARCHAR(300) NOT NULL,",
        "subtitle VARCHAR(300) NOT NULL,",
        "preview VARCHAR(300) NOT NULL,",
        "preview_on_platform TINYINT(1) DEFAULT 1,",
    ],
    "fks" => [
        "fk_owner_webcard" => [
            "field" => "owner_id",
            "reference" => "user_app(id)",
            "onDelete" => "CASCADE",
            "onUpdate" => "CASCADE"
        ]
    ],
    "characterSet" => "utf8"
];

$LINKS = [
    "name" => "links",
    "rows" => [
        "id VARCHAR(13) PRIMARY KEY,",
        "created_datetime BIGINT(10) NOT NULL,",
        "updated_datetime BIGINT(10) NOT NULL,",
        "webcard_id VARCHAR(13) NOT NULL,",
        "link_type VARCHAR(3) NOT NULL DEFAULT 'red',",
        "title VARCHAR(30) NULL,",
        "button VARCHAR(30) NOT NULL DEFAULT 'View',",
        "active TINYINT DEFAULT 1,",
    ],
    "fks" => [
        "fk_link_webcard" => [
            "field" => "webcard_id",
            "reference" => "webcard(id)",
            "onDelete" => "CASCADE",
            "onUpdate" => "CASCADE"
        ]
    ],
    "characterSet" => "utf8"
];

$TABLES = [
    $USERS,
    $WEBCARDS,
    $LINKS
];

$database = new Database();

$database->connect(
    $ENV["connString"],
    $ENV["dbUser"],
    $ENV["dbPassword"]
);

foreach ($TABLES as $table) {

    $command = "
    CREATE OR REPLACE TABLE {$table['name']} ( \n
    ";

    foreach ($table['rows'] as $row) {
        $command = "{$command} {$row} \n";
    }

    foreach ($table["fks"] as $fkName => $detail) {
        $command = "{$command} CONSTRAINT `{$fkName}`
            FOREIGN KEY ({$detail['field']}) REFERENCES {$detail['reference']}
            ON DELETE {$detail['onDelete']}
            ON UPDATE {$detail['onUpdate']}, \n";
    }

    $command = rtrim($command, ", \n");
    $command = "{$command} ) ENGINE=InnoDB DEFAULT CHARSET={$table['characterSet']};";

    echo "*******\n";
    echo "Executing...\n";
    echo "{$command}\n";
    echo "*******\n";

    $database->query($command)->execute();
}

$database->close();

?>
