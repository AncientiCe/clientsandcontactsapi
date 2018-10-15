<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return Client::all();
    }

    public function show(Client $client)
    {
        return $client;
    }

    public function store(Request $request)
    {
        $client = Client::create($request->all());

        return response()->json($client);
    }

    public function update(Request $request, Client $client)
    {
        $client->update($request->all());

        return response()->json($client);
    }

    public function delete(Client $client)
    {
        $client->softDeletes();

        return response()->json(null, 204);
    }
}
