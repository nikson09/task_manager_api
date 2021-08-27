<?php

use Illuminate\Database\Seeder;
use App\Status;

class AddRowsInStatusTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'К выполнению',
            'В процессе',
            'Тестирование',
            'Готово'
        ];

        foreach($statuses as $status){
            Status::create([
                'name' => $status
            ]);
        }
    }
}
