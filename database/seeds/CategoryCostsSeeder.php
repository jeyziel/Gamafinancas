<?php


use Phinx\Seed\AbstractSeed;

class CategoryCostsSeeder extends AbstractSeed
{
    public function run()
    {
        $categoryCosts = $this->table('category_costs');
        $faker = \Faker\Factory::create('pt_BR');
        $data = [];

        for( $i = 0; $i<count( range(0,9) ); $i++) {
            $data[] = [
                'name' => $faker->name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

//        foreach (range(0,9) as $value) {
//            $data[] = [
//                    'name' => $faker->name,
//                    'created_at' => date('Y-m-d H:i:s'),
//                    'updated_at' => date('Y-m-d H:i:s'),
//            ];
//
//        }

        $categoryCosts->insert($data)->save();
    }
}
