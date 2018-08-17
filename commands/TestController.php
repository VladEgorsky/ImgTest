<?php

namespace app\commands;

use Yii;
use yii\base\Module;
use yii\console\Controller;
use Faker;
use yii\helpers\ArrayHelper;

class TestController extends Controller
{
    protected $faker;
    protected $path = '@app/tests/fixture/data';
    protected $fixtures = [
        'generateUserFixture' => [
            'function' => 'generateUserFixture',
            'file' => 'tbl_user.php',
            'records' => 12,
            'active' => false,
        ],
        'generateCategoryFixture' => [
            'function' => 'generateCategoryFixture',
            'file' => 'tbl_category.php',
            'records' => 4,
            'active' => false,
        ],
        'generateUserCategoryFixture' => [
            'function' => 'generateUserCategoryFixture',
            'file' => 'tbl_user_cats.php',
            'records' => 20,
            'active' => true,
        ],
    ];

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->faker = Faker\Factory::create();
    }

    public function actionIndex()
    {
        foreach ($this->fixtures as $fixture) {
            if (!$fixture['active']) {
                continue;
            }

            $function = $fixture['function'];
            $records = $fixture['records'];

            $result = $this->$function($records);
            $result = "<?php \n return " . var_export($result, true) . "; \n";

            $fileName = $fixture['file'];
            $file = Yii::getAlias($this->path) . DIRECTORY_SEPARATOR . $fileName;
            file_put_contents($file, $result);
        }
    }

    protected function generateUserFixture($records)
    {
        $n = 1;
        $data = [];

        while ($n <= $records) {
            $data['user' . $n] = [
                'id' => $n,
                'role_id' => rand(1, 2),
                'legal_status_id' => rand(1, 2),
                'name' => $this->faker->firstName . ' ' . $this->faker->lastName,
                'email' => $this->faker->email,
                'status' => 1,
            ];

            $n++;
        }

        return $data;
    }

    protected function generateCategoryFixture($records)
    {
        $n = 1;
        $data = [];

        while ($n <= $records) {
            $data['category' . $n] = [
                'id' => $n,
                'name' => $this->faker->word,
            ];

            $n++;
        }

        return $data;
    }

    protected function generateUserCategoryFixture($records)
    {
        $userFile = Yii::getAlias($this->path) . DIRECTORY_SEPARATOR
            . $this->fixtures['generateUserFixture']['file'];
        $categoryFile = Yii::getAlias($this->path) . DIRECTORY_SEPARATOR
            . $this->fixtures['generateCategoryFixture']['file'];

        $users = include($userFile);
        $category = include($categoryFile);

        $user_ids = array_values(ArrayHelper::getColumn($users, 'id'));
        $category_ids = array_values(ArrayHelper::getColumn($category, 'id'));

        $n = 1;
        $data = [];

        while ($n <= $records) {
            $data[] = [
                'user_id' => $user_ids[array_rand($user_ids)],
                'cat_id' => $category_ids[array_rand($category_ids)],
            ];

            $n++;
        }

        return $data;
    }
}