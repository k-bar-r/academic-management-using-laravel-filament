<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Mark;
use Illuminate\Http\Request;

class ExamMarkController extends Controller
{
    public function update(Request $request, Exam $exam)
    {
        // Debug untuk melihat data yang dikirim
        dd($request->all()); // Uncomment untuk debug
        
        $request->validate([
            'marks' => 'required|array',
            'marks.*' => 'numeric|min:0|max:100',
        ]);

        foreach ($request->marks as $markId => $value) {
            Mark::where('id', $markId)
                ->where('exam_id', $exam->id)
                ->update(['mark' => $value]);
        }

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Marks updated successfully!');
    }
}
