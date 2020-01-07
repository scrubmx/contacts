<?php

namespace Tests\Unit\Http\Controller;

use App\Http\Controllers\ContactController;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_auth_middleware()
    {
        $middleware = (new ContactController)->getMiddleware();

        $this->assertEquals(['middleware' => 'auth', 'options' => []], $middleware[0]);
    }

    /** @test */
    public function store_returns_forbidden_for_non_admin_users()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
             ->post('/contacts')
             ->assertForbidden();
    }

    /** @test */
    public function store_validates_required_fields()
    {
        $user = factory(User::class)->state('admin')->create();

        $this->actingAs($user)
             ->post('/contacts', ['contacts' => null])
             ->assertSessionHasErrors('columns', 'document');
    }

    /** @test */
    public function store_all_the_contacts_in_storage()
    {
        $user = factory(User::class)->state('admin')->create();

        $fileContents = $this->fileContents([
            ['First Name', 'Last Name', 'Email', 'Phone', 'Team', 'Twitter', 'Facebook', 'Time Zone'],
            ['John', 'Doe', 'john@example.com', '5551234567', '123', 'tw_john', 'fb_john', 'UTC'],
            ['Jane', 'Doe', 'jane@example.com', '5554567890', '456', 'tw_jane', 'fb_jane', 'UTC'],
        ]);

        $this->actingAs($user)
             ->post('/contacts', [
                 'document' => $this->fileUpload('contacts.csv', 'text/plain', $fileContents),
                 'columns' => [
                     'first_name' => 'First Name',
                     'last_name' => 'Last Name',
                     'email' => 'Email',
                     'phone' => 'Phone',
                     'team_id' => 'Team',
                     'twitter_id' => 'Twitter',
                     'fb_messenger_id' => 'Facebook',
                     'time_zone' => 'Time Zone',
                 ],
             ])
             ->assertOk();

        $this->assertDatabaseHas('contacts', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '5551234567',
            'team_id' => '123',
            'twitter_id' => 'tw_john',
            'fb_messenger_id' => 'fb_john',
            'time_zone' => 'UTC',
            'unsubscribed_status' => 'none',
        ]);
        $this->assertDatabaseHas('contacts', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'phone' => '5554567890',
            'team_id' => '456',
            'twitter_id' => 'tw_jane',
            'fb_messenger_id' => 'fb_jane',
            'time_zone' => 'UTC',
            'unsubscribed_status' => 'none',
        ]);
    }

    /** @test */
    public function store_can_handle_missing_columns()
    {
        $user = factory(User::class)->state('admin')->create();

        $fileContents = $this->fileContents([
            ['First Name', 'Last Name', 'Email', 'Phone', 'Team', 'Twitter', 'Facebook', 'Time Zone'],
            ['John', 'Doe', 'john@example.com', '5551234567', '123', 'tw_john', 'fb_john', 'UTC'],
            ['Jane', 'Doe', 'jane@example.com', '5554567890', '456', 'tw_jane', 'fb_jane', 'UTC'],
        ]);

        $this->actingAs($user)
            ->post('/contacts', [
                'document' => $this->fileUpload('missing_columns.csv', 'text/plain', $fileContents),
                'columns' => [
                    'first_name' => 'First Name',
                    'phone' => 'Phone',
                    'team_id' => 'Team',
                ],
            ])
            ->assertOk();

        $this->assertDatabaseHas('contacts', [
            'first_name' => 'John',
            'phone' => '5551234567',
            'team_id' => '123',
        ]);
        $this->assertDatabaseHas('contacts', [
            'first_name' => 'Jane',
            'phone' => '5554567890',
            'team_id' => '456',
        ]);
    }

    /** @test */
    public function store_saves_extra_columns_data()
    {
        $user = factory(User::class)->state('admin')->create();

        $fileContents = $this->fileContents([
            ['First Name', 'Phone', 'Team', 'Address', 'Age'],
            ['John', '5551234567', '123', '123 Fake St', '42'],
            ['Jane', '5554567890', '456', '456 Other St', '34'],
        ]);

        $this->actingAs($user)
            ->post('/contacts', [
                'document' => $this->fileUpload('extra_columns.csv', 'text/plain', $fileContents),
                'extra' => [
                    'Address',
                    'Age',
                ],
                'columns' => [
                    'first_name' => 'First Name',
                    'phone' => 'Phone',
                    'team_id' => 'Team',
                ],
            ])
            ->assertOk();

        $this->assertDatabaseHas('contacts', ['first_name' => 'John', 'phone' => '5551234567', 'team_id' => '123']);
        $this->assertDatabaseHas('custom_attributes', ['key' => 'address', 'value' => '123 Fake St']);
        $this->assertDatabaseHas('custom_attributes', ['key' => 'age', 'value' => '42']);

        $this->assertDatabaseHas('contacts', ['first_name' => 'Jane', 'phone' => '5554567890', 'team_id' => '456']);
        $this->assertDatabaseHas('custom_attributes', ['key' => 'address', 'value' => '456 Other St']);
        $this->assertDatabaseHas('custom_attributes', ['key' => 'age', 'value' => '34']);
    }


    /**
     * Convert an array into a comma separated values (CSV) string.
     *
     * @param  array  $rows
     * @return string
     */
    protected function fileContents(array $rows = []) : string
    {
        return collect($rows)->map(fn($row) => join(', ', $row))->join("\n");
    }

    /**
     * Return an instance of a uploaded file.
     *
     * @param  string  $name
     * @param  string  $mime ['text/plain', 'application/vnd.ms-excel']
     * @param  string|null  $contents
     * @return \Illuminate\Http\UploadedFile
     */
    protected function fileUpload($name, $mime = 'text/plain', ?string $contents = null) : UploadedFile
    {
        $path = sys_get_temp_dir().DIRECTORY_SEPARATOR.ltrim($name, DIRECTORY_SEPARATOR);

        file_put_contents($path, $contents);

        register_shutdown_function(fn() => unlink($path));

        return new UploadedFile($path, $name, $mime, UPLOAD_ERR_OK, $test = true);
    }
}
