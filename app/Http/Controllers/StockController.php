<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Book;
use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

class StockController extends Controller
{

    public function add(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable('in');
        }

        return view('stock.add');
    }

    public function remove(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable('out');
        }

        return view('stock.remove');
    }


    public function create(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:books,id',
            'total' => 'required|integer',
            'type' => 'required|in:in,out'
        ]);

        $id = $request->code;
        $type = $request->type;
        $total = $request->total;

        $book = Book::findOrFail($id);

        if ($type === 'in') {
            $book->increment('stock', $total);
            $msg = 'Succes Add Stock';
        } else {
            $book->decrement('stock', $total);
            $msg = 'Succes Remove Stock';
        }

        $request->merge([
            'book_id' => $id
        ]);

        Stock::create($request->all());

        return response()->json(['msg' => $msg]);
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return response()->json(['msg' => 'Success Delete History']);
    }

    // Get Datatable
    public function datatable($type)
    {
        $stocks = Stock::whereType($type)->get(['id', 'total', 'created_at as date', 'book_id']);

        return Datatables::of($stocks)
            ->addIndexColumn()
            ->editColumn('date', '{{ localDate($date) }}')
            ->addColumn('code', function ($stock)
            {
                return $stock->book->code;
            })
            ->addColumn('action', '<button class="btn btn-sm btn-danger delete">Delete</button>')
            ->make(true);
    }

}
