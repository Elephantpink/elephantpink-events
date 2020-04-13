<?php

namespace EPink\Events\Http\Controllers;

use Illuminate\Http\Request;
use EPink\Events\Http\Resources\EventResource;
use EPink\Events\Models\Event;
use EPink\Events\Http\Requests\StoreEvent;

class EventsController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(['events' => EventResource::collection(Event::orderBy('date')->get())]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvent $request)
    {
        $validated = $request->validated();

        try {
            $event = Event::create($validated);

            return response()->json(['event' => $event], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Unexpected server error'], 500);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEvent $request, Event $event)
    {
        $validated = $request->validated();

        try {

            $event->update($validated);

            return response()->json(['event' => $event], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Unexpected server error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        try {
            $event->delete();

            return response()->json(null, 203);
        } catch(\Exception $e) {
            return response()->json(['message' => 'Unexpected server error'], 500);
        }
        
    }
}
