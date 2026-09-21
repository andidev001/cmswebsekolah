<?php

namespace Tests\Feature;

use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    /**
     * Test that security headers are applied to public pages.
     */
    public function test_security_headers_are_present_on_home_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    /**
     * Test rate limiting on login POST.
     */
    public function test_login_post_rate_limiting(): void
    {
        // We perform 5 requests within the limit
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/login', [
                'username' => 'wronguser',
                'password' => 'wrongpass',
            ]);
            // It should not be 429 Too Many Requests yet
            $this->assertNotEquals(429, $response->getStatusCode());
        }

        // The 6th request should trigger 429 Too Many Requests
        $response = $this->post('/login', [
            'username' => 'wronguser',
            'password' => 'wrongpass',
        ]);
        $response->assertStatus(429);
    }

    /**
     * Test rate limiting on message submission POST.
     */
    public function test_hubungi_kirim_post_rate_limiting(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/hubungi/kirim', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'subject' => 'Test Subject',
                'message' => 'Test message content here...',
            ]);
            $this->assertNotEquals(429, $response->getStatusCode());
        }

        $response = $this->post('/hubungi/kirim', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test message content here...',
        ]);
        $response->assertStatus(429);
    }
}
