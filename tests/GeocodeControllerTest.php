<?php

namespace Wingly\GooglePlaces\Tests;

class GeocodeControllerTest extends TestCase
{
    public function test_it_returns_predictions_for_an_input()
    {
        $response = $this->getJson('/geocode?input=Antwerp');

        $response->assertOk();

        $this->assertIsArray($response->json());

        $this->assertArrayHasKey('lat', $response->json());
        $this->assertArrayHasKey('lng', $response->json());
    }

    public function test_it_returns_empty_array_for_an_empty_input()
    {
        $response = $this->getJson('/geocode?input=');

        $response->assertOk();

        $this->assertEquals([], $response->json());
    }

    public function test_it_escapes_non_utf8_chars_in_the_input()
    {
        $response = $this->getJson('/geocode?input=Antwerp%C2%B4%08');

        $response->assertOk();

        $this->assertIsArray($response->json());

        $this->assertArrayHasKey('lat', $response->json());
        $this->assertArrayHasKey('lng', $response->json());
    }

    public function test_it_returns_empty_array_when_called_without_input()
    {
        $response = $this->getJson('/geocode');

        $response->assertOk();

        $this->assertEquals([], $response->json());
    }
}
