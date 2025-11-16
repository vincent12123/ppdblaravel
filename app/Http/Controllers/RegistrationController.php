<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Document;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    public function create()
    {
        // Ambil semua jurusan untuk pilihan
        $majors = Major::all();
        return view('registration.create', compact('majors'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|max:10|unique:applicants,nisn',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:15',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:15',
            'address' => 'required|string',
            'origin_school' => 'required|string|max:255',
            'major_choice_1' => 'required|exists:majors,id',
            'major_choice_2' => 'nullable|exists:majors,id|different:major_choice_1',
            'major_choice_3' => 'nullable|exists:majors,id|different:major_choice_1,major_choice_2',

            // Dokumen (semua opsional)
            'photo' => 'nullable|image|max:2048',
            'ijazah' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_keluarga' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta_kelahiran' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'rapor' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Generate nomor registrasi
            $registrationNumber = Applicant::generateRegistrationNumber();

            // Simpan data pendaftar
            $applicant = Applicant::create([
                'registration_number' => $registrationNumber,
                'name' => $validated['name'],
                'nisn' => $validated['nisn'],
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'],
                'parent_name' => $validated['parent_name'],
                'parent_phone' => $validated['parent_phone'],
                'address' => $validated['address'],
                'origin_school' => $validated['origin_school'],
                'major_choice_1' => $validated['major_choice_1'],
                'major_choice_2' => $validated['major_choice_2'] ?? null,
                'major_choice_3' => $validated['major_choice_3'] ?? null,
                'status' => 'registered',
                'registered_at' => now(),
            ]);

            // Upload dan simpan dokumen
            $documentTypes = [
                'photo' => 'foto',
                'ijazah' => 'ijazah',
                'kartu_keluarga' => 'kartu_keluarga',
                'akta_kelahiran' => 'akta_kelahiran',
                'rapor' => 'rapor',
            ];

            foreach ($documentTypes as $field => $type) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $path = $file->store('ppdb_documents', 'public');

                    Document::create([
                        'applicant_id' => $applicant->id,
                        'type' => $type,
                        'file_path' => $path,
                        'is_verified' => false,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('registration.success', ['registration_number' => $registrationNumber]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function success($registration_number)
    {
        $applicant = Applicant::where('registration_number', $registration_number)->firstOrFail();
        return view('registration.success', compact('applicant'));
    }

    public function checkStatus()
    {
        return view('registration.check-status');
    }

    public function showStatus(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string',
        ]);

        $applicant = Applicant::where('registration_number', $request->registration_number)
            ->with(['majorChoice1', 'majorChoice2', 'majorChoice3', 'assignedMajor', 'documents'])
            ->first();

        if (!$applicant) {
            return back()->withErrors(['registration_number' => 'Nomor registrasi tidak ditemukan.']);
        }

        return view('registration.status', compact('applicant'));
    }

    public function checkStatusApi(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string',
        ]);

        $applicant = Applicant::where('registration_number', $request->registration_number)
            ->with(['majorChoice1', 'majorChoice2', 'majorChoice3', 'assignedMajor'])
            ->first();

        if (!$applicant) {
            return response()->json([
                'error' => true,
                'message' => 'Nomor registrasi tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'error' => false,
            'registration_number' => $applicant->registration_number,
            'name' => $applicant->name,
            'status' => $applicant->status,
            'assigned_major' => $applicant->assignedMajor ? $applicant->assignedMajor->name : null,
            'registered_at' => $applicant->registered_at->format('d F Y, H:i'),
        ]);
    }
}
