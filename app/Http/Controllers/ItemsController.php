<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreRequest;
use App\Http\Requests\Item\UpdateRequest;
use App\Models\Item;
use App\Repositories\ItemsRepository;

class ItemsController extends Controller
{
    protected $itemsRepository;

    /**
     * ItemsController constructor.
     * @param ItemsRepository $itemsRepository
     */
    public function __construct(ItemsRepository $itemsRepository)
    {
        $this->itemsRepository = $itemsRepository;
    }

    /**
     * @return array|mixed
     */
    public function index()
    {
        return $this->itemsRepository->index();
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store(StoreRequest $request)
    {
        return $this->itemsRepository->store($request);
    }

    /**
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function show(Item $item)
    {
        return $this->itemsRepository->show($item);
    }

    /**
     * @param UpdateRequest $request
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(UpdateRequest $request, Item $item)
    {
        return $this->itemsRepository->update($request, $item);
    }

    /**
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy(Item $item)
    {
        return $this->itemsRepository->delete($item);
    }
}
