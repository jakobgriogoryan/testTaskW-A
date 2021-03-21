<?php

namespace App\Contracts;

use App\Http\Requests\Item\StoreRequest;
use App\Http\Requests\Item\UpdateRequest;
use App\Models\Item;

interface ItemsInterface
{
    /**
     * @return mixed
     */
    public function index();

    /**
     * @param StoreRequest $request
     * @return mixed
     */
    public function store(StoreRequest $request);

    /**
     * @param Item $item
     * @return mixed
     */
    public function show(Item $item);

    /**
     * @param UpdateRequest $request
     * @param Item $item
     * @return mixed
     */
    public function update(UpdateRequest $request, Item $item);

    /**
     * @param Item $item
     * @return mixed
     */
    public function delete(Item $item);

}
