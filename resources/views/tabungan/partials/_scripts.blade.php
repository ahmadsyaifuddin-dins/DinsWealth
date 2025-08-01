<script>
    // ===============================================
    // FUNGSI-FUNGSI GLOBAL
    // ===============================================
    function openModal() {
        document.getElementById('tabunganModal').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('tabunganModal').querySelector('.modal-content').classList.add(
                'animate-pulse');
        }, 100);
    }

    function closeModal() {
        document.getElementById('tabunganModal').classList.add('hidden');
    }

    function openEditModal(item) {
        const modal = document.getElementById('editTabunganModal');
        if (!modal) return;
        modal.classList.remove('hidden');

        const form = document.getElementById('editTabunganForm');
        form.action = `/tabungan/${item.id}`;

        document.getElementById('edit_nama').value = item.nama;
        document.getElementById('edit_jenis').value = item.jenis;
        document.getElementById('edit_keterangan').value = item.keterangan;

        const nominalInput = document.getElementById('edit_nominal');
        nominalInput.value = new Intl.NumberFormat('id-ID').format(item.nominal);
    }

    function closeEditModal() {
        document.getElementById('editTabunganModal').classList.add('hidden');
    }

    function formatNominal(input) {
        let value = input.value.replace(/\D/g, '');
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }

    function handleExport(exportUrl) {
        const filterForm = document.querySelector('form[action="{{ route('tabungan.index') }}"]');
        if (!filterForm) return;
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData).toString();
        window.location.href = `${exportUrl}?${params}`;
    }


    // ===============================================
    // SCRIPT UTAMA - HANYA SATU DOMCONTENTLOADED
    // ===============================================
    document.addEventListener('DOMContentLoaded', function() {

        // --- Animasi Card ---
        const cards = document.querySelectorAll('.group');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // --- Logika Tombol Export ---
        const exportPdfBtn = document.getElementById('exportPdfBtn');
        const exportExcelBtn = document.getElementById('exportExcelBtn');
        if (exportPdfBtn) {
            exportPdfBtn.addEventListener('click', () => handleExport('{{ route('tabungan.export.pdf') }}'));
        }
        if (exportExcelBtn) {
            exportExcelBtn.addEventListener('click', () => handleExport(
            '{{ route('tabungan.export.excel') }}'));
        }

        // --- Inisialisasi Grafik ---
        const chartData = @json($chartData ?? []);
        if (Object.keys(chartData).length === 0) {
            console.log('Tidak ada data chart untuk ditampilkan.');
            return;
        }

        // Inisialisasi Pie Chart
        const ctxPie = document.getElementById('pieChart');
        // KODE BARU YANG LEBIH AMAN
        if (ctxPie && chartData.pie && chartData.pie.reduce((a, b) => a + Number(b), 0) > 0) {
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        label: 'Total',
                        data: chartData.pie,
                        backgroundColor: ['rgba(16, 185, 129, 0.7)', 'rgba(239, 68, 68, 0.7)'],
                        borderColor: ['rgba(16, 185, 129, 1)', 'rgba(239, 68, 68, 1)'],
                        borderWidth: 1
                    }]
                }
            });
        }

        // Inisialisasi Bar Chart
        const ctxBar = document.getElementById('barChart');
        if (ctxBar && chartData.bar && chartData.bar.labels.length > 0) {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: chartData.bar.labels,
                    datasets: [{
                        label: 'Frekuensi Penggunaan',
                        data: chartData.bar.data,
                        backgroundColor: 'rgba(99, 102, 241, 0.7)',
                        borderColor: 'rgba(99, 102, 241, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // --- Logika Interaktif Line Chart ---
        let lineChartInstance;
        const ctxLine = document.getElementById('lineChart');
        const monthlyBtn = document.getElementById('lineChartMonthlyBtn');
        const dailyBtn = document.getElementById('lineChartDailyBtn');
        const hourlyBtn = document.getElementById('lineChartHourlyBtn');

        if (ctxLine && monthlyBtn && dailyBtn && hourlyBtn) {
            // Gambar chart pertama kali dengan data HARIAN (default)
            lineChartInstance = new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: chartData.line_daily.labels,
                    datasets: [{
                        label: 'Arus Kas',
                        data: chartData.line_daily.data,
                        fill: true,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        tension: 0.3
                    }]
                }
            });

            function updateLineChart(mode) {
                let newData;
                switch (mode) {
                    case 'monthly':
                        newData = chartData.line_monthly;
                        break;
                    case 'hourly':
                        newData = chartData.line_hourly;
                        break;
                    default:
                        newData = chartData.line_daily;
                        break;
                }

                if (!newData || !lineChartInstance) return;

                lineChartInstance.data.labels = newData.labels;
                lineChartInstance.data.datasets[0].data = newData.data;
                lineChartInstance.update();

                const buttons = {
                    hourly: hourlyBtn,
                    daily: dailyBtn,
                    monthly: monthlyBtn
                };
                for (const key in buttons) {
                    const isActive = key === mode;
                    buttons[key].classList.toggle('bg-white', isActive);
                    buttons[key].classList.toggle('text-indigo-600', isActive);
                    buttons[key].classList.toggle('shadow', isActive);
                    buttons[key].classList.toggle('text-gray-600', !isActive);
                }
            }

            hourlyBtn.addEventListener('click', () => updateLineChart('hourly'));
            dailyBtn.addEventListener('click', () => updateLineChart('daily'));
            monthlyBtn.addEventListener('click', () => updateLineChart('monthly'));
        }
    });
</script>
