<?php
namespace App\Controllers;

class StudentController
{
    public function index()
    {
        echo "<h1>Student Dashboard</h1>";
        echo "<p>StudentController berhasil dipanggil.</p>";
    }

    public function show($id)
    {
        echo "<h1>Detail Student</h1>";
        echo "<p>ID: " . htmlspecialchars($id) . "</p>";
    }
}