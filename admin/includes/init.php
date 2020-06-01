<?php

defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR); // the path

defined("SITE_ROOT") ? null : define("SITE_ROOT", DS. "Web" . DS . "xamp" . DS . "htdocs" . DS . "phpoop" . DS . "gallery"); // the path
defined("INCLUDES_PATH") ? null : define("INCLUDES_PATH", DS. "Web" . DS . "xamp" . DS . "htdocs" . DS . "phpoop" . DS . "gallery" . DS . "admin" . DS . "includes"); // the path


require_once("session.php");
require_once("functions.php");
require_once("new_config.php");
require_once("database.php");
require_once("db_object.php");
require_once("user.php");
require_once("photo.php");
require_once("comment.php");
require_once("paginate.php");



