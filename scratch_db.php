<?php
require_once __DIR__ . '/app/core/Database.php';

$db = App\Core\Database::getInstance();

$events = $db->query("DESCRIBE events");
echo "Events table:\n";
print_r($events);

$ep = $db->query("DESCRIBE event_participants");
echo "Event Participants table:\n";
print_r($ep);

$ed = $db->query("DESCRIBE event_donations");
echo "Event Donations table:\n";
print_r($ed);
