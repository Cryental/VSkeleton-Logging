<?php

class ProductRepository
{
    public function Create(array $inputs)
    {
        return Product::query()->create([
            'name' => $inputs['name'],
        ]);
    }

    public function Find($id)
    {
        return Product::query()->where('id', $id)->first();
    }

    public function Wipe($id)
    {
        $toBeDeletedProduct = $this->Find($id);

        if (!$toBeDeletedProduct) {
            return null;
        }

        $toBeDeletedProduct->delete();

        return [
            'result' => 'true',
        ];
    }
}
