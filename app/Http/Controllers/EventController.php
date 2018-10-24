<?php

namespace App\Http\Controllers;

use App\Event;
use DateTime;
use Illuminate\Http\Request;

class EventController extends Controller {
  public function getAll() {
    return response()->json(Event::all());
  }

  public function create(Request $req) {
    $event = Event::create($this->sanitiseInput($req));
    return response(null, 201)
      ->header('Location', action('EventController@read', ['id' => $event->id]));
  }

  private function sanitiseInput(Request $req) {
    $processed = $req->only(['name', 'date']);
    $processed['date'] = new DateTime($processed['date']);
    return $processed;
  }

  public function read($id) {
    return response()->json(Event::with('union_products')->findOrFail($id));
  }

  public function update(Request $req, $id) {
    $event = Event::findOrFail($id);
    $event->update($this->sanitiseInput($req));
    return response()->json($event);
  }

  public function delete($id) {
    $event = Event::findOrFail($id);
    $event->delete();
    return response(null, 203);
  }
}
