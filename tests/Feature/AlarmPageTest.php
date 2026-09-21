<?php

namespace Tests\Feature;

use Tests\TestCase;

class AlarmPageTest extends TestCase
{
    public function test_home_page_returns_ok(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertSee('Portal Notifikasi Alarm')
            ->assertSee('Laboratorium')
            ->assertSee('Radiologi')
            ->assertSee('Farmasi / Apotek');
    }

    public function test_lab_page_returns_ok(): void
    {
        $response = $this->get('/lab');
        $response->assertStatus(200)
            ->assertSee('Lab')
            ->assertSee('Mode Alarm');
    }

    public function test_radiologi_page_returns_ok(): void
    {
        $response = $this->get('/radiologi');
        $response->assertStatus(200)
            ->assertSee('Radiologi');
    }

    public function test_apotek_page_returns_ok(): void
    {
        $response = $this->get('/apotek');
        $response->assertStatus(200)
            ->assertSee('Apotek');
    }

    public function test_invalid_unit_returns_404(): void
    {
        $response = $this->get('/non-existent-unit');
        $response->assertStatus(404);
    }
}
