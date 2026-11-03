import Chart from 'chart.js/auto';
import Swal from 'sweetalert2';
import { createIcons, icons } from 'lucide';

window.Chart = Chart;
window.Swal = Swal;

// Initialize Lucide Icons
window.initIcons = function() {
    createIcons({ icons });
};

// Global confirmDelete helper for requirement (f)
window.confirmDelete = function(formId, employeeName = 'ini') {
    Swal.fire({
        title: 'Konfirmasi Penghapusan',
        html: `Apakah Anda yakin ingin menghapus data pegawai <strong>"${employeeName}"</strong>?<br><span style="font-size: 0.875rem; color: #64748b;">Data yang dihapus tidak dapat dipulihkan kembali.</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus Data!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        focusCancel: true,
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-slate-100',
            confirmButton: 'px-5 py-2.5 rounded-xl font-medium text-white shadow-sm',
            cancelButton: 'px-5 py-2.5 rounded-xl font-medium text-white shadow-sm'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(formId);
            if (form) {
                form.submit();
            }
        }
    });
};

// Global Toast helper
window.showToast = function(icon, message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    Toast.fire({
        icon: icon,
        title: message
    });
};

// Helper to open employee quick preview modal via AJAX
window.openPegawaiModal = function(id) {
    const modal = document.getElementById('detailModal');
    const content = document.getElementById('detailModalContent');
    if (!modal || !content) return;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    content.innerHTML = `
        <div class="flex items-center justify-center p-8 space-x-3 text-slate-500">
            <svg class="animate-spin h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span class="text-sm font-medium">Memuat data pegawai...</span>
        </div>
    `;

    fetch(`/pegawai/${id}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        const genderBadge = data.jenis_kelamin === 'Laki-laki'
            ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">Laki-laki</span>`
            : `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-200">Perempuan</span>`;

        content.innerHTML = `
            <div class="p-6">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white flex items-center justify-center text-xl font-bold shadow-md shadow-indigo-100">
                        ${data.inisial}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">${data.nama}</h3>
                        <p class="text-sm font-medium text-indigo-600">${data.jabatan}</p>
                        <p class="text-xs text-slate-400 font-mono mt-0.5">NIP: ${data.nip}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-medium">Jenis Kelamin</span>
                        <div class="mt-1">${genderBadge}</div>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-medium">Pendidikan Terakhir</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200 mt-1">
                            ${data.pendidikan_terakhir}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-medium">Tanggal Lahir</span>
                        <span class="text-slate-700 font-medium">${data.tanggal_lahir}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-medium">Usia</span>
                        <span class="text-slate-700 font-bold">${data.usia} Tahun <span class="text-xs text-slate-400 font-normal">(${data.kelompok_usia})</span></span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-medium">Email</span>
                        <span class="text-slate-700">${data.email}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-medium">Nomor Telepon</span>
                        <span class="text-slate-700 font-mono">${data.telepon}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-xs text-slate-400 block uppercase font-medium">Alamat</span>
                        <span class="text-slate-700">${data.alamat}</span>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="/pegawai/${data.id}/edit" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-xl bg-amber-500 hover:bg-amber-600 text-white shadow-sm transition">
                        Ubah Data
                    </a>
                    <button onclick="closePegawaiModal()" type="button" class="px-4 py-2 text-sm font-semibold rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 transition">
                        Tutup
                    </button>
                </div>
            </div>
        `;
    })
    .catch(err => {
        content.innerHTML = `
            <div class="p-6 text-center text-rose-500">
                <p>Gagal memuat detail pegawai. Silakan coba lagi.</p>
                <button onclick="closePegawaiModal()" class="mt-4 px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-sm">Tutup</button>
            </div>
        `;
    });
};

window.closePegawaiModal = function() {
    const modal = document.getElementById('detailModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
};

document.addEventListener('DOMContentLoaded', () => {
    window.initIcons();
});
