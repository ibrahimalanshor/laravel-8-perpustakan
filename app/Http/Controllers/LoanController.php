<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Yajra\Datatables\Datatables;

class LoanController extends Controller
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

        return view('loan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('loan.create');
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
            'member_id' => 'required|exists:members,id',
            'return' => 'required|date|after:today',
            'book_id' => 'required|array',
            'total_id' => 'required|array',
        ]);

        $qty = collect($request->total_id);
        $books = collect($request->book_id);

        $qty = $qty->map(function ($item)
        {
            return ['qty' => $item];
        });

        $books = $books->combine($qty);

        $books->each(function ($item, $key)
        {
            $book = Book::findOrFail($key);
            $book->decrement('stock', $item['qty']);
        });

        $loan = Loan::create($request->only('member_id', 'return'));
        $loan->books()->attach($books->all());

        return redirect('loan')->with('success', 'Success Make Loan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();

        return response()->json(['msg' => 'Success Delete Loan']);
    }

    // Return Loan
    public function return(Loan $loan)
    {
        $books = $loan->books;

        $books->each(function ($book)
        {
            $book->increment('stock', $book->pivot->qty);
        });

        $loan->update([
            'status' => 0
        ]);

        return response()->json(['msg' => 'Success Return Loan']);
    }

    // Extend Loan
    public function extend(Request $request, Loan $loan)
    {
        $request->validate([
            'date' => 'required|date|after:today'
        ]);

        $loan->update([
            'return' => $request->date
        ]);

        return response()->json(['msg' => 'Success Extend Loan']);
    }

    // Get Datatatble
    public function datatable()
    {
        $loans = Loan::with(['books' => function ($book)
        {
            $book->select('name');
        }, 'member' => function ($member)
        {
            $member->select('id','name');
        }])->latest()->get();

        return Datatables::of($loans)
            ->addIndexColumn()
            ->addColumn('late', function ($loan)
            {
                if ($loan->status) {
                    $today = Carbon::today();
                    $return = Carbon::parse($loan->return);

                    return min($today->diffInDays($return, false), 0);
                } else {
                    return 0;
                }
            })
            ->addColumn('return_date', function ($loan)
            {
                return $loan->return;
            })
            ->editColumn('return', '{{ localDate($return) }}')
            ->make(true);
    }
}
