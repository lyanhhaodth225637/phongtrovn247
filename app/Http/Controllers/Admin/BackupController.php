<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class BackupController extends Controller
{
    public function index()
    {
        $path = Storage::disk('backup')->path(config('backup.backup.name'));

        $files = File::exists($path)
            ? collect(File::allFiles($path))
                ->filter(fn($file) => in_array(strtolower($file->getExtension()), ['zip', 'sql'], true))
                ->sortByDesc(fn($file) => $file->getCTime())
                ->values()
            : collect();

        return view('admin.backup.index', compact('files'));
    }

    public function run()
    {
        try {
            Config::set(
                'backup.backup.temporary_directory',
                storage_path('app/backup-temp/' . Str::uuid())
            );

            $exitCode = Artisan::call('backup:run');
            $output = trim(Artisan::output());

            if ($exitCode !== 0) {
                return back()->with('error', $output ?: 'Tạo backup thất bại.');
            }

            return back()->with('success', $output ?: 'Đã tạo bản sao lưu thành công.');
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage());
        }
    }

    public function clean()
    {
        try {
            Artisan::call('backup:clean');

            return back()->with('success', 'Đã xóa các bản sao lưu cũ.');
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $this->formatExceptionMessage($e));
        }
    }

    public function download($file): BinaryFileResponse
    {
        $basePath = Storage::disk('backup')->path('');
        $path = collect(File::allFiles($basePath))
            ->first(fn($candidate) => $candidate->getFilename() === $file)
                ?->getRealPath();

        abort_unless($path && File::exists($path), 404);

        return response()->download($path);
    }

    protected function formatExceptionMessage(Throwable $e): string
    {
        $message = trim($e->getMessage());

        return $message !== '' ? $message : 'Khong the thuc hien backup.';
    }
}
