<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreRequest;
use App\Http\Requests\Item\UpdateRequest;
use App\Models\Item;
use Carbon\Carbon;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all()->toArray();
        return array_reverse($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'attachment-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('attachments', $filename);
        }
        if ($request->has('expiration_date')) {
            $dateTime = Carbon::parse($request->input('expiration_date'));
            $expirationDate = $dateTime->format('Y-m-d H:i:s');
        }

        $item = Item::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'attachment' => $filename ?? null,
            'expiration_date' => $expirationDate ?? null,
        ]);

        $item->save();

        return response()->json([
            'message' => 'Item created!',
            'item' => $item,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Item $item)
    {
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'attachment-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('attachments', $filename);
        }

        $item->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'attachment' => $filename ?? $item->attachment,
            'expiration_date' => $request->input('expiration_date') ?? $item->expiration_date,
        ]);

        return response()->json([
            'success' => 'Item updated!',
            'item' => $item
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json([
            'success' => 'Item deleted!'
        ]);
    }
}
