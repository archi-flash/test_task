<?php
function errorHandler($level, $message, $file, $line, $context) {

    if(MODE=="production"){
       return true;
    }

    switch ($level) {
        case E_WARNING:
            $type = 'Warning';
            break;
        case E_NOTICE:
            $type = 'Notice';
            break;
        default;
            $type = 'Error';
            break;
            
    }
    echo "<h2>$type: $message</h2>";
    echo "<p><strong>File</strong>: $file:$line</p>";
    echo "<p><strong>Context</strong>: $". join(', $', array_keys($context))."</p>";
    return true;
}
?>