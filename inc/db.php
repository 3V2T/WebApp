<?php
$db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
try {
    $db->getConn();
    return $db->getConn();
} catch (Exception $e) {
    echo $e->getMessage();
}
