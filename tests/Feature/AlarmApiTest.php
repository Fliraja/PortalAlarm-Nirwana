<?php

namespace Tests\Feature;

use Tests\TestCase;

class AlarmApiTest extends TestCase
{
    public function test_poll_with_invalid_unit_returns_404(): void
    {
        $response = $this->getJson('/api/alarm/unknown/poll');
        $response->assertStatus(404);
    }

    public function test_poll_lab_returns_valid_json_structure(): void
    {
        $response = $this->getJson('/api/alarm/lab/poll');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'unit',
                'polled_at',
                'active',
            ]);
    }

    public function test_poll_radiologi_returns_valid_json_structure(): void
    {
        $response = $this->getJson('/api/alarm/radiologi/poll');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'unit',
                'polled_at',
                'active',
            ]);
    }

    public function test_poll_apotek_returns_valid_json_structure(): void
    {
        $response = $this->getJson('/api/alarm/apotek/poll');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'unit',
                'polled_at',
                'active',
            ]);
    }

    public function test_ack_nonexistent_alarm_returns_404(): void
    {
        $response = $this->postJson('/api/alarm/99999999/ack');
        $response->assertStatus(404);
    }

    public function test_ack_existing_alarm_updates_waktu_ack_idempotently(): void
    {
        $alarm = \App\Models\AlarmLog::create([
            'jenis' => 'lab',
            'kode_permintaan' => 'TEST_ACK_001',
            'no_rawat' => '2026/09/21/0001',
            'waktu_terdeteksi' => now(),
        ]);

        $response = $this->postJson("/api/alarm/{$alarm->id}/ack");
        $response->assertStatus(200)
            ->assertJson(['success' => true, 'id' => $alarm->id]);

        $alarm->refresh();
        $this->assertNotNull($alarm->waktu_ack);

        // Idempotent test: call again
        $response2 = $this->postJson("/api/alarm/{$alarm->id}/ack");
        $response2->assertStatus(200)
            ->assertJson(['success' => true]);

        // Cleanup
        $alarm->delete();
    }
}
