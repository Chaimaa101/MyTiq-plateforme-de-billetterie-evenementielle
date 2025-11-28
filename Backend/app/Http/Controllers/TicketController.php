<?php

namespace App\Http\Controllers;

use App\Events\TicketCreated;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return  $request->user()->tickets()->with('event','user')->get();
             
        } catch (\Exception $e) {
             return [
                'error' => $e->getMessage()
            ];
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request , Event $event)
    {
        try {
            $request->validated();

           $ticket = $request->user()->tickets()->create([
            'event_id' => $event->id,
            'date'   => now()
        ]);

        event(new TicketCreated($ticket));

        return response()->json([
            'message' => 'Ticket created successfully!',
            'ticket' => $ticket
        ], 201);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
         try {
            return $ticket;
             
        } catch (\Exception $e) {
             return [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
   {
        try {
            $infos = $request->validate();
            $ticket->update($infos);
            return [
                'message' => 'ticket updated successfully',
                'Ticket' =>$ticket
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
          try {
            $ticket->delete();
            return [
                'message' => 'ticket deleted successfully',
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
