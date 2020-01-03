<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Resources\Contact as ContactResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactsController extends Controller
{
    // Index method

    public function index()
    {

        $this->authorize('viewAny', Contact::class);

        return ContactResource::collection(request()->user()->contacts);

    }

    // Store method

    public function store()
    {
        $this->authorize('create', Contact::class);

        $contact = request()->user()->contacts()->create($this->validateData());

        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);

    }

    // Show method

    public function show(Contact $contact)
    {

        $this->authorize('view', $contact);

        return new ContactResource($contact);
    }

    // Update method

    public function update(Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->update($this->validateData());

        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    // Delete method

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    // Validate Data

    private function validateData()
    {

        return request()->validate([

            'name' => 'required',
            'email' => 'required|email',
            'birthday' => 'required',
            'company' => 'required',

        ]);

    }
}
