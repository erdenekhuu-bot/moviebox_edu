<?php

namespace App\Traits;

use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Storage;

trait ConvertsToHLS
{
    public function convertToHLS(): void
    {
        $inputPath = Storage::disk($this->videoDisk)->path($this->{$this->videoColumn});
        $outputDir = "{$this->hlsOutputPath}/{$this->id}";
        $outputFullPath = Storage::disk($this->hlsDisk)->path($outputDir);


        Storage::disk($this->hlsDisk)->makeDirectory($outputDir);

        FFMpeg::fromDisk($this->videoDisk)
            ->open($this->{$this->videoColumn})
            ->exportForHLS()
            ->addFormat(\FFMpeg::X264()->setKiloBitrate(500))
            ->addFormat(\FFMpeg::X264()->setKiloBitrate(1000))
            ->addFormat(\FFMpeg::X264()->setKiloBitrate(1500))
            ->onProgress(function ($percentage) {
                $this->update([$this->progressColumn => $percentage]);
            })
            ->toDisk($this->hlsDisk)
            ->save("$outputDir/master.m3u8");

        $this->update([
            $this->hlsColumn => "$outputDir/master.m3u8",
            $this->progressColumn => 100,
        ]);
    }
}
