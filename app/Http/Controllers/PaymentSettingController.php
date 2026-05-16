<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentSettingController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $settings = PaymentSetting::firstOrNew();

        $settings->bank_name = $validated['bank_name'] ?? null;
        $settings->account_number = $validated['account_number'] ?? null;
        $settings->account_name = $validated['account_name'] ?? null;

        if ($request->hasFile('qris_image')) {
            if ($settings->qris_path) {
                Storage::disk('public')->delete($settings->qris_path);
            }
            $settings->qris_path = $request->file('qris_image')->store('payment', 'public');
        }

        $settings->save();

        return redirect('/admin')->with('success', 'Pengaturan pembayaran berhasil disimpan.');
    }
}
