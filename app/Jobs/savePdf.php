<?php

namespace App\Jobs;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class savePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pdf = Pdf::loadView('pdf.parsedFile', ['item' => $this->data]);
        $pdf->set_paper("S", 'landscape');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->set_opacity(.2,"Multiply");
        $canvas->image(
            Storage::disk("public")->path("images/sbase-logo.png"),
            $canvas->get_width()/2,
            $canvas->get_height()/2,
            200,
            200
        );
        Storage::disk("public")->put("pdf/".$this->data["File"], $pdf->output());
    }
}
