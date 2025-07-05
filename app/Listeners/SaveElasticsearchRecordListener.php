<?php

namespace App\Listeners;

use App\Interfaces\Events\SaveElasticsearchEventInterface;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;
use Illuminate\Queue\InteractsWithQueue;

class SaveElasticsearchRecordListener implements ShouldQueueAfterCommit
{
    use InteractsWithQueue;

    public int $tries = 5;

    public function handle(SaveElasticsearchEventInterface $event): void
    {
        $record = $event->getRecord();

        $record->elasticSearchModel()->save();
    }

    public function backoff(): array
    {
        return [1, 5, 10];
    }
}
