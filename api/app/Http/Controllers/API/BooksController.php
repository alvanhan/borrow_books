<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Books;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;


class BooksController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        $books = Books::all();

        return $this->sendResponse($books->toArray(), 'Books retrieved successfully.');
    }

}
