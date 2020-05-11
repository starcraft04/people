<?php

use App\Project;
use Illuminate\Database\Seeder;

class ProjectTableCorrectEmptySambaID extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value =
            [
                'pullthru_samba_id' => null,
                'samba_stage' => null,
                'win_ratio' => null,
                'samba_opportunit_owner' => null,
                'samba_lead_domain' => null,
                'revenue' => null,
                'samba_pullthru_tcv' => null,
                'samba_consulting_product_tcv' => null,
            ];

        $projects = Project::whereNull('samba_id');

        $projects->update($value);
    }
}
