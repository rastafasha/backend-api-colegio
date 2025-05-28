<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactFormController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contactStore(ContactFormRequest $request)
    {
        
        // return Contact::create($request->all());
        try {
            DB::beginTransaction();

            $contact = new Contact();

            $input = $this->contactInput();
            $contact->fill($input)->save();

            DB::commit();
            return response()->json([
                'message' => 'Contact created successfully',
                'currency' => $contact,
            ], 201);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error no crated',
            ], 500);
        }
    }


    /**
     * Función protegida para guardar los datos
     *
     * @return array
     */
    protected function contactInput(): array {
        return [
            "name" => request("name"),
            "email" => request("email"),
            "phone" => request("phone"),
            "movil" => request("movil"),
            "subject" => request("subject"),
            "comment" => request("comment"),
        ];
    }

}
