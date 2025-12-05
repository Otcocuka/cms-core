<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Content\Models\Page;

class TestEventBus extends Command
{
    protected $signature = 'test:eventbus';
    protected $description = 'Test Event Bus system';

    public function handle()
    {
        $this->info('Testing Event Bus...');

        // Создание страницы
        $this->info('Creating page...');
        $page = Page::create([
            'title' => 'Test Event Page',
            'slug' => 'test-event-page-' . time(),
            'content' => 'Test content',
            'status' => 'draft',
        ]);
        $this->info("✓ Page created: {$page->id}");

        // Обновление страницы
        $this->info('Updating page...');
        $page->update([
            'title' => 'Updated Test Event Page',
            'status' => 'published',
            'published_at' => now(),
        ]);
        $this->info("✓ Page updated and published");

        // Удаление страницы
        $this->info('Deleting page...');
        $page->delete();
        $this->info("✓ Page deleted");

        $this->info('');
        $this->info('Check logs: storage/logs/laravel.log');
        $this->info('You should see:');
        $this->info('  - [EventBus] page.created');
        $this->info('  - [Content] page.created');
        $this->info('  - [EventBus] page.updated');
        $this->info('  - [EventBus] page.published');
        $this->info('  - [Content] page.updated');
        $this->info('  - [Content] page.published');
        $this->info('  - [EventBus] page.deleted');
        $this->info('  - [Content] page.deleted');

        return Command::SUCCESS;
    }
}
