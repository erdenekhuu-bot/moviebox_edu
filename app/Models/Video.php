<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use AchyutN\LaravelHLS\Traits\ConvertsToHLS;
class Video extends Model
{
    use ConvertsToHLS;
    private string $videoColumn = 'original_video';
    private string $hlsColumn = 'hls_output';
    private string $progressColumn = 'conversion_percent';
    private string $videoDisk = 'videos';
    private string $hlsDisk = 'hls-outputs';
    private string $secretsDisk = 'secure';
    private string $hlsOutputPath = 'streamed/hls';
    private string $hlsSecretsOutputPath = 'streamed/secrets';
    private string $tempStorageOutputPath = 'tmp';
}
