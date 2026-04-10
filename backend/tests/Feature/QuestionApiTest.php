<?php

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\User;

describe('質問一覧 API', function () {
    it('質問一覧を取得できる', function () {
        // GIVEN
        $questions = Question::factory()->count(3)->create();

        // WHEN
        $response = $this->getJson('/api/questions');

        // THEN
        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'body', 'category', 'answers_count', 'created_at'],
                ],
            ]);
    });

    it('質問一覧にカテゴリー名と回答数が含まれる', function () {
        // GIVEN
        $question = Question::factory()->create();
        Answer::factory()->count(2)->create(['question_id' => $question->id]);

        // WHEN
        $response = $this->getJson('/api/questions');

        // THEN
        $response->assertOk()
            ->assertJsonPath('data.0.answers_count', 2)
            ->assertJsonPath('data.0.category.name', $question->category->name);
    });
});

describe('質問詳細 API', function () {
    it('質問詳細を取得できる', function () {
        // GIVEN
        $question = Question::factory()->create();

        // WHEN
        $response = $this->getJson("/api/questions/{$question->id}");

        // THEN
        $response->assertOk()
            ->assertJsonPath('data.id', $question->id)
            ->assertJsonPath('data.title', $question->title);
    });

    it('質問詳細に回答一覧が含まれる', function () {
        // GIVEN
        $question = Question::factory()->create();
        Answer::factory()->count(2)->create(['question_id' => $question->id]);

        // WHEN
        $response = $this->getJson("/api/questions/{$question->id}");

        // THEN
        $response->assertOk()
            ->assertJsonCount(2, 'data.answers');
    });

    it('存在しない質問は404を返す', function () {
        // GIVEN（質問が存在しない状態）

        // WHEN
        $response = $this->getJson('/api/questions/999');

        // THEN
        $response->assertNotFound();
    });
});

describe('質問投稿 API', function () {
    it('質問を投稿できる', function () {
        // GIVEN
        $user = User::factory()->create();
        $category = Category::factory()->create();

        // WHEN
        $response = $this->postJson('/api/questions', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'テスト質問タイトル',
            'body' => 'テスト質問本文',
        ]);

        // THEN
        $response->assertCreated()
            ->assertJsonPath('data.title', 'テスト質問タイトル');

        $this->assertDatabaseHas('questions', [
            'title' => 'テスト質問タイトル',
        ]);
    });

    it('タイトルなしではバリデーションエラーになる', function () {
        // GIVEN
        $user = User::factory()->create();
        $category = Category::factory()->create();

        // WHEN
        $response = $this->postJson('/api/questions', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'body' => 'テスト質問本文',
        ]);

        // THEN
        $response->assertUnprocessable()
            ->assertJsonValidationErrors('title');
    });

    it('本文なしではバリデーションエラーになる', function () {
        // GIVEN
        $user = User::factory()->create();
        $category = Category::factory()->create();

        // WHEN
        $response = $this->postJson('/api/questions', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'テスト質問タイトル',
        ]);

        // THEN
        $response->assertUnprocessable()
            ->assertJsonValidationErrors('body');
    });
});

describe('質問更新 API', function () {
    it('質問を更新できる', function () {
        // GIVEN
        $question = Question::factory()->create();

        // WHEN
        $response = $this->putJson("/api/questions/{$question->id}", [
            'title' => '更新後タイトル',
            'body' => '更新後本文',
        ]);

        // THEN
        $response->assertOk()
            ->assertJsonPath('data.title', '更新後タイトル');

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'title' => '更新後タイトル',
        ]);
    });
});

describe('質問削除 API', function () {
    it('質問を削除できる', function () {
        // GIVEN
        $question = Question::factory()->create();

        // WHEN
        $response = $this->deleteJson("/api/questions/{$question->id}");

        // THEN
        $response->assertNoContent();

        $this->assertDatabaseMissing('questions', [
            'id' => $question->id,
        ]);
    });
});
