<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContact;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request) {

        $data = $request->all();

        $validator = Validator::make($data,
            [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors()
                ]
            );
        }

        $pippo = new Lead();
        $pippo->fill($data);
        $pippo->save();

        $oggettoNewContact = new NewContact($pippo);

        Mail::to('info@simonegiusti.it')->send($oggettoNewContact);

        return response()->json(
            [
                'success' => true
            ]
        );

    }
}
