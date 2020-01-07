<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Imports\ContactsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
    /**
     * ContactController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize(Contact::class);

        $input = $this->validate($request, [
            'extra' => 'sometimes|array',
            'columns' => 'required|array',
            'document' => 'required|file|max:5000',
        ]);

        Excel::import(new ContactsImport($input['columns'], $input['extra'] ?? []), $input['document']);

        return response()->json();
    }
}
