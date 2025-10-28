<script>
    // FUNGSI-FUNGSI GLOBAL
    function openModal() {
        document.getElementById('tabunganModal').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('tabunganModal').querySelector('.modal-content').classList.add(
                'animate-pulse');
        }, 100);
    }

    function closeModal() {
        const modal = document.getElementById('tabunganModal');
        modal.classList.add('hidden');
        modal.querySelector('form').reset(); // Reset isi form
        
        // Membersihkan preview gambar yang mungkin sudah dipilih
        document.getElementById('imagePreviewContainer').innerHTML = ''; 
    }

    function openEditModal(item) {
        const modal = document.getElementById('editTabunganModal');
        const form = document.getElementById('editTabunganForm');
        
        form.action = `/tabungan/${item.id}`;

        document.getElementById('edit_nama').value = item.nama;
        document.getElementById('edit_jenis').value = item.jenis;
        document.getElementById('edit_keterangan').value = item.keterangan ?? '';
        document.getElementById('edit_nominal').value = new Intl.NumberFormat('id-ID').format(item.nominal);

        const dateFromServer = new Date(item.created_at);
        dateFromServer.setMinutes(dateFromServer.getMinutes() - dateFromServer.getTimezoneOffset());
        const localIsoDateTime = dateFromServer.toISOString().slice(0, 16);
        document.getElementById('edit_created_at').value = localIsoDateTime;

        const existingImagesContainer = document.getElementById('existingImagesContainer');
        const deletedImagesContainer = document.getElementById('deletedImagesContainer');
        const newImagePreviewContainer = document.getElementById('newImagePreviewContainer');
        
        existingImagesContainer.innerHTML = '';
        deletedImagesContainer.innerHTML = '';
        newImagePreviewContainer.innerHTML = '';
        document.getElementById('edit_images').value = '';

        if (item.images && item.images.length > 0) {
            item.images.forEach(image => {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative';
                wrapper.id = `image-wrapper-${image.id}`;

                const img = document.createElement('img');
                const finalImageUrl = "{{ app()->environment('local') ? '/storage/' : '/' }}" + image.path;
                img.src = finalImageUrl;
                img.className = "w-24 h-24 object-cover rounded-lg shadow-md";

                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.innerHTML = '&times;';
                deleteBtn.className = 'absolute top-0 right-0 -mt-2 -mr-2 w-6 h-6 bg-red-600 text-white rounded-full flex items-center justify-center font-bold text-lg hover:bg-red-800 transition-all';
                
                deleteBtn.onclick = function() {
                    document.getElementById(`image-wrapper-${image.id}`).style.display = 'none';
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'deleted_images[]';
                    hiddenInput.value = image.id;
                    deletedImagesContainer.appendChild(hiddenInput);
                };

                wrapper.appendChild(img);
                wrapper.appendChild(deleteBtn);
                existingImagesContainer.appendChild(wrapper);
            });
        }
        
        modal.classList.remove('hidden');
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

    function previewMultipleImages(event, containerId) {
        const container = document.getElementById(containerId);
        container.innerHTML = ''; 
        
        if (event.target.files) {
            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Preview";
                    img.className = "w-24 h-24 object-cover rounded-lg shadow-md";
                    container.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }
    }

    function openShowModal(item) {
        const nominalEl = document.getElementById('showNominal');
        const jenisEl = document.getElementById('showJenis');
        const namaEl = document.getElementById('showNama');
        const tanggalEl = document.getElementById('showTanggal');
        const keteranganEl = document.getElementById('showKeterangan');
        const imagesContainer = document.getElementById('showImagesContainer');

        const isPemasukan = item.kategori_jenis?.jenis === 'Pemasukan';
        
        nominalEl.textContent = `${isPemasukan ? '+' : '-'}Rp${new Intl.NumberFormat('id-ID').format(item.nominal)}`;
        nominalEl.className = `text-4xl font-bold ${isPemasukan ? 'text-green-600' : 'text-red-600'}`;
        
        jenisEl.textContent = item.kategori_jenis?.jenis ?? 'Data Hilang';
        jenisEl.className = `mt-1 text-lg font-medium ${isPemasukan ? 'text-green-500' : 'text-red-500'}`;

        namaEl.textContent = item.kategori_nama?.nama ?? 'Kategori Dihapus';
        
        tanggalEl.textContent = new Date(item.created_at).toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
        }) + ' WITA';
        
        keteranganEl.innerHTML = item.keterangan ? `<p class="dark:text-white">${item.keterangan}</p>` : `<p class="text-gray-400">Tidak ada keterangan.</p>`;

        imagesContainer.innerHTML = '';
        if (item.images && item.images.length > 0) {
            item.images.forEach(image => {
                const finalImageUrl = "{{ app()->environment('local') ? '/storage/' : '/' }}" + image.path;
                const imgLink = document.createElement('a');
                imgLink.href = finalImageUrl;
                imgLink.target = '_blank';
                imgLink.innerHTML = `<img src="${finalImageUrl}" class="w-full h-32 object-cover rounded-lg shadow-md transition-transform hover:scale-105" alt="Bukti Transaksi">`;
                imagesContainer.appendChild(imgLink);
            });
        } else {
            imagesContainer.innerHTML = `<p class="text-gray-400 col-span-full text-center">Tidak ada bukti transaksi.</p>`;
        }

        document.getElementById('showTabunganModal').classList.remove('hidden');
    }

    function closeShowModal() {
        document.getElementById('showTabunganModal').classList.add('hidden');
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

        let lineChartInstance;
        const ctxLine = document.getElementById('lineChart');
        const monthlyBtn = document.getElementById('lineChartMonthlyBtn');
        const dailyBtn = document.getElementById('lineChartDailyBtn');
        // Tombol baru
        const weeklyBtn = document.getElementById('lineChartWeeklyBtn');
        const yearlyBtn = document.getElementById('lineChartYearlyBtn');

        // Update if-check
        if (ctxLine && monthlyBtn && dailyBtn && weeklyBtn && yearlyBtn) {
            
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

            // Fungsi update line chart
            function updateLineChart(mode) {
                let newData;
                switch (mode) {
                    case 'weekly': // <-- Tambahan
                        newData = chartData.line_weekly;
                        break;
                    case 'monthly':
                        newData = chartData.line_monthly;
                        break;
                    case 'yearly': // <-- Tambahan
                        newData = chartData.line_yearly;
                        break;
                    // Case 'hourly' dihapus
                    default: // 'daily'
                        newData = chartData.line_daily;
                        break;
                }

                if (!newData || !lineChartInstance) return;

                // Update chart data
                lineChartInstance.data.labels = newData.labels;
                lineChartInstance.data.datasets[0].data = newData.data;
                lineChartInstance.update();

                // Handle styling button
                const buttons = {
                    daily: dailyBtn,
                    weekly: weeklyBtn, // <-- Tambahan
                    monthly: monthlyBtn,
                    yearly: yearlyBtn // <-- Tambahan
                    // 'hourly' dihapus
                };

                for (const key in buttons) {
                    const btn = buttons[key];
                    const isActive = key === mode;

                    // Reset semua classes
                    btn.className =
                        'flex-1 sm:flex-none px-3 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200';

                    if (isActive) {
                        btn.classList.add(
                            'bg-indigo-600',
                            'text-white',
                            'shadow-md',
                            'dark:bg-indigo-500',
                            'dark:text-white',
                            'transform',
                            'scale-105'
                        );
                    } else {
                        btn.classList.add(
                            'text-gray-600',
                            'dark:text-gray-300',
                            'hover:text-indigo-600',
                            'dark:hover:text-indigo-400',
                            'hover:bg-gray-50',
                            'dark:hover:bg-gray-600'
                        );
                    }
                }
            }

            // Event listeners (Update)
            // hourlyBtn dihapus
            dailyBtn.addEventListener('click', () => updateLineChart('daily'));
            weeklyBtn.addEventListener('click', () => updateLineChart('weekly')); // <-- Tambahan
            monthlyBtn.addEventListener('click', () => updateLineChart('monthly'));
            yearlyBtn.addEventListener('click', () => updateLineChart('yearly')); // <-- Tambahan
        }
    });
</script>