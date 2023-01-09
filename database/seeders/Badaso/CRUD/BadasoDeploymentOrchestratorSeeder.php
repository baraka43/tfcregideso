<?php

namespace Database\Seeders\Badaso\CRUD;

use Illuminate\Database\Seeder;
use Uasoft\Badaso\Traits\Seedable;

class BadasoDeploymentOrchestratorSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = 'database/seeders/Badaso/CRUD/';

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->seed(PaiementsCRUDDataTypeAdded::class);
        $this->seed(PaiementsCRUDDataRowAdded::class);
        $this->seed(ClientsCRUDDataTypeAdded::class);
        $this->seed(ClientsCRUDDataRowAdded::class);
    }
}
