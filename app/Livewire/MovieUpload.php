<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;
use AchyutN\LaravelHls\VideoProcessor;


class MovieUpload extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $rating = 1;
    public $video;
    public $thumbnail;
    public $progress = 0;
    public $isUploading = false;
    public $uploadComplete = false;
    public $movieId;

    protected $rules = [
        'title' => 'required|string|max:16777215', // mediumText хэмжээ
        'description' => 'nullable|string|max:16777215', // mediumText хэмжээ
        'rating' => 'required|integer|min:1|max:5',
        'video' => 'required|mimes:mp4,mov,avi|max:51200', // 50MB
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ];

    protected $messages = [
        'title.required' => 'Киноны нэрийг оруулах шаардлагатай',
        'title.max' => 'Киноны нэр хэт урт байна',
        'description.max' => 'Тайлбар хэт урт байна',
        'rating.min' => 'Үнэлгээ 1-ээс бага байж болохгүй',
        'rating.max' => 'Үнэлгээ 5-аас их байж болохгүй',
        'video.required' => 'Видео файл оруулах шаардлагатай',
        'video.mimes' => 'Зөвхөн MP4, MOV, AVI форматын файл оруулна уу',
        'video.max' => 'Видео файлын хэмжээ 50MB-аас ихгүй байх ёстой',
        'thumbnail.image' => 'Зургийн файл оруулна уу',
        'thumbnail.mimes' => 'Зөвхөн JPG, JPEG, PNG форматын зураг оруулна уу',
        'thumbnail.max' => 'Зургийн хэмжээ 2MB-аас ихгүй байх ёстой'
    ];

    public function render()
    {
        return view('livewire.movie-upload');
    }

    public function save()
    {
        $this->validate();
        $this->isUploading = true;
        $this->progress = 10;

        try {
            // Видео файлыг хадгалах
            $videoPath = $this->video->store('movies/original', 'public');
            $this->progress = 30;

            // Thumbnail хадгалах
            $thumbnailPath = null;
            if ($this->thumbnail) {
                $thumbnailPath = $this->thumbnail->store('movies/thumbnails', 'public');
            }
            $this->progress = 50;

            // Database-д бүртгэх
            $movie = Movie::create([
                'title' => $this->title,
                'description' => $this->description,
                'rating' => $this->rating,
                'original_file_path' => $videoPath,
                'thumbnail_path' => $thumbnailPath,
                'status' => 'pending'
            ]);

            $this->movieId = $movie->id;
            $this->progress = 70;

            // HLS processing queue-руу илгээх
            dispatch(function () use ($movie) {
                $this->processMovie($movie);
            });

            $this->progress = 100;
            $this->uploadComplete = true;

            session()->flash('message', 'Кино амжилттай орууллаа! Тун удахгүй боловсруулагдана.');

        } catch (\Exception $e) {
            $this->isUploading = false;
            session()->flash('error', 'Алдаа гарлаа: ' . $e->getMessage());
        }
    }

    private function processMovie(Movie $movie)
    {
        try {
            $movie->update(['status' => 'processing']);

            $processor = new VideoProcessor();

            // HLS хөрвүүлэлт
            $hlsPath = $processor->processVideo(
                Storage::disk('public')->path($movie->original_file_path),
                'movies/hls/' . $movie->id
            );

            // Automat thumbnail үүсгэх
            if (!$movie->thumbnail_path) {
                $thumbnailPath = $processor->generateThumbnail(
                    Storage::disk('public')->path($movie->original_file_path),
                    'movies/thumbnails/' . $movie->id . '.jpg'
                );
            }

            // Duration тодорхойлох
            $duration = $processor->getDuration(
                Storage::disk('public')->path($movie->original_file_path)
            );

            // Мэдээллийг шинэчлэх
            $movie->update([
                'hls_path' => $hlsPath,
                'thumbnail_path' => $thumbnailPath ?? $movie->thumbnail_path,
                'duration' => $duration,
                'status' => 'completed',
                'qualities' => $processor->getQualities() ?? []
            ]);

        } catch (\Exception $e) {
            $movie->update(['status' => 'failed']);
            logger()->error('Movie processing failed: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'title',
            'description',
            'rating',
            'video',
            'thumbnail',
            'progress',
            'isUploading',
            'uploadComplete',
            'movieId'
        ]);

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
