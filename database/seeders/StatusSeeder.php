<?php

namespace Database\Seeders;


use App\Models\Status;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;


class StatusSeeder extends Seeder

{

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()

    {

        $statuses = [
            'Active',
            'Inactive',
            'Pending',
            'Approved',
            'Rejected',
        ];


        foreach ($statuses as $status) {
            if (!Status::where('name', $status)->exists()) {
                Status::create([
                    'name' => $status,
                    'description' => $status,
                ]);
            }

        }

    }

}
