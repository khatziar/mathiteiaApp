<?php
echo "<h2>PHP Timezone Information</h2>";

echo "<h3>Current Settings:</h3>";
echo "Default Timezone: " . date_default_timezone_get() . "<br>";
echo "Current Time (server): " . date('Y-m-d H:i:s') . "<br>";

echo "<h3>Different Timezones:</h3>";

// Set to different timezones and show time
$timezones = [
    'UTC' => 'UTC',
    'Europe/Athens' => 'Athens/Greece',
    'Europe/London' => 'London',
    'America/New_York' => 'New York',
    'Europe/Berlin' => 'Berlin'
];

foreach ($timezones as $tz => $name) {
    date_default_timezone_set($tz);
    echo "$name: " . date('Y-m-d H:i:s') . "<br>";
}

// Reset to original
date_default_timezone_set(date_default_timezone_get());

echo "<h3>PHP Configuration:</h3>";
echo "php.ini timezone setting: " . ini_get('date.timezone') . "<br>";
echo "Server timezone: " . date('T') . "<br>";
?>
