<?php

namespace App\Jobs;

use App\Encuesta;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RestaurarEncuesta extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $encuesta;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Encuesta $encuesta)
    {
        $this->encuesta = $encuesta;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Encuesta $encuesta)
    {
        dd($this->encuesta);
        $this->encuesta->restore();
    }
}
