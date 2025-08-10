@push('scripts')
    {{-- Include script modal jika belum ada --}}
    @include('tabungan.partials._scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari controller
            const monthlyData = @json($monthlyChartData ?? null);
            const weeklyData = @json($weeklyChartData ?? null);

            // Chart instance
            let chart = null;

            // Current settings
            let currentPeriod = 'weekly'; // weekly | monthly
            let currentType = 'bar'; // bar | line

            // DOM Elements
            const canvas = document.getElementById('expenseChart');
            const periodWeekly = document.getElementById('periodWeekly');
            const periodMonthly = document.getElementById('periodMonthly');
            const chartLine = document.getElementById('chartLine');
            const chartBar = document.getElementById('chartBar');
            const chartDescription = document.getElementById('chartDescription');
            const chartInfo = document.getElementById('chartInfo');

            // Initialize chart with enhanced styling
            function initChart() {
                if (chart) {
                    chart.destroy();
                }

                const data = currentPeriod === 'weekly' ? weeklyData : monthlyData;
                if (!data || !data.labels.length) {
                    chartInfo.textContent = 'Tidak ada data tersedia';
                    return;
                }

                const ctx = canvas.getContext('2d');

                chart = new Chart(ctx, {
                    type: currentType,
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Pengeluaran Harian',
                            data: data.data,
                            backgroundColor: currentType === 'line' ? 'rgba(239, 68, 68, 0.1)' :
                                'rgba(239, 68, 68, 0.8)',
                            borderColor: 'rgba(239, 68, 68, 1)',
                            borderWidth: currentType === 'line' ? 3 : 2,
                            fill: currentType === 'line',
                            tension: currentType === 'line' ? 0.4 : 0,
                            pointBackgroundColor: 'rgba(239, 68, 68, 1)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 3,
                            pointRadius: currentType === 'line' ? 6 : 0,
                            pointHoverRadius: currentType === 'line' ? 8 : 0,
                            borderRadius: currentType === 'bar' ? 12 : 0,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(239, 68, 68, 1)',
                                borderWidth: 2,
                                cornerRadius: 12,
                                displayColors: false,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                padding: 12,
                                callbacks: {
                                    title: function(context) {
                                        return `Tanggal ${context[0].label}`;
                                    },
                                    label: function(context) {
                                        return `💰 Pengeluaran: Rp${context.parsed.y.toLocaleString('id-ID')}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.08)',
                                    drawBorder: false,
                                },
                                ticks: {
                                    callback: function(value) {
                                        if (value >= 1000000) {
                                            return 'Rp' + (value / 1000000).toFixed(1) + 'M';
                                        } else if (value >= 1000) {
                                            return 'Rp' + (value / 1000).toFixed(0) + 'K';
                                        }
                                        return 'Rp' + value.toLocaleString('id-ID');
                                    },
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: currentPeriod === 'monthly' ? 15 : 7,
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeInOutQuart'
                        }
                    }
                });

                updateUI();
            }

            // Update UI descriptions
            function updateUI() {
                const data = currentPeriod === 'weekly' ? weeklyData : monthlyData;

                if (currentPeriod === 'weekly') {
                    chartDescription.textContent = 'Visualisasi trend pengeluaran 7 hari terakhir';
                    chartInfo.textContent =
                        `Total: ${data.total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace('IDR', 'Rp')}`;
                } else {
                    chartDescription.textContent = `Trend pengeluaran ${data.bulan}`;
                    chartInfo.textContent =
                        `Total: ${data.total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace('IDR', 'Rp')}`;
                }
            }

            // Enhanced toggle active states (with dark mode)
            function setActiveButton(activeBtn, inactiveBtn) {
                // Reset inactive button
                inactiveBtn.classList.remove(
                    'bg-gradient-to-r', 'from-red-500', 'to-pink-600', 'text-white', 'shadow-lg',
                    'dark:from-red-600', 'dark:to-pink-700'
                );
                inactiveBtn.classList.add(
                    'text-gray-600', 'hover:text-gray-800', 'hover:bg-white',
                    'dark:text-gray-300', 'dark:hover:text-gray-100', 'dark:hover:bg-gray-800'
                );

                // Set active button
                activeBtn.classList.remove(
                    'text-gray-600', 'hover:text-gray-800', 'hover:bg-white',
                    'dark:text-gray-300', 'dark:hover:text-gray-100', 'dark:hover:bg-gray-800'
                );
                activeBtn.classList.add(
                    'bg-gradient-to-r', 'from-red-500', 'to-pink-600', 'text-white', 'shadow-lg',
                    'dark:from-red-600', 'dark:to-pink-700'
                );
            }


            // Event listeners with enhanced feedback
            periodWeekly.addEventListener('click', () => {
                if (currentPeriod !== 'weekly') {
                    currentPeriod = 'weekly';
                    setActiveButton(periodWeekly, periodMonthly);
                    initChart();
                }
            });

            periodMonthly.addEventListener('click', () => {
                if (currentPeriod !== 'monthly') {
                    currentPeriod = 'monthly';
                    setActiveButton(periodMonthly, periodWeekly);
                    initChart();
                }
            });

            chartLine.addEventListener('click', () => {
                if (currentType !== 'line') {
                    currentType = 'line';
                    setActiveButton(chartLine, chartBar);
                    initChart();
                }
            });

            chartBar.addEventListener('click', () => {
                if (currentType !== 'bar') {
                    currentType = 'bar';
                    setActiveButton(chartBar, chartLine);
                    initChart();
                }
            });

            // Initialize with loading state
            chartInfo.textContent = 'Memuat data...';

            // Initialize chart after a short delay for better UX
            setTimeout(() => {
                if (canvas && (weeklyData || monthlyData)) {
                    initChart();
                } else {
                    chartInfo.textContent = 'Tidak ada data untuk ditampilkan';
                }
            }, 500);
        });
    </script>

    <style>
        /* Custom scrollbar for activity list */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #ef4444, #ec4899);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #dc2626, #db2777);
        }

        /* Animation delays for background elements */
        .animation-delay-1000 {
            animation-delay: 1s;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        /* Enhanced hover effects */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }
    </style>
@endpush
