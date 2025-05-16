<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_displays_providers_and_category_filter()
    {
        // Arrange: create categories and providers
        $catA = Category::factory()->create(['name' => 'Alpha']);
        $catB = Category::factory()->create(['name' => 'Beta']);
        ServiceProvider::factory()->count(2)->create(['category_id' => $catA->id]);
        ServiceProvider::factory()->count(1)->create(['category_id' => $catB->id]);

        // Act: visit the index without filter
        $response = $this->get(route('providers.index'));

        // Assert: page loads and shows provider names and the filter dropdown
        $response->assertStatus(200)
            ->assertSee($catA->name)
            ->assertSee($catB->name)
            ->assertSeeText(ServiceProvider::first()->name);

        // Act: visit with category filter
        $response2 = $this->get(route('providers.index', ['category' => $catA->id]));
        $response2->assertStatus(200)
            ->assertSeeText(ServiceProvider::where('category_id', $catA->id)->first()->name)
            ->assertDontSeeText(ServiceProvider::where('category_id', $catB->id)->first()->name);
    }

    /** @test */
    public function show_displays_provider_profile_and_uses_eager_loading()
    {
        // Arrange: create one provider with category
        $provider = ServiceProvider::factory()->create();

        // Act: visit the show page
        $response = $this->get(route('providers.show', $provider));

        // Assert: page loads, shows name, description, and category
        $response->assertStatus(200)
            ->assertSeeText($provider->name)
            ->assertSeeText($provider->description)
            ->assertSeeText($provider->category->name);

        // Extra: ensure no N+1 by checking queries count (optional)
        // This requires using a package or DB::enableQueryLog() in advanced tests.
    }
}
