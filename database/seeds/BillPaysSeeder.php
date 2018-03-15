<?php


use Phinx\Seed\AbstractSeed;
use GAMAFin\Models\CategoryCost;

class BillPaysSeeder extends AbstractSeed
{
    protected $categories;

    public function run()
    {
        require __DIR__ . '/../bootstrap.php';
        $this->categories = CategoryCost::all();
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider($this);
        $billPays = $this->table('bill_pays');
        $data = [];

        foreach( range(1,10) as $value ) {
            $userId = rand(1,4);
            $data[] = [
                'date_launch' => $faker->date(),
                'name' => $faker->word,
                'value' => $faker->randomFloat(2, 10, 1000),
                'user_id' => $userId,
                'category_cost_id' => $faker->categoryId($userId),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')

            ];
        }

        $billPays->insert($data)->save();
    }

    public function categoryId($user_id)
    {
        $categories = $this->categories->where('id', $user_id);
        $categories = $categories->pluck('id');
        return \Faker\Provider\Base::randomElement($categories->toArray());

    }


}
