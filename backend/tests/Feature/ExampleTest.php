<?php

it('トップページが正常に表示される', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
