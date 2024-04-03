<?php

namespace App\Interfaces;

interface PhoneBookInterface
{
    public function index();
    public function getById(int $id);
    public function store(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
}
