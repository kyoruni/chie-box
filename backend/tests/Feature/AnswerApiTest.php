<?php

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;

describe('回答投稿 API', function () {
    it('回答を投稿できる', function () {
        // GIVEN
        $question = Question::factory()->create();
        $user = User::factory()->create();

        // WHEN
        $response = $this->postJson("/api/questions/{$question->id}/answers", [
            'user_id' => $user->id,
            'body' => 'テスト回答本文',
        ]);

        // THEN
        $response->assertCreated()
            ->assertJsonPath('data.body', 'テスト回答本文');

        $this->assertDatabaseHas('answers', [
            'question_id' => $question->id,
            'user_id' => $user->id,
            'body' => 'テスト回答本文',
        ]);
    });

    it('本文なしではバリデーションエラーになる', function () {
        // GIVEN
        $question = Question::factory()->create();
        $user = User::factory()->create();

        // WHEN
        $response = $this->postJson("/api/questions/{$question->id}/answers", [
            'user_id' => $user->id,
        ]);

        // THEN
        $response->assertUnprocessable()
            ->assertJsonValidationErrors('body');
    });

    it('ユーザーIDなしではバリデーションエラーになる', function () {
        // GIVEN
        $question = Question::factory()->create();

        // WHEN
        $response = $this->postJson("/api/questions/{$question->id}/answers", [
            'body' => 'テスト回答本文',
        ]);

        // THEN
        $response->assertUnprocessable()
            ->assertJsonValidationErrors('user_id');
    });

    it('存在しない質問には回答できない', function () {
        // GIVEN
        $user = User::factory()->create();

        // WHEN
        $response = $this->postJson('/api/questions/999/answers', [
            'user_id' => $user->id,
            'body' => 'テスト回答本文',
        ]);

        // THEN
        $response->assertNotFound();
    });
});

describe('回答更新 API', function () {
    it('回答を更新できる', function () {
        // GIVEN
        $answer = Answer::factory()->create(['body' => '更新前の本文']);

        // WHEN
        $response = $this->putJson("/api/answers/{$answer->id}", [
            'body' => '更新後の本文',
        ]);

        // THEN
        $response->assertOk()
            ->assertJsonPath('data.body', '更新後の本文');

        $this->assertDatabaseHas('answers', [
            'id' => $answer->id,
            'body' => '更新後の本文',
        ]);
    });

    it('存在しない回答の更新は404を返す', function () {
        // GIVEN（回答が存在しない状態）

        // WHEN
        $response = $this->putJson('/api/answers/999', [
            'body' => '更新後の本文',
        ]);

        // THEN
        $response->assertNotFound();
    });
});

describe('回答削除 API', function () {
    it('回答を削除できる', function () {
        // GIVEN
        $answer = Answer::factory()->create();

        // WHEN
        $response = $this->deleteJson("/api/answers/{$answer->id}");

        // THEN
        $response->assertNoContent();

        $this->assertDatabaseMissing('answers', [
            'id' => $answer->id,
        ]);
    });

    it('存在しない回答の削除は404を返す', function () {
        // GIVEN（回答が存在しない状態）

        // WHEN
        $response = $this->deleteJson('/api/answers/999');

        // THEN
        $response->assertNotFound();
    });
});
