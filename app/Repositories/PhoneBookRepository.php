<?php

namespace App\Repositories;
use App\Models\PhoneBook;
use App\Interfaces\PhoneBookInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PhoneBookRepository implements PhoneBookInterface
{
    public function index(): Collection
    {
        return PhoneBook::all();
    }

    public function getPaginated($page = 10)
    {
        return PhoneBook::paginate($page);
    }

    public function getById($id)
    {
        return PhoneBook::findOrFail($id);
    }

    public function store(array $data)
    {
        return PhoneBook::create($data);
    }

    public function update(array $data, $id)
    {
        return PhoneBook::whereId($id)->update($data);
    }

    public function delete($id)
    {
        PhoneBook::destroy($id);
    }
}
