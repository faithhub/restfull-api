<?php

namespace App\Http\Controllers;

use App\Models\CheckPost;
use App\Models\Post;
use App\Mail\Subscriber;
use App\Models\Subscriber as ModelsSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
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
                "posts" => Post::with('website')->get()
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
    public function create(Request $request)
    {
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
                'title'  => ['required', 'max:200'],
                'description' => 'required'
            );

            //Set Field Name
            $fieldNames = array(
                'website_id'     => 'Website ID',
                'title'  => 'Post Title',
                'description' => 'Post Description'
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
            $post = new Post([
                'website_id' => $request->get('website_id'),
                'title' => $request->get('title'),
                'description' => $request->get('description')
            ]);
            $post->save();

            $post = Post::with('website')->get();
            for ($i = 0; $i < $post->count(); $i++) {
                $sub = ModelsSubscriber::where('website_id', $post[$i]->website_id)->get();
                for ($j = 0; $j < $sub->count(); $j++) {
                    $check = CheckPost::where(['website_id' => $post[$i]->website_id,  'post_id' => $post[$i]->id, 'subscriber_id' => $sub[$j]->id])->get();
                    if ($check->count() == 0) {
                        $data = [
                            'website_name' => $post[$i]->website->name,
                            'website_link' => $post[$i]->website->url,
                            'subscriber_name' => $sub[$j]->name,
                            'title' => $post[$i]->title,
                            'description' => $post[$i]->description
                        ];
                        Mail::to($sub[$j]->email)->send(new Subscriber($data));
                        $save = new CheckPost([
                            'website_id' => $post[$i]->website_id,  'post_id' => $post[$i]->id, 'subscriber_id' => $sub[$j]->id
                        ]);
                        $save->save();
                    }
                }
            }
            //Response
            return response()->json([
                "message" => "Post created"
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
        try {
            return response()->json([
                "message" => "Post Fetched",
                "data" => Post::find($id),
            ], 201);
        } catch (\Throwable $th) {
            //Catch Error
            return response()->json([
                "error" => $th->getMessage()
            ], 400);
        }
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
        try {
            //Set Field Rule
            $rules = array(
                'website_id' => ['required', 'numeric'],
                'title'  => ['required', 'max:200'],
                'description' => 'required'
            );

            //Set Field Name
            $fieldNames = array(
                'website_id' => 'Website ID',
                'title'  => 'Post Title',
                'description' => 'Post Description'
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
            $post = Post::find($id)->first();
            $post->website_id = $request->get('website_id');
            $post->title = $request->get('title');
            $post->description = $request->get('description');
            $post->save();
            return response()->json([
                "message" => "Post Updated"
            ], 201);
        } catch (\Throwable $th) {
            //Catch Error
            return response()->json([
                "error" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Post::find($id)->delete();
            return response()->json([
                "message" => "Post Deleted"
            ], 201);
        } catch (\Throwable $th) {
            //Catch Error
            return response()->json([
                "error" => $th->getMessage()
            ], 400);
        }
    }
}
