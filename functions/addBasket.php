<?php
session_start();

if (!$_SESSION["user_id"]) {
    if (!isset($_SESSION["basket"])) {
        $_SESSION["basket"] = [];
    }
}
