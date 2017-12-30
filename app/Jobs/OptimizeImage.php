<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use ImageOptimizer;
use File;

class OptimizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $image_path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image_path)
    {
        $this->image_path = $image_path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ImageOptimizer::optimize(public_path($this->image_path));
    }
}
