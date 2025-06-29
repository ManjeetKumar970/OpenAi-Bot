<?php

class ErrorLog {
    private $errorLogs;

    public function __construct() {
        $this->errorLogs = __DIR__ . '/errorLogs';
    }

    public function createErrorLog($data) {
        if (!is_dir($this->errorLogs)) {
            mkdir($this->errorLogs, 0777, true);
        }

        $logFile = $this->errorLogs . '/error_log_' . date('Y-m-d') . '.log';

        if (is_array($data)) {
            $message = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        } else {
            $message = $data;
        }

        $logEntry = sprintf(
            "[%s] %s\n\n",
            date('Y-m-d H:i:s'),
            $message
        );

        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
