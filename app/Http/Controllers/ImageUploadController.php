<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

use Illuminate\Http\Request;
use function Pest\Laravel\json;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class ImageUploadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function upload(Request $request): JsonResponse
    {

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('blog-images'), $imageName);

            $imageUrl = asset('blog-images/' . $imageName);

            return response()->json(['url' => $imageUrl], 200);
        }

        return response()->json(['error' => 'File not found'], 404);
    }

    public function delete(Request $request)
    {
        // Ambil URL gambar yang akan dihapus dari permintaan
        $urls = $request->input('url');

        foreach ($urls as $imageUrl) {
            // Ubah URL gambar menjadi path lokal
            $imagePath = public_path('blog-images/') . basename($imageUrl);

            // Hapus file gambar dari server jika ada
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        return response()->json(['message' => 'Gambar berhasil dihapus dari server.']);
    }
}
