<?php
/**
 * Event Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\AuthMiddleware;
use App\Models\Event;
use App\Models\News;

class EventController extends Controller
{
    private Event $eventModel;

    public function __construct()
    {
        parent::__construct();
        $this->eventModel = new Event();
    }

    /**
     * Events listing page (2x5 grid + Latest News)
     */
    public function index(): void
    {
        $events = $this->eventModel->getAll(10);

        // Get top donor for each event that has donations
        foreach ($events as &$event) {
            $topDonors = $this->eventModel->getTopDonors($event['id'], 1);
            $event['top_donor'] = $topDonors[0] ?? null;
        }
        unset($event);

        $this->data['title'] = 'Events - PIC Social Activity';
        $this->data['events'] = $events;
        $this->data['isAdmin'] = Session::isLoggedIn() && Session::getUserRole() === 'admin';

        $this->render('events/index');
    }

    /**
     * Event detail page - /events/{id}
     */
    public function show(int $id): void
    {
        $event = $this->eventModel->getById($id);

        if (!$event) {
            $this->error404('Event not found');
            return;
        }

        $topDonors = $this->eventModel->getTopDonors($id, 5);
        $participants = $this->eventModel->getParticipants($id);

        $isParticipant = false;
        if (Session::isLoggedIn()) {
            $isParticipant = $this->eventModel->isParticipant($id, Session::getUserId());
        }

        $this->data['title'] = $event['name'] . ' - PIC Social Activity';
        $this->data['event'] = $event;
        $this->data['topDonors'] = $topDonors;
        $this->data['participants'] = $participants;
        $this->data['isLoggedIn'] = Session::isLoggedIn();
        $this->data['isParticipant'] = $isParticipant;
        $this->data['isAdmin'] = Session::isLoggedIn() && Session::getUserRole() === 'admin';

        $this->render('events/show');
    }

    /**
     * Join event - POST /events/{id}/join
     */
    public function join(int $id): void
    {
        AuthMiddleware::handle();

        $event = $this->eventModel->getById($id);

        if (!$event) {
            $this->error404('Event not found');
            return;
        }

        $userId = Session::getUserId();

        if ($this->eventModel->isParticipant($id, $userId)) {
            Session::setFlash('error', 'You are already participating in this event.');
        } else {
            if ($this->eventModel->addParticipant($id, $userId)) {
                Session::setFlash('success', 'You have successfully joined the event!');
            } else {
                Session::setFlash('error', 'Failed to join the event. Please try again.');
            }
        }

        $this->redirectTo('/events/' . $id);
    }

    /**
     * Donate to event - POST /events/{id}/donate
     */
    public function donate(int $id): void
    {
        AuthMiddleware::handle();

        $event = $this->eventModel->getById($id);

        if (!$event) {
            $this->error404('Event not found');
            return;
        }

        if (empty($event['target_donation'])) {
            Session::setFlash('error', 'This event does not accept donations.');
            $this->redirectTo('/events/' . $id);
            return;
        }

        $amount = (float) ($_POST['amount'] ?? 0);
        $message = trim($_POST['message'] ?? '');

        if ($amount < 1000) {
            Session::setFlash('error', 'Minimum donation amount is Rp 1.000.');
            $this->redirectTo('/events/' . $id);
            return;
        }

        $user = AuthMiddleware::getUser();

        $data = [
            'event_id' => $id,
            'user_id' => $user['id'],
            'donor_name' => $user['name'],
            'donor_class' => $user['class'] ?? ($user['role'] === 'teacher' ? 'Teacher' : 'Alumni/Other'),
            'amount' => $amount,
            'message' => $message
        ];

        try {
            $donationId = $this->eventModel->addDonation($data);
            if ($donationId > 0) {
                $formattedAmount = number_format($amount, 0, ',', '.');
                Session::setFlash('success', "Thank you! You have donated Rp {$formattedAmount} to this event.");
            } else {
                Session::setFlash('error', 'Failed to process donation. Please try again.');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error processing donation: ' . $e->getMessage());
        }

        $this->redirectTo('/events/' . $id);
    }

    /**
     * Event edit form - /events/{id}/edit
     */
    public function edit(int $id): void
    {
        AuthMiddleware::handleAnyRole(['admin']);

        $event = $this->eventModel->getById($id);

        if (!$event) {
            $this->error404('Event not found');
            return;
        }

        $topDonors = $this->eventModel->getTopDonors($id, 10);

        $this->data['title'] = 'Edit Event - PIC Social Activity';
        $this->data['event'] = $event;
        $this->data['topDonors'] = $topDonors;

        $this->render('events/edit');
    }

    /**
     * Update event - POST /events/{id}/update
     */
    public function update(int $id): void
    {
        AuthMiddleware::handleAnyRole(['admin']);

        $event = $this->eventModel->getById($id);

        if (!$event) {
            $this->error404('Event not found');
            return;
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'date' => $_POST['date'] ?? '',
            'description' => trim($_POST['description'] ?? ''),
            'target_donation' => !empty($_POST['target_donation']) ? (float)$_POST['target_donation'] : null,
        ];

        // Handle image upload
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = dirname(dirname(__DIR__)) . '/public/assets/images/event/';
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = 'event-' . $id . '-' . time() . '.' . $ext;
            $uploadPath = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $data['image_url'] = '/assets/images/event/' . $filename;
            }
        }

        $errors = [];
        if (empty($data['name'])) $errors[] = 'Event name is required.';
        if (empty($data['date'])) $errors[] = 'Date is required.';

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/events/' . $id . '/edit');
            return;
        }

        try {
            $success = $this->eventModel->update($id, $data);
            if ($success) {
                Session::setFlash('success', 'Event updated successfully!');
                $this->redirectTo('/events/' . $id);
            } else {
                Session::setFlash('error', 'Failed to update event.');
                $this->redirectTo('/events/' . $id . '/edit');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
            $this->redirectTo('/events/' . $id . '/edit');
        }
    }

    /**
     * API: Get recommended events for the suggestion panel
     */
    public function apiRecommended(): void
    {
        header('Content-Type: application/json');
        try {
            // Get 3 upcoming or latest events
            $events = $this->eventModel->getAll(3);
            
            // Format data
            $formattedEvents = array_map(function($event) {
                return [
                    'id' => $event['id'],
                    'name' => htmlspecialchars($event['name']),
                    'date' => date('d M Y', strtotime($event['date'])),
                    'description' => htmlspecialchars(mb_substr(strip_tags($event['description'] ?? ''), 0, 100)) . '...',
                    'image_url' => htmlspecialchars($event['image_url'] ?? '/assets/images/placeholder.jpg'),
                ];
            }, $events);

            echo json_encode(['status' => 'success', 'data' => $formattedEvents]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }
}
