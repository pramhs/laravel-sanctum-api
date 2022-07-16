<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Database\QueryException;

class BookController extends Controller
{
    //add book
    public function createBook(Request $request)
    {
      //validate fields from request
      $fields = $request->validate([
        'title' => 'required',
        'author' => 'required',
        'publisher' => 'required' //just accepting ['Gramedia','Grasindo', 'Mediakita'] value
        ]);
       
       //crete book
       /* 
       this code to catch error handling
       when inserting data got errors
       */
       try {
         Book::create($request->all());
         return response()->json([
           'message' => 'book created succuessfully'
           ]);
       }
       catch(QueryException $e) {
         return response()->json([
           'message' => 'you should input one if this value : { Gramedia, Grasindo, Mediakita } in the publisher field'
           ]);
       }
      
      
      
    }
    
    //list book
    public function listBook()
    {
      $books = Book::get();
      
      //response list books
      return response()->json([
        'message' => 'list book',
        'data' => $books
        ]);
    }
    
    //single book
    public function singleBook($id)
    {
      /* 
      find book details using find method
      if data is empty, it shown message book not found
      and if data found, it shown the book details
      */
      $book = Book::find($id);
      if(empty($book))
      {
        return response()->json([
          'message' => 'book not found'
          ]);
      }
      return response()->json([
        'message' => 'book found',
        'data' => $book
        ]);
    }
    
    //edit book
    public function updateBook(Request $request, $id)
    {
      /*
      find book details using where method
      */
      $book = Book::where('id', $id)->first();
      if(empty($book))
      {
        return response()->json([
          'message' => 'book not found'
          ]);
      }
      
      $book->title = !empty($request->title) ? $request->title : $book->title;
      $book->author = !empty($request->author) ? $request->author : $book->author;
      $book->publisher = !empty($request->publisher) ? $request->publisher : $book->publisher;
      $book->save();
      
      return response()->json([
        'message' => 'book edited successfully',
        'data' => $book
        ]);
    }
    
    //delete book
    public function deleteBook($id)
    {
      $book = Book::find($id);
      if(empty($book))
      {
        return response()->json([
          'message' => 'book not found'
          ]);
      }
      $book->delete();
      return response()->json([
        'message' => 'book deleted successfully'
        ]);
    }
}
