<?php

namespace App\Http\Controllers;

use App\Event;
use App\UnionProduct;
use Illuminate\Http\Request;

class UnionProductController extends Controller {
  public function __construct() {
  }

  public function create(Request $req, $eventId) {
    $event = Event::findOrFail($eventId);
    $event->union_products()->save(new UnionProduct(['id' => $req->input('id')]));
    return response(null, 201)
      ->header('Location', action('EventController@read', ['id' => $event->id]));
  }

  public function getAll($eventId) {
    return response()->json(Event::with('union_products')->findOrFail($eventId)->union_products);
  }

  public function delete($eventId, $id) {
    $product = UnionProduct::with('event')->findOrFail($id);
    if ($product->event->id !== (int)$eventId) {
      throw new \Exception("Cannot delete union product $id from event $eventId - product belongs to {$product->event->id}");
    }
    $product->delete();
  }
}
