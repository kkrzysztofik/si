<?php

function sanitize_string($string) {
    if(empty($string)) {
        return "";
    }
    return mysql_real_escape_string(strip_tags(htmlspecialchars($string)));
}

function mysql_sanitize_string($string) {
    return mysql_real_escape_string(sanitize_string($string));
}

function check_permission($level) {
    return $_SESSION['permission'] >= $level;
}