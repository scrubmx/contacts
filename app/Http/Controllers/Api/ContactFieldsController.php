<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ContactFieldsController extends Controller
{
    /**
     * Return a listing of the requested resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        return new JsonResponse([
            'data' => (new Contact)->getFillable(),
        ]);
    }
}
