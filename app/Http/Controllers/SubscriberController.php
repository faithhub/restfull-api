<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json([
                "message" => "All Posts",
                "posts" => Subscriber::all()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            //Set Field Rule
            $rules = array(
                'website_id' => ['required', 'numeric'],
                'name'  => ['required', 'max:100'],
                'email' => ['required', 'email']
            );

            //Set Field Name
            $fieldNames = array(
                'website_id' => 'Website ID',
                'name'  => 'Name',
                'email' => 'Email'
            );

            //Validate
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);
            if ($validator->fails()) {
                return response()->json([
                    "message" => "All fields are required",
                    "errors" => $validator->errors()
                ], 400);
            }

            //Create New Post
            $subscribe = new Subscriber([
                'website_id' => $request->get('website_id'),
                'name' => $request->get('name'),
                'email' => $request->get('email')
            ]);
            $subscribe->save();

            //Response
            return response()->json([
                "message" => "Subscribed Successfully"
            ], 201);
        } catch (\Throwable $th) {
            //Catch Error
            return response()->json([
                "error" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
