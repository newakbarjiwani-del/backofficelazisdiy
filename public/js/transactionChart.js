document.addEventListener('DOMContentLoaded', async () => {
    try {
        // Mengambil data dari API
        const response = await fetch('https://ws.jalankebaikan.id/api/transactions'); // Sesuaikan dengan URL API Anda
        if (!response.ok) throw new Error('Gagal mengambil data');

        const data = await response.json();
        const transactions = data.data; // Sesuaikan dengan struktur API

        // Inisialisasi data untuk chart
        const chartData = {};
        const categories = ['zakat', 'campaign', 'infak']; // Kategori yang ingin dipisahkan
        let allDates = [];

        // Fungsi untuk hanya mengambil tanggal tanpa waktu
        const formatDate = (dateString) => {
            const date = new Date(dateString);
            return date.toISOString().split('T')[0]; // Ambil tanggal saja (YYYY-MM-DD)
        };

        // Proses transaksi dan kelompokkan berdasarkan kategori
        transactions.forEach(transaction => {
            const date = formatDate(transaction.transaction_date); // Menggunakan hanya tanggal
            const amount = transaction.transaction_amount ?? 0; // Default 0 jika tidak ada amount
            let category = 'lainnya'; // Default jika bukan zakat, campaign, atau infak

            if (transaction.zakat_id) {
                category = 'zakat';
            } else if (transaction.campaign_id) {
                category = 'campaign';
            } else if (transaction.infak_id) {
                category = 'infak';
            }

            // Inisialisasi jika kategori belum ada
            if (!chartData[category]) {
                chartData[category] = {};
            }
            if (!chartData[category][date]) {
                chartData[category][date] = 0;
            }

            // Tambahkan jumlah transaksi ke kategori yang sesuai
            chartData[category][date] += amount;
        });

        // Mengumpulkan semua tanggal yang unik
        categories.forEach(category => {
            if (chartData[category]) {
                allDates = [...allDates, ...Object.keys(chartData[category])];
            }
        });

        allDates = [...new Set(allDates)]; // Hapus tanggal duplikat
        allDates.sort(); // Urutkan tanggal

        // Warna berbeda untuk tiap kategori
        const colors = {
            'zakat': ['rgba(255, 99, 132, 1)', 'rgba(255, 99, 132, 0.2)'],
            'campaign': ['rgba(54, 162, 235, 1)', 'rgba(54, 162, 235, 0.2)'],
            'infak': ['rgba(255, 206, 86, 1)', 'rgba(255, 206, 86, 0.2)']
        };

        // Menyiapkan dataset untuk Chart.js
        const datasets = categories.map(category => {
            const dataPoints = allDates.map(date => chartData[category][date] || 0); // Jika tidak ada, beri 0
            return {
                label: category.charAt(0).toUpperCase() + category.slice(1),
                data: dataPoints,
                borderColor: colors[category][0],
                backgroundColor: colors[category][1],
                borderWidth: 2,
                fill: true
            };
        });

        // Membuat grafik Chart.js
        const ctx = document.getElementById('transactionChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: allDates,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal',
                            font: {
                                weight: 'bold',
                                size: 14,
                                family: 'Arial'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Donasi (Rp)',
                            font: {
                                weight: 'bold',
                                size: 14,
                                family: 'Arial'
                            }
                        }
                    }
                }
            }
        });

    } catch (error) {
        console.error('Error fetching chart data:', error);
    }
});



// document.addEventListener('DOMContentLoaded', async () => {
//     try {
//         // Mengambil data dari API
//         const response = await fetch('https://ws.jalankebaikan.id/api/transactions'); // Sesuaikan dengan URL API Anda
//         if (!response.ok) throw new Error('Gagal mengambil data');

//         const data = await response.json();
//         const transactions = data.data; // Sesuaikan dengan struktur API

//         // Inisialisasi data untuk chart
//         const chartData = {};
//         const categories = ['zakat', 'campaign', 'infak']; // Kategori yang ingin dipisahkan
//         let allDates = [];

//         // Proses transaksi dan kelompokkan berdasarkan kategori
//         transactions.forEach(transaction => {
//             const date = transaction.transaction_date;
//             const amount = transaction.transaction_amount ?? 0; // Default 0 jika tidak ada amount
//             let category = 'lainnya'; // Default jika bukan zakat, campaign, atau infak

