<?php

namespace Database\Seeders;

use App\Models\ApprovalStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ApprovalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        ApprovalStatus::truncate();
        ApprovalStatus::insert($this->getData());
        Schema::enableForeignKeyConstraints();
    }

    protected function getData()
    {
        $data = [
            'Waiting',
            'Approved',
            'Rejected',
        ];

        return collect($data)
            ->map(function ($item) {
                return [
                    'name' => $item,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })
            ->all();
    }
}
