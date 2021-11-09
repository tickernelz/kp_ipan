<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class AutoCompleteController extends Controller
{
    public function Buku(Request $request)
    {
        $query = $request->get('buku');
        $filterResult = Buku::where('judul', 'LIKE', '%'.$query.'%')->pluck('judul');

        return response()->json($filterResult);
    }

    public function Isbn(Request $request)
    {
        $query = $request->get('isbn');
        $filterResult = Buku::where('isbn', 'LIKE', '%'.$query.'%')->pluck('isbn');

        return response()->json($filterResult);
    }
}
