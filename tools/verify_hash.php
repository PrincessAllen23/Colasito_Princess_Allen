<?php
$hash = '$2y$10$LWN0iUMrYic.xRnKzOru.eHJ2Xcen8KyxUkySCS2ZrDyDxFxEPZlS';
$pw = 'c03232005';
if (password_verify($pw, $hash)) {
    echo "match\n";
} else {
    echo "no match\n";
}

