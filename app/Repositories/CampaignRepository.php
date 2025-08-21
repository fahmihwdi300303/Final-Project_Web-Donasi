<?php

namespace App\Repositories;

use App\Models\Campaign;

class CampaignRepository
{
    public function getAll()
    {
        return Campaign::all();
    }

    public function findById($id)
    {
        return Campaign::findOrFail($id);
    }
}