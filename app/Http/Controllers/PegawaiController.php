<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PegawaiController extends Controller
{
    /**
     * Tampilkan daftar data pegawai dengan pencarian, filter, dan pagination.
     */
    public function index(Request $request): View
    {
        $query = Pegawai::query();

        // Pencarian berdasarkan Nama, NIP, Jabatan, atau Email
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter Jenis Kelamin
        if ($gender = $request->input('jenis_kelamin')) {
            if (in_array($gender, ['Laki-laki', 'Perempuan'])) {
                $query->where('jenis_kelamin', $gender);
            }
        }

        // Filter Pendidikan Terakhir
        if ($edu = $request->input('pendidikan_terakhir')) {
            $validPendidikan = ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3'];
            if (in_array($edu, $validPendidikan)) {
                $query->where('pendidikan_terakhir', $edu);
            }
        }

        // Sorting
        $allowedSorts = ['nama', 'nip', 'tanggal_lahir', 'created_at', 'jabatan', 'pendidikan_terakhir'];
        $sort = in_array($request->input('sort'), $allowedSorts) ? $request->input('sort') : 'created_at';
        $order = strtolower($request->input('order')) === 'asc' ? 'asc' : 'desc';

        $pegawaiList = $query->orderBy($sort, $order)->paginate(10)->withQueryString();

        $jenjangPendidikan = ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3'];

        return view('pegawai.index', compact('pegawaiList', 'jenjangPendidikan', 'sort', 'order'));
    }

    /**
     * Tampilkan formulir penambahan data pegawai baru.
     */
    public function create(): View
    {
        $jenjangPendidikan = ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3'];

        return view('pegawai.create', compact('jenjangPendidikan'));
    }

    /**
     * Simpan data pegawai baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'nip' => ['nullable', 'string', 'max:30', 'unique:pegawais,nip'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'pendidikan_terakhir' => ['required', 'in:SD,SMP,SMA/SMK,D3,S1,S2,S3'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:100', 'unique:pegawais,email'],
            'telepon' => ['nullable', 'string', 'max:25'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [
            'nama.required' => 'Nama pegawai wajib diisi.',
            'nama.max' => 'Nama pegawai maksimal 150 karakter.',
            'nip.unique' => 'NIP sudah terdaftar untuk pegawai lain.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib dipilih.',
            'pendidikan_terakhir.in' => 'Pilihan pendidikan terakhir tidak valid.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pegawai lain.',
        ]);

        // Auto-generate NIP jika tidak diisi secara manual
        if (empty($validated['nip'])) {
            $birthDateFormatted = date('Ymd', strtotime($validated['tanggal_lahir']));
            $validated['nip'] = 'PEG-'.$birthDateFormatted.rand(100, 999);
        }

        $pegawai = Pegawai::create($validated);

        return redirect()->route('pegawai.index')
            ->with('success', "Pegawai '{$pegawai->nama}' berhasil ditambahkan ke dalam sistem!");
    }

    /**
     * Tampilkan detail informasi pegawai (HTML atau JSON modal).
     */
    public function show(Request $request, Pegawai $pegawai): View|JsonResponse
    {
        if ($request->wantsJson()) {
            return response()->json([
                'id' => $pegawai->id,
                'nip' => $pegawai->nip ?? '-',
                'nama' => $pegawai->nama,
                'jenis_kelamin' => $pegawai->jenis_kelamin,
                'pendidikan_terakhir' => $pegawai->pendidikan_terakhir,
                'tanggal_lahir' => $pegawai->formatted_tanggal_lahir,
                'raw_tanggal_lahir' => $pegawai->tanggal_lahir?->format('Y-m-d'),
                'usia' => $pegawai->usia,
                'kelompok_usia' => $pegawai->kelompok_usia,
                'jabatan' => $pegawai->jabatan ?? '-',
                'email' => $pegawai->email ?? '-',
                'telepon' => $pegawai->telepon ?? '-',
                'alamat' => $pegawai->alamat ?? '-',
                'inisial' => $pegawai->inisial,
            ]);
        }

        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Tampilkan formulir edit pegawai.
     */
    public function edit(Pegawai $pegawai): View
    {
        $jenjangPendidikan = ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3'];

        return view('pegawai.edit', compact('pegawai', 'jenjangPendidikan'));
    }

    /**
     * Perbarui data pegawai.
     */
    public function update(Request $request, Pegawai $pegawai): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'nip' => ['nullable', 'string', 'max:30', 'unique:pegawais,nip,'.$pegawai->id],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'pendidikan_terakhir' => ['required', 'in:SD,SMP,SMA/SMK,D3,S1,S2,S3'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:100', 'unique:pegawais,email,'.$pegawai->id],
            'telepon' => ['nullable', 'string', 'max:25'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [
            'nama.required' => 'Nama pegawai wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar untuk pegawai lain.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib dipilih.',
            'pendidikan_terakhir.in' => 'Pilihan pendidikan terakhir tidak valid.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pegawai lain.',
        ]);

        $pegawai->update($validated);

        return redirect()->route('pegawai.index')
            ->with('success', "Data pegawai '{$pegawai->nama}' berhasil diperbarui!");
    }

    /**
     * Hapus data pegawai.
     * (Sebelum aksi ini dipanggil, frontend menampilkan popup konfirmasi SweetAlert2 sesuai ketentuan F)
     */
    public function destroy(Pegawai $pegawai): RedirectResponse
    {
        $nama = $pegawai->nama;
        $pegawai->delete();

        return redirect()->route('pegawai.index')
            ->with('success', "Data pegawai '{$nama}' berhasil dihapus dari sistem.");
    }

    /**
     * Export data pegawai ke format CSV.
     */
    public function export(): StreamedResponse
    {
        $pegawais = Pegawai::orderBy('nama', 'asc')->get();
        $filename = 'data-pegawai-'.date('Y-m-d-His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($pegawais) {
            $file = fopen('php://output', 'w');
            // Menambahkan UTF-8 BOM agar terbaca dengan baik di Microsoft Excel
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'NIP',
                'Nama Pegawai',
                'Jenis Kelamin',
                'Pendidikan Terakhir',
                'Tanggal Lahir',
                'Usia (Tahun)',
                'Jabatan',
                'Email',
                'Telepon',
                'Alamat',
            ]);

            foreach ($pegawais as $p) {
                fputcsv($file, [
                    $p->nip ?? '-',
                    $p->nama,
                    $p->jenis_kelamin,
                    $p->pendidikan_terakhir,
                    $p->tanggal_lahir?->format('Y-m-d') ?? '-',
                    $p->usia,
                    $p->jabatan ?? '-',
                    $p->email ?? '-',
                    $p->telepon ?? '-',
                    $p->alamat ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
