<?php


namespace App\Repositories;


use App\Contracts\ItemsInterface;
use App\Http\Requests\Item\StoreRequest;
use App\Http\Requests\Item\UpdateRequest;
use App\Models\Item;
use Carbon\Carbon;

class ItemsRepository implements ItemsInterface
{
    /**
     * @return array|mixed
     */
    public function index()
    {
        $items = Item::all()->toArray();
        return array_reverse($items);
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store(StoreRequest $request)
    {
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'attachment-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('/public/attachments', $filename);
            $img_path = url('storage/attachments/'.$filename);
        }
        if ($request->has('expiration_date')) {
            $dateTime = Carbon::parse($request->input('expiration_date'));
            $expirationDate = $dateTime->format('Y-m-d H:i:s');
        }

        $item = Item::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'attachment' => $filename ?? null,
            'attachment_path' => $img_path ?? null,
            'expiration_date' => $expirationDate ?? null,
        ]);

        $item->save();

        return response()->json([
            'message' => 'Item created!',
            'item' => $item,
        ]);
    }

    /**
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function show(Item $item)
    {
        return response()->json([
            'item' => $item,
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(UpdateRequest $request, Item $item)
    {
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'attachment-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('/public/attachments', $filename);
            $img_path = url('storage/attachments/'.$filename);
        }

        $item->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'attachment' => $filename ?? $item->attachment,
            'attachment_path' => $img_path ?? $item->attachment_path,
            'expiration_date' => $request->input('expiration_date') ?? $item->expiration_date,
        ]);

        return response()->json([
            'success' => 'Item updated!',
            'item' => $item
        ]);
    }

    /**
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function delete(Item $item)
    {
        $item->delete();

        return response()->json([
            'success' => 'Item deleted!'
        ]);
    }
}
