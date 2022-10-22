<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Website;
use Illuminate\Http\Request;

class WebsitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $websites = Website::all();
        return response()
            ->json([
                "data" => $websites
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'website_name' => 'required|unique:websites',
            'url' => 'required',
        ]);

        //validation passed, we create a new website
        $website = new Website();
        $website->website_name = $request['website_name'];
        $website->url = $request['url'];
        $website->save();

        //return the created website entry
        return response()
            ->json([
                'data' => $website
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function newSubscriber(Request $request){
        //validate the request
        $validated = $request->validate([
            'website_id' => 'required',
            'user_id' => 'required',
        ]);

        //check if this user is already subscribed to this website before
        $previousSubscription = Subscription::where([
            "website_id" => $request['website_id'],
            "user_id" => $request['user_id'],
        ])->first();
        if($previousSubscription) {
            return response()->json([
                "message" => "User already subscribed to website"
            ], 422);
        }

        //create new subscriber
        $subscriber = new Subscription();
        $subscriber->website_id = $request['website_id'];
        $subscriber->user_id = $request['user_id'];
        $subscriber->save();


        //return response
        return response()
            ->json([
                "data" => $subscriber
            ]);
    }
}
