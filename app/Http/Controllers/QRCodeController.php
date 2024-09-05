<?php

namespace App\Http\Controllers;

use App\Models\QRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QRCodeController extends Controller
{
    // Display the list of QR codes
    // Display the list of QR codes
    public function index() {
        $qrcodes = QRCode::all();
        return view('qrcode.index', compact('qrcodes'));
    }

    // Store a new QR code
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'qrcode_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Menyimpan gambar ke disk 'public'
    if ($request->hasFile('qrcode_image')) {
        $imagePath = $request->file('qrcode_image')->store('qrcodes', 'public');
    }

    // Simpan path gambar ke database
    QRCode::create([
        'image_path' => $imagePath,
    ]);

    return redirect()->route('qrcode.index')->with('success', 'QR Code added successfully.');
}


    // Update an existing QR code
    public function update(Request $request, $id) {
        $request->validate([
            'qrcode_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $qrcode = QRCode::findOrFail($id);

        if ($request->hasFile('qrcode_image')) {
            // Delete old image
            Storage::disk('public')->delete($qrcode->image_path);

            // Store new image
            $imagePath = $request->file('qrcode_image')->store('qrcodes', 'public');
            $qrcode->update(['image_path' => $imagePath]);
        }

        return redirect()->route('qrcode.index')->with('success', 'QR Code updated successfully.');
    }


    // Delete a QR code
    public function destroy($id) {
        $qrcode = QRCode::findOrFail($id);

        // Delete the image file
        Storage::disk('public')->delete($qrcode->image_path);

        $qrcode->delete();

        return redirect()->route('qrcode.index')->with('success', 'QR Code deleted successfully.');
    }
}
