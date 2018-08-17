<?php

namespace models;

use app\models\User;
use app\tests\fixture\UserFixture;
use Yii;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'user' => UserFixture::className()
        ];
    }

    protected function _before()
    {
    }

    protected function _after()
    {
//        $sql = 'TRUNCATE TABLE ' . User::tableName();
//        Yii::$app->db->createCommand($sql)->execute();
    }

    // tests
    public function testCreate()
    {
        $user = new User([
            'role_id' => 1,
            'legal_status_id' => 1,
            'name' => 'Vasya',
            'email' => 'vasya@mail.ru',
            'region_id' => 22,
            'phone' => '12345',
            'status' => 1,
        ]);

        expect_that($user->save());
    }

    public function testCreateEmptyFormSubmit()
    {
        $user = new User();
        expect_not($user->validate());
        expect_not($user->save());
    }

    public function testUpdate()
    {
        $user = User::findOne(2);
        expect_that($user !== null);

        $user->role_id = 2;
        $user->legal_status_id = 2;
        $user->name = 'Vovan';
        $user->email = 'vovan@mail.ru';
        $user->region_id = 33;
        $user->phone = '2128506';
        $user->status = 2;

        $user->save();

        expect_that($user->save());
    }

    public function testDelete()
    {
        $user = User::findOne(1);
        expect_that($user !== null);
        expect_that($user->delete());
    }

}