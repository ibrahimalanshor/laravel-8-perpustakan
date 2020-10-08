<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Yajra\Datatables\Datatables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable();
        }
        return view('book.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'string|max:6|unique:books|nullable',
            'name' => 'required|string|max:255|unique:books',
            'writer' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:'.(date('Y')+1),
            'category_id' => 'required|exists:categories,id'
        ]);

        if (!$request->code) {
            $code = Str::upper(Str::random(6));

            $request->merge([
                'code' => $code
            ]);
        }

        Book::create($request->all());

        return redirect('book')->with('success', 'Success Create Book');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'code' => 'string|max:6|nullable|unique:books,code,'.$book->id,
            'name' => 'required|string|max:255|unique:books,name,'.$book->id,
            'writer' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:'.(date('Y')+1),
            'category_id' => 'required|exists:categories,id'
        ]);

        if (!$request->code) {
            $code = Str::upper(Str::random(6));

            $request->merge([
                'code' => $code
            ]);
        }

        $book->update($request->all());

        return response()->json(['msg' => 'Success Update Book']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['msg' => 'Success Delete Book']);
    }

    // Get Book
    public function get(Request $request)
    {
        $code = $request->code;
        $books = Book::where('code', 'like', '%'.$code.'%')->latest()->get(
            ['id', 'code as text', 'name', 'stock']
        );
        return $books;
    }

    // Get Datatable
    public function datatable()
    {
        $books = Book::with('category')->get();

        return Datatables::of($books)
                    ->addIndexColumn()
                    ->addColumn('action', function ()
                    {
                        $btn = '
                            <button class="btn btn-success btn-sm edit">Edit</button>
                            <button class="btn btn-danger btn-sm delete">Delete</button>
                        ';
                        return $btn;
                    })
                    ->make(true);
    }
}
