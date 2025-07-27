<script>
    function openModal() {
        document.getElementById('tabunganModal').classList.remove('hidden');
        // Add smooth entrance animation
        setTimeout(() => {
            document.getElementById('tabunganModal').querySelector('.modal-content').classList.add(
                'animate-pulse');
        }, 100);
    }

    function closeModal() {
        document.getElementById('tabunganModal').classList.add('hidden');
    }

    function formatNominal(input) {
        let value = input.value.replace(/\D/g, '');
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }

    // Add some smooth animations on load
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.group');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';

                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            }, index * 100);
        });
    });

    // FUNGSI BARU UNTUK MODAL EDIT
    function openEditModal(item) {
        // Tampilkan modal
        document.getElementById('editTabunganModal').classList.remove('hidden');

        // Dapatkan elemen form
        const form = document.getElementById('editTabunganForm');

        // Atur action form secara dinamis
        form.action = `/tabungan/${item.id}`;

        // Isi semua field form dengan data dari 'item'
        document.getElementById('edit_nama').value = item.nama;
        document.getElementById('edit_jenis').value = item.jenis;
        document.getElementById('edit_keterangan').value = item.keterangan;

        // =======================================================
        // PERBAIKAN BUG ADA DI SINI
        // =======================================================
        const nominalInput = document.getElementById('edit_nominal');
        // Langsung format angka dari database (item.nominal) ke format Rupiah
        nominalInput.value = new Intl.NumberFormat('id-ID').format(item.nominal);
        // =======================================================
    }

    function closeEditModal() {
        document.getElementById('editTabunganModal').classList.add('hidden');
    }

    {{-- 2. Inisialisasi Grafik --}}
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil data yang sudah diolah dari controller
        const chartData = @json($chartData ?? []);

        // Cek jika data grafik ada untuk menghindari error
        if (Object.keys(chartData).length > 0) {

            // Inisialisasi Pie Chart
            const ctxPie = document.getElementById('pieChart');
            if (ctxPie) {
                new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: ['Pemasukan', 'Pengeluaran'],
                        datasets: [{
                            label: 'Total',
                            data: chartData.pie,
                            backgroundColor: [
                                'rgba(16, 185, 129, 0.7)', // Hijau (Emerald)
                                'rgba(239, 68, 68, 0.7)' // Merah (Red)
                            ],
                            borderColor: [
                                'rgba(16, 185, 129, 1)',
                                'rgba(239, 68, 68, 1)'
                            ],
                            borderWidth: 1
                        }]
                    }
                });
            }

            // Inisialisasi Bar Chart
            const ctxBar = document.getElementById('barChart');
            if (ctxBar && chartData.bar.labels.length > 0) {
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: chartData.bar.labels,
                        datasets: [{
                            label: 'Frekuensi Penggunaan',
                            data: chartData.bar.data,
                            backgroundColor: 'rgba(99, 102, 241, 0.7)', // Ungu (Indigo)
                            borderColor: 'rgba(99, 102, 241, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y', // Membuat bar menjadi horizontal agar mudah dibaca
                        scales: {
                            x: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Inisialisasi Line Chart
            const ctxLine = document.getElementById('lineChart');
            if (ctxLine) {
                new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: chartData.line.labels,
                        datasets: [{
                            label: 'Arus Kas (Pemasukan - Pengeluaran)',
                            data: chartData.line.data,
                            fill: true,
                            backgroundColor: 'rgba(59, 130, 246, 0.2)', // Biru (Blue)
                            borderColor: 'rgba(59, 130, 246, 1)',
                            tension: 0.3
                        }]
                    }
                });
            }
        }
    });
</script>
