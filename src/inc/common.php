<?php

function sanitize_string($string) {
    return strip_tags(htmlspecialchars($string));
}

function mysql_sanitize_string($string) {
    return mysql_real_escape_string(sanitize_string($string));
}