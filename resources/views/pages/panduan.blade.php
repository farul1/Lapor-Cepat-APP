<x-guest-layout>
    {{-- Menggunakan guest layout agar bisa diakses oleh siapa saja --}}
    <style>
        .faq-item {
            border-bottom: 1px solid #e5e7eb; /* border-b border-gray-200 */
        }
        .faq-item:last-child {
            border-bottom: none;
        }
        .faq-question {
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0; /* py-6 */
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-in-out;
        }
    </style>

    <div class="w-full max-w-4xl bg-white p-8 md:p-12 rounded-2xl shadow-xl">
        <div class="text-center mb-10">
            <a href="/" class="flex justify-center items-center text-slate-800 mb-4">
                <svg class="h-8 w-auto text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                </svg>
                <span class="ml-3 font-bold text-3xl">LaporCepat</span>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Panduan Bantuan & Pertanyaan Umum (FAQ)</h1>
            <p class="mt-2 text-md text-gray-600">Temukan jawaban untuk pertanyaan umum tentang penggunaan LaporCepat.</p>
        </div>

        <div class="space-y-8">
            {{-- Bagian FAQ --}}
            <div id="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3 class="text-lg font-medium text-gray-800">Apa itu LaporCepat?</h3>
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="faq-answer">
                        <p class="pt-2 pb-6 text-gray-600 leading-relaxed">
                            LaporCepat adalah sebuah platform digital yang dirancang untuk menjadi jembatan antara masyarakat dan instansi terkait. Tujuan kami adalah memudahkan Anda untuk menyampaikan laporan, keluhan, atau aspirasi mengenai isu-isu publik seperti kerusakan infrastruktur, masalah lingkungan, hingga pelayanan publik, secara cepat dan transparan.
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3 class="text-lg font-medium text-gray-800">Bagaimana cara membuat laporan?</h3>
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="faq-answer">
                        <p class="pt-2 pb-6 text-gray-600 leading-relaxed">
                            Sangat mudah! Ikuti langkah-langkah berikut:
                            <ol class="list-decimal list-inside mt-2 space-y-1">
                                <li>Klik tombol "Daftar Akun" di halaman login, lalu isi data diri Anda.</li>
                                <li>Setelah login, klik tombol "Buat Laporan Baru" di dashboard Anda.</li>
                                <li>Isi semua field yang diperlukan, termasuk judul, deskripsi detail laporan, lokasi kejadian, dan lampirkan foto/video jika ada.</li>
                                <li>Klik "Kirim Laporan". Laporan Anda akan langsung masuk ke sistem kami.</li>
                            </ol>
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3 class="text-lg font-medium text-gray-800">Status laporan saya "Menunggu Verifikasi", apa artinya?</h3>
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="faq-answer">
                        <p class="pt-2 pb-6 text-gray-600 leading-relaxed">
                            Status "Menunggu Verifikasi" berarti laporan Anda telah berhasil masuk ke sistem kami dan sedang dalam antrian untuk ditinjau oleh tim admin. Admin akan memeriksa kelengkapan dan validitas laporan Anda sebelum mengubah statusnya menjadi "Diterima" dan meneruskannya ke petugas terkait.
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3 class="text-lg font-medium text-gray-800">Apakah saya bisa menghubungi dukungan jika mengalami kendala?</h3>
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="faq-answer">
                        <p class="pt-2 pb-6 text-gray-600 leading-relaxed">
                            Tentu. Jika Anda mengalami kendala teknis atau memiliki pertanyaan yang tidak terjawab di sini, silakan hubungi tim dukungan kami melalui email di <a href="mailto:dukungan@laporcepat.com" class="text-blue-600 hover:underline">dukungan@laporcepat.com</a>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Kembali ke Halaman Login
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const faqContainer = document.getElementById('faq-container');
            if (faqContainer) {
                faqContainer.addEventListener('click', function (e) {
                    const question = e.target.closest('.faq-question');
                    if (!question) return;

                    const item = question.parentElement;
                    const answer = question.nextElementSibling;
                    const icon = question.querySelector('svg');

                    item.classList.toggle('open');

                    if (item.classList.contains('open')) {
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        answer.style.maxHeight = '0';
                        icon.style.transform = 'rotate(0deg)';
                    }
                });
            }
        });
    </script>
</x-guest-layout>
