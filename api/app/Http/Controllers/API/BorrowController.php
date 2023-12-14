<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Books;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class BorrowController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        $borrow = Borrow::with('books')
        ->where('user_id', Auth::guard('api')->user()->id)
        ->get();

        return $this->sendResponse($borrow->toArray(), 'Borrow retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 500);
        }

        $book = Books::find($request->book_id);

        if (!$book || $book->stock <= 0) {
            return $this->sendError('Book Not Available', 'The book is currently out of stock.', 500);
        }

        $user = Auth::guard('api')->user();
        $borrowedCount = Borrow::where('user_id', $user->id)
            ->where('book_id', $request->book_id)
            ->where('return_date', null)
            ->count();

        if ($borrowedCount >= 1) {
            return $this->sendError('Book Limit Exceeded', 'You have borrowed more than 2 copies of the same book. delist or return the book first! ', 500);
        }

        if ($book->stock <= 0) {
            return $this->sendError('Book Not Available', 'The book is currently out of stock.', 500);
        }

        $book->stock = $book->stock - 1;
        $book->save();

        $borrow = new Borrow();
        $borrow->user_id = $user->id;
        $borrow->book_id = $request->book_id;
        $borrow->borrows_date = now();
        $borrow->return_date = null;
        $borrow->save();

        $success = 'You have successfully borrowed a book, dont forget to return it';

        return $this->sendResponse($success, 'Borrow created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $borrow = Borrow::find($id);

        if ($borrow->return_date) {
            return $this->sendError('Book Already Returned', 'The book has already been returned.', 200);
        }

        $borrow->return_date = now();
        $borrow->save();

        $book = Books::find($borrow->book_id);
        $book->stock = $book->stock + 1;
        $book->save();

        $success = 'You have successfully returned the book.';
        return $this->sendResponse($success, 'Update successfully, you have returned the book.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $borrow = Borrow::find($id);
        $borrow->delete();
        $success = 'You have successfully deleted the book borrowing list.';
        return $this->sendResponse($success, 'Delete successfully, You have successfully deleted the book borrowing list.');
    }
}
