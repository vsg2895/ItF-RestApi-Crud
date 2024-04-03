<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneBook\StorePhoneBookRequest;
use App\Http\Requests\PhoneBook\UpdatePhoneBookRequest;
use App\Http\Resources\PhoneBookCollection;
use App\Http\Resources\PhoneBookResource;
use App\Interfaces\PhoneBookInterface;
use Facades\App\Services\ExternalApiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class PhoneBookController extends Controller
{

    public function __construct(private readonly PhoneBookInterface $phoneBookRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->phoneBookRepository->getPaginated();

        return Response::success(new PhoneBookCollection($data), 'PhoneBook List');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhoneBookRequest $request)
    {
        $phoneBook = $this->phoneBookRepository->store($request->validated());

        return Response::success(new PhoneBookResource($phoneBook), 'PhoneBook created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $phoneBook = $this->phoneBookRepository->getById($id);

        return Response::success(new PhoneBookResource($phoneBook));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhoneBookRequest $request, $id)
    {
        $this->phoneBookRepository->update($request->validated(), $id);

        return Response::success([], 'PhoneBook updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->phoneBookRepository->delete($id);

        return Response::success([], 'PhoneBook deleted successfully');
    }
}
