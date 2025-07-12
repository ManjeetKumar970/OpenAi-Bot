<?php
require_once ('lib/Sanitizer.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text'])) {
     $filterData= sanitizeUserInput($_POST['text']);
     header("Location: home.php?text=" . urlencode($filterData));
    exit;
}
