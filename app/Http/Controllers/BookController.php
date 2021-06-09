<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBookRequest;
use App\Http\Requests\DeleteBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Exception;
use Illuminate\Http\Request;

class BookController extends Controller
{
    const SUCCESS_CODE = 200;
    const FAIL_CODE = 400;

    const SUCCESS_MSG = 'Success';
    const FAIL_MSG = 'Something went wrong';

    /**
     * @param AddBookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function addBook(AddBookRequest $request)
    {
        $res = null;
        try {
            $book = new Book();
            $book->title = $request->title;
            $book->author = $request->author;
            $book->sales = $request->sales;
            $book->save();
            $res = response()->json([
                'code' => self::SUCCESS_CODE,
                'data' => $book,
                'message' => self::SUCCESS_MSG
            ]);
        } catch (Exception $e) {
            $res = response()->json([
                'code' => self::FAIL_CODE,
                'data' => $e->getMessage(),
                'message' => self::FAIL_MSG
            ]);
        }

        return $res;
    }

    /**
     * @param UpdateBookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function updateBook(UpdateBookRequest $request)
    {
        $res = null;
        try {
            $book = Book::find($request->id);
            $possibleParams = [
                'title',
                'author',
                'sales'
            ];

            foreach ($possibleParams as $property) {
                if (!empty($request->$property)) {
                    $book->$property = $request->$property;
                }
            }

            $book->save();
            $res = response()->json([
                'code' => self::SUCCESS_CODE,
                'data' => $book,
                'message' => self::SUCCESS_MSG
            ]);
        } catch (Exception $e) {
            $res = response()->json([
                'code' => self::FAIL_CODE,
                'data' => $e->getMessage(),
                'message' => self::FAIL_MSG
            ]);
        }

        return $res;
    }

    /**
     * @param DeleteBookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function deleteBook(DeleteBookRequest $request)
    {
        $res = null;
        try {
            $book = Book::find($request->id);
            $book->delete();
            $res = response()->json([
                'code' => self::SUCCESS_CODE,
                'data' => $book,
                'message' => self::SUCCESS_MSG
            ]);
        } catch (Exception $e) {
            $res = response()->json([
                'code' => self::FAIL_CODE,
                'data' => $e->getMessage(),
                'message' => self::FAIL_MSG
            ]);
        }

        return $res;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getBooks()
    {
        $res = null;

        try {
            $books = Book::all();
            $res = response()->json([
                'code' => self::SUCCESS_CODE,
                'data' => $books,
                'message' => self::SUCCESS_MSG
            ]);
        } catch (Exception $e) {
            $res = response()->json([
                'code' => self::FAIL_CODE,
                'data' => $e->getMessage(),
                'message' => self::FAIL_MSG
            ]);
        }

        return $res;
    }
}