//             if (transaction.zakat_id) {
//                 category = 'zakat';
//             } else if (transaction.campaign_id) {
//                 category = 'campaign';
//             } else if (transaction.infak_id) {
//                 category = 'infak';
//             }

//             // Inisialisasi jika kategori belum ada
//             if (!chartData[category]) {
//                 chartData[category] = {};
//             }
//             if (!chartData[category][date]) {
//                 chartData[category][date] = 0;
//             }

//             // Tambahkan jumlah transaksi ke kategori yang sesuai
//             chartData[category][date] += amount;
//         });

//         // Mengumpulkan semua tanggal yang unik
//         categories.forEach(category => {
//             if (chartData[category]) {
//                 allDates = [...allDates, ...Object.keys(chartData[category])];
//             }
//         });

//         allDates = [...new Set(allDates)]; // Hapus tanggal duplikat
//         allDates.sort(); // Urutkan tanggal

//         // Warna berbeda untuk tiap kategori
//         const colors = {
//             'zakat': ['rgba(255, 99, 132, 1)', 'rgba(255, 99, 132, 0.2)'],
//             'campaign': ['rgba(54, 162, 235, 1)', 'rgba(54, 162, 235, 0.2)'],
//             'infak': ['rgba(255, 206, 86, 1)', 'rgba(255, 206, 86, 0.2)']
//         };

//         // Menyiapkan dataset untuk Chart.js
//         const datasets = categories.map(category => {
//             const dataPoints = allDates.map(date => chartData[category][date] || 0); // Jika tidak ada, beri 0
//             return {
//                 label: category.charAt(0).toUpperCase() + category.slice(1),
//                 data: dataPoints,
//                 borderColor: colors[category][0],
//                 backgroundColor: colors[category][1],
//                 borderWidth: 2,
//                 fill: true
//             };
//         });

//         // Membuat grafik Chart.js
//         const ctx = document.getElementById('transactionChart').getContext('2d');
//         new Chart(ctx, {
//             type: 'line',
//             data: {
//                 labels: allDates,
//                 datasets: datasets
//             },
//             options: {
//                 responsive: true,
//                 maintainAspectRatio: false,
//                 plugins: {
//                     legend: {
//                         display: true,
//                         position: 'top',
//                     }
//                 },
//                 scales: {
//                     x: {
//                         title: {
//                             display: true,
//                             text: 'Tanggal',
//                             font: {
//                                 weight: 'bold',
//                                 size: 14,
//                                 family: 'Arial'
//                             }
//                         }
//                     },
//                     y: {
//                         beginAtZero: true,
//                         title: {
//                             display: true,
//                             text: 'Total Donasi (Rp)',
//                             font: {
//                                 weight: 'bold',
//                                 size: 14,
//                                 family: 'Arial'
//                             }
//                         }
//                     }
//                 }
//             }
//         });

//     } catch (error) {
//         console.error('Error fetching chart data:', error);
//     }
// });



//jika menggunakan controller
// document.addEventListener('DOMContentLoaded', async () => {
//     try {
//         const response = await fetch('/chart-transactions');
//         if (!response.ok) throw new Error('Gagal mengambil data');

//         const chartData = await response.json();
//         const ctx = document.getElementById('transactionChart').getContext('2d');

//         new Chart(ctx, {
//             type: 'line',
//             data: chartData,
//             options: {
//                 responsive: true,
//                 maintainAspectRatio: false,
//                 plugins: {
//                     legend: {
//                         display: true,
//                         position: 'top',
//                     }
//                 },
//                 scales: {
//                     x: {
//                         title: {
//                             display: true,
//                             text: 'Tanggal',
//                             font: {
//                                 weight: 'bold',
//                                 size: 14,
//                                 family: 'Arial'
//                             }
//                         }
//                     },
//                     y: {
//                         beginAtZero: true,
//                         title: {
//                             display: true,
//                             text: 'Total Donasi (Rp)',
//                             font: {
//                                 weight: 'bold',
//                                 size: 14,
//                                 family: 'Arial'
//                             }
//                         }
//                     }
//                 }
//             }
//         });
//     } catch (error) {
//         console.error('Error fetching chart data:', error);
//     }
// });