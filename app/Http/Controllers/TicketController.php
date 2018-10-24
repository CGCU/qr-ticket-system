<?php

namespace App\Http\Controllers;

use App\Attendee;
use App\Event;
use App\Jobs\SendTicketEmail;
use App\Ticket;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller {
  public function getAll($eventId) {
    $tickets = Ticket::with(['purchaser', 'attendee'])->where('event_id', $eventId)->get();
    return response()->json($tickets);
  }

  /* Send emails for all tickets that haven't been sent & have an email associate */
  public function sendEmails($eventId) {
    $tickets = Ticket::with(['purchaser'])->where('event_id', $eventId)->where('email_sent', false)->get();
    $delay = 0;
    foreach ($tickets as $ticket) {
      $this->dispatch((new SendTicketEmail($ticket, $ticket->purchaser))->delay($delay += 2.5));
      $ticket->update(['email_sent' => true]);
    }
    return response()->json(['emailsSent' => $tickets->count()]);
  }

  public function import($eventId) {
    $client = new Client;

    $event = Event::with('union_products')->findOrFail($eventId);
    $createdCount = 0;
    foreach ($event->union_products as $product) {
      // Get all sales for product
      $res = $client->request('GET', "https://eactivities.union.ic.ac.uk/api/CSP/600/Products/$product->id/sales", [
        'headers' => ['X-API-Key' => env('UNION_API_KEY')]
      ]);
      $purchases = json_decode($res->getBody(), true);
      // Filter already-imported purchases out
      $newPurchases = $product->last_imported === null ? $purchases
        : array_filter($purchases, function ($purchase) use ($product) {
          Log::info('SaleDateTime = ' . $purchase['SaleDateTime'] . '$product->last_imported = ' . $product->last_imported);
          return (new DateTime($purchase['SaleDateTime']) > $product->last_imported);
        });
      // Update last import time
      $product->last_imported = new DateTime();
      $product->save();
      foreach ($newPurchases as $purchase) {
        // Upsert purchaser
        $customer = $purchase['Customer'];
        $purchaser = Attendee::where(['login' => $customer['Login']])->updateOrCreate([
          "first_name" => $customer['FirstName'],
          "last_name" => $customer['Surname'],
          "email" => $customer['Email'],
          "login" => $customer['Login']
        ]);
        // Save tickets
        for ($i = 0; $i < $purchase['Quantity']; $i++) {
          $ticketCode = substr(base_convert(bin2hex(openssl_random_pseudo_bytes(8)), 16, 36), 0, 12);
          $ticket = new Ticket([
            "qr" => substr(preg_replace('/(\w{3})/', '\1-', strtoupper($ticketCode)), 0, 15),
            "email_sent" => false,
            "order_number" => $purchase['OrderNumber']
          ]);
          $ticket->event()->associate($event);
          $ticket->union_product()->associate($product);
          $ticket->purchaser()->associate($purchaser);
          $ticket->save();
          $createdCount++;
        }
      }
    }
    return response()->json(['ticketsCreated' => $createdCount]);
  }

  public function create(Request $req, $eventId) {
    $event = Event::findOrFail($eventId);
    $purchaser = Attendee::where(['login' => $req->input('id')])->updateOrCreate([
      "first_name" => $req->input('firstName'),
      "last_name" => $req->input('lastName'),
      "email" => $req->input('email'),
      "login" => $req->input('login'),
    ]);
    $purchaser->save();
    $ticketCode = substr(base_convert(bin2hex(openssl_random_pseudo_bytes(8)), 16, 36), 0, 12);
    $ticket = new Ticket([
      "qr" => substr(preg_replace('/(\w{3})/', '\1-', strtoupper($ticketCode)), 0, 15),
      "email_sent" => false,
    ]);
    $ticket->purchaser()->associate($purchaser);
    $event->tickets()->save($ticket);

    return response(null, 201)
      ->header('Location', action('TicketController@getAll', ['eventId' => $event->id]));
  }

  public function delete($eventId, $id) {
    $ticket = Ticket::with('event')->findOrFail($id);
    if ($ticket->event->id !== (int)$eventId) {
      throw new \Exception("Cannot delete ticket $id from event $eventId - ticket belongs to event {$ticket->event->id}");
    }
    $ticket->delete();
  }
}
