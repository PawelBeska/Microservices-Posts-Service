<?php

namespace App\Listeners;

use App\Interfaces\Events\DeleteElasticsearchEventInterface;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;
use Illuminate\Queue\InteractsWithQueue;

class DeleteElasticsearchRecordListener implements ShouldQueueAfterCommit
{
    use InteractsWithQueue;

    public int $tries = 3;


    public function handle(DeleteElasticsearchEventInterface $event): void
    {
    }

    public function backoff(): array
    {
        return [1, 5, 10];
    }
}
