@extends('landing.layout')

@section('title', 'Formulir Pendaftaran - PPDB Online SMK')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Formulir Pendaftaran PPDB</h1>
        <p class="text-lg text-indigo-100">Isi data dengan lengkap dan benar</p>
    </div>
</section>

<!-- Registration Form -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">

            <!-- Alert Errors -->
            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-xl mr-3 mt-1"></i>
                    <div>
                        <strong class="font-bold">Terjadi Kesalahan!</strong>
                        <ul class="list-disc list-inside mt-2">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Section 1: Data Pribadi -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3">1</span>
                        Data Pribadi
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Masukkan nama lengkap sesuai ijazah">
                        </div>

                        <!-- NISN -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                NISN <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nisn" value="{{ old('nisn') }}" required maxlength="10"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="10 digit NISN">
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select name="gender" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <!-- Asal Sekolah -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Asal Sekolah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="origin_school" value="{{ old('origin_school') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Nama SMP/MTs">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Kontak & Alamat -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3">2</span>
                        Kontak & Alamat
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="contoh@email.com">
                        </div>

                        <!-- No. HP -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Nomor HP/WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required maxlength="15"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="08xxxxxxxxxx">
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Pilihan Jurusan -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3">3</span>
                        Pilihan Jurusan
                    </h2>

                    <div class="space-y-6">
                        <!-- Pilihan 1 -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Pilihan Jurusan 1 <span class="text-red-500">*</span>
                            </label>
                            <select name="major_choice_1" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Pilih Jurusan Prioritas 1</option>
                                @foreach($majors as $major)
                                <option value="{{ $major->id }}" {{ old('major_choice_1') == $major->id ? 'selected' : '' }}>
                                    {{ $major->name }} (Kuota: {{ $major->quota }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pilihan 2 -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Pilihan Jurusan 2 (Opsional)
                            </label>
                            <select name="major_choice_2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Pilih Jurusan Prioritas 2 (jika ada)</option>
                                @foreach($majors as $major)
                                <option value="{{ $major->id }}" {{ old('major_choice_2') == $major->id ? 'selected' : '' }}>
                                    {{ $major->name }} (Kuota: {{ $major->quota }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pilihan 3 -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Pilihan Jurusan 3 (Opsional)
                            </label>
                            <select name="major_choice_3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Pilih Jurusan Prioritas 3 (jika ada)</option>
                                @foreach($majors as $major)
                                <option value="{{ $major->id }}" {{ old('major_choice_3') == $major->id ? 'selected' : '' }}>
                                    {{ $major->name }} (Kuota: {{ $major->quota }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Rata-rata Rapor -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Rata-rata Nilai Rapor (Opsional)
                            </label>
                            <input type="number" name="rapor_average" value="{{ old('rapor_average') }}" step="0.01" min="0" max="100"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Contoh: 85.5">
                            <p class="text-sm text-gray-500 mt-1">Rata-rata nilai rapor semester 1-5</p>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Upload Dokumen -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3">4</span>
                        Upload Dokumen
                    </h2>

                    <div class="space-y-6">
                        <!-- Pas Foto -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Pas Foto 3x4 <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="photo" required accept="image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Max 2MB</p>
                        </div>

                        <!-- Ijazah -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Ijazah/STTB SMP <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="ijazah" required accept=".pdf,image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Format: PDF, JPG, PNG. Max 2MB</p>
                        </div>

                        <!-- Kartu Keluarga -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Kartu Keluarga (KK) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="kartu_keluarga" required accept=".pdf,image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Format: PDF, JPG, PNG. Max 2MB</p>
                        </div>

                        <!-- Akta Kelahiran -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Akta Kelahiran (Opsional)
                            </label>
                            <input type="file" name="akta_kelahiran" accept=".pdf,image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Format: PDF, JPG, PNG. Max 2MB</p>
                        </div>

                        <!-- Rapor -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Rapor Semester 1-5 (Opsional)
                            </label>
                            <input type="file" name="rapor" accept=".pdf,image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Format: PDF, JPG, PNG. Max 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Persetujuan -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-start">
                        <input type="checkbox" id="agreement" required
                            class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 mt-1">
                        <label for="agreement" class="ml-3 text-gray-700">
                            Saya menyatakan bahwa data yang saya isi adalah <strong>benar dan dapat dipertanggungjawabkan</strong>.
                            Saya bersedia menerima sanksi apabila data yang saya berikan tidak sesuai dengan fakta.
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('landing') }}" class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                    </a>
                    <button type="submit"
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-12 py-4 rounded-lg font-bold text-lg hover:shadow-2xl transition transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Pendaftaran
                    </button>
                </div>

            </form>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Validasi pilihan jurusan tidak boleh sama
    document.querySelectorAll('[name^="major_choice"]').forEach(select => {
        select.addEventListener('change', function() {
            const choice1 = document.querySelector('[name="major_choice_1"]').value;
            const choice2 = document.querySelector('[name="major_choice_2"]').value;
            const choice3 = document.querySelector('[name="major_choice_3"]').value;

            if (choice1 && choice2 && choice1 === choice2) {
                alert('Pilihan jurusan 2 tidak boleh sama dengan pilihan 1');
                document.querySelector('[name="major_choice_2"]').value = '';
            }

            if (choice1 && choice3 && choice1 === choice3) {
                alert('Pilihan jurusan 3 tidak boleh sama dengan pilihan 1');
                document.querySelector('[name="major_choice_3"]').value = '';
            }

            if (choice2 && choice3 && choice2 === choice3) {
                alert('Pilihan jurusan 3 tidak boleh sama dengan pilihan 2');
                document.querySelector('[name="major_choice_3"]').value = '';
            }
        });
    });

    // Validasi ukuran file
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const maxSize = 2 * 1024 * 1024; // 2MB
            if (this.files[0] && this.files[0].size > maxSize) {
                alert('Ukuran file maksimal 2MB');
                this.value = '';
            }
        });
    });
</script>
@endpush
