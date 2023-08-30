<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

use \Symfony\Component\HttpFoundation\Response;


class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;
    public function setUp():void {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user);
    }
    /**
     * 正常系 一覧参照
     * ステータスコード 200
     * @test
     * @group task-all-success
     * @return void
     */
    public function 一覧を取得できる()
    {
        $tasks = Company::factory()->count(1)->create();
        $response = $this->getJson('api/comapnies');

        $response->assertOk()
            ->assertJsonCount($tasks->count());
    }
    /**
     * 正常系　登録
     * ステータスコード 201
     * @test
     * @group task-post-success
     * @return void
     */
    public function 登録することができる()
    {
        $data = [
            // "client_key" => hash( "sha256", '1'),
            "name" => 'テスト商事',
            // "email" => 'testshouji@test.com',
            // "postal_code" => "123-4567",
            // "address" => "神奈川県藤沢市大庭432-20",
            // "email" => "test1@test.com",
            // "phone" => "0466872686"
        ];

        $response = $this->postJson('api/tasks', $data);

        $response->assertStatus(Response::HTTP_CREATED);
    }

   /**
     * 正常系　登録
     * ステータスコード 201
     * @test
     * @group task-post-error-name-isempty
     * @return void
     */
    public function 会社名が空の場合は登録できない()
    {
        $data = [
            // "client_key" => hash( "sha256", '1'),
            "name" => '',
            // "postal_code" => "123-4567",
            // "address" => "神奈川県藤沢市大庭432-20",
            // "email" => "test1@test.com",
            // "phone" => "0466872686"
        ];

        $response = $this->postJson('api/comapnies', $data);
        dd($response->json());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    /**
     * 異常系 登録時のメール書式エラー
     * ステータスコード 422
     * @test
     * @group testing-task-post-error
     * @return void
     */
    public function emailの書式不正の場合は登録できない()
    {
        // @マークが存在しない
        $data = [
            "client_key" => hash( "sha256", '1'),
            'name' => 'テスト商事1',
            'postal_code' => '123-4567',
            'address' => '神奈川県藤沢市大庭432-20',
            'email' => 'test1test.com',
            'phone' => '0466872686'
        ];

        $response = $this->postJson('api/comapnies', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    /**
     * 異常系 登録時のメール重複エラー
     * ステータスコード 422
     * @test
     * @group testing-task-post-error
     * @return void
     */
    public function emailを重複して登録できない()
    {
        $data = [
            'client_key' => hash( "sha256", '1'),
            'name' => 'テスト商事1',
            'postal_code' => '1234567',
            'address' => '神奈川県藤沢市大庭432-20',
            'email' => 'test1@test.com',
            'phone' => '0466872686'
        ];
        $response = $this->postJson('api/comapnies', $data);

        $data = [
            'client_key' => hash( "sha256", '1'),
            'name' => 'テスト商事2',
            'postal_code' => '123-4567',
            'address' => '神奈川県藤沢市大庭432-20',
            'email' => 'test1@test.com',
            'phone' => '0466872686'
        ];
        $response = $this->postJson('api/comapnies', $data);
        // dd($response);

        // 重複エラー
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * 異常系 郵便番号が数字以外が含まれた場合はエラー
     * ステータスコード　 422
     * @test
     * @group testing-task-post-error
     * @return void
     */
    public function 郵便番号に数字以外が含まれた場合は登録できない()
    {
        // 郵便番号に半角記号が含まれた場合
        $data = [
            'client_key' => hash( "sha256", '1'),
            'name' => 'テスト商事',
            'postal_code' => '12--4567',
            'address' => '神奈川県藤沢市大庭432-20',
            'email' => 'test1@test.com',
            'phone' => '0466878'
        ];

        // 結果
        $response = $this->postJson('api/comapnies', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // 郵便番号に全角が含まれた場合
        $data = [
            'client_key' => hash( "sha256", '1'),
            'name' => 'テスト商事',
            'postal_code' => '１２３４５６７',
            'address' => '神奈川県藤沢市大庭432-20',
            'email' => 'test1@test.com',
            'phone' => '0466878'
        ];

        // 結果
        $response = $this->postJson('api/comapnies', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * 異常系 郵便番号が数字7桁でない場合のエラー
     * ステータスコード 422
     * @test
     * @group testing-task-post-error
     * @return void
     */
    public function 郵便番号が半角数字7桁でない場合は登録できない()
    {
        // ７桁より少ない
        $data = [
            'client_key' => hash( "sha256", '1'),
            'name' => 'テスト商事',
            'postal_code' => '123567',
            'address' => '神奈川県藤沢市大庭432-20',
            'email' => 'test1@test.com',
            'phone' => '0466878'
        ];

        $response = $this->postJson('api/comapnies', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // 7桁超過
        $data = [
            'client_key' => hash( "sha256", '1'),
            'name' => 'テスト商事',
            'postal_code' => '123567',
            'address' => '神奈川県藤沢市大庭432-20',
            'email' => 'test1@test.com',
            'phone' => '0466878'
        ];

        $response = $this->postJson('api/comapnies', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * 正常系 更新することができる
     * ステータスコード 200
     * @test
     * @group testing-task-update1
     * @return void
     */
    public function 更新することができる()
    {
        $task = Company::factory()->create();
        $task->name = '更新された';
        $task->is_done = 0;

        // 更新
        $response = $this->patchJson("api/comapnies/{$task->id}", $task->toArray());
        // 結果
        $response->assertOk()
            ->assertJsonFragment($task->toArray());
    }

    /**
     * 正常系 削除することができる
     * ステータスコード 200
     * @test
     * @group testing-task-delete
     * @return void
     */
    public function 削除することができる()
    {
        $task = Company::factory()->count(10)->create();

        // 削除
        $response = $this->deleteJson("api/comapnies/1");
        $response->assertOk();

        // 削除検証(削除したのでレコード数１減少)
        $response = $this->getJson('api/comapnies');
        $response->assertJsonCount($task->count() - 1);
    }
}
