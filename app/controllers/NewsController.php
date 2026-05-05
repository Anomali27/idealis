<?php
/**
 * News Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\News;

class NewsController extends Controller
{
    private News $newsModel;

    public function __construct()
    {
        parent::__construct();
        $this->newsModel = new News();
    }

    /**
     * Show news detail page - /news/{id}
     */
    public function show(int $id): void
    {
        $newsItem = $this->newsModel->getById($id);

        if (!$newsItem) {
            $this->error404('News article not found');
            return;
        }

        $this->data['title'] = $newsItem['title'] . ' - PIC Social Activity';
        $this->data['news'] = $newsItem;

        $this->render('news/show');
    }
}
