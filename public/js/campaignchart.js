document.addEventListener('DOMContentLoaded', async () => {
    const API_URL = "https://ws.jalankebaikan.id/api/campaigns";

    // Fungsi untuk mengambil semua data dari API dengan pagination
    async function fetchAllCampaigns(url, campaigns = []) {
        const response = await fetch(url);
        const result = await response.json();

        // Tambahkan data yang didapat
        campaigns = campaigns.concat(result.data);

        // Cek apakah ada halaman berikutnya
        if (result.next_page_url) {
            return fetchAllCampaigns(result.next_page_url, campaigns);
        }

        return campaigns;
    }

    // Ambil semua data dari API
    let campaigns = await fetchAllCampaigns(API_URL);

    // Filter 5 campaign dengan current amount tertinggi
    campaigns = campaigns
        .filter(c => c.current_amount > 0)
        .sort((a, b) => b.current_amount - a.current_amount)
        .slice(0, 5);

    // Ekstraksi data untuk Chart.js
    const labels = campaigns.map(c => c.campaign_name.length > 15 ? c.campaign_name.substring(0, 15) + '...' : c.campaign_name);
    const targetAmounts = campaigns.map(c => c.target_amount);
    const currentAmounts = campaigns.map(c => c.current_amount);

    // Inisialisasi grafik
    const ctx = document.getElementById('campaignschart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    type: 'bar',
                    label: 'Target Amount',
                    data: targetAmounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                },
                {
                    type: 'line',
                    label: 'Current Amount',
                    data: currentAmounts,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Campaign Progress',
                    font: {
                        weight: 'bold', // Membuat teks bold
                        size: 14, // Ukuran font (opsional)
                        family: 'Arial', // Font family (opsional)
                    },
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Campaign Name',
                        font: {
                            weight: 'bold', // Membuat teks bold
                            size: 14, // Ukuran font (opsional)
                            family: 'Arial', // Font family (opsional)
                        },
                    }
                },
               
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (Rp)',
                        font: {
                            weight: 'bold', // Membuat teks bold
                            size: 14, // Ukuran font (opsional)
                            family: 'Arial', // Font family (opsional)
                        },
                    }
                }
            }
        }
    });
});

// jika menggunakan controller
// fetch('/chart-campaigns')
// .then(response => response.json())
// .then(chartData => {
//     const labels = chartData.labels;
//     const targetAmounts = chartData.target_amounts;
//     const currentAmounts = chartData.current_amounts;

//     const ctx = document.getElementById('campaignschart').getContext('2d');
//     new Chart(ctx, {
//         type: 'bar',
//         data: {
//             labels: labels,
//             datasets: [{
//                     label: 'Target Amount',
//                     data: targetAmounts,
//                     backgroundColor: 'rgba(54, 162, 235, 0.5)',
//                     borderColor: 'rgba(54, 162, 235, 1)',
//                     borderWidth: 1
//                 },
//                 {
//                     type: 'line',
//                     label: 'Current Amount',
//                     data: currentAmounts,
//                     borderColor: 'rgba(255, 99, 132, 1)',
//                     backgroundColor: 'rgba(255, 99, 132, 0.2)',
//                     fill: true,
//                 }
//             ]
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             plugins: {
//                 title: {
//                     display: true,
//                     text: 'Campaign Progress', // Judul grafik
//                     font: {
//                         weight: 'bold', // Membuat teks bold
//                         size: 14, // Ukuran font (opsional)
//                         family: 'Arial', // Font family (opsional)
//                     },
//                 }
//             },
//             scales: {
//                 y: {
//                     beginAtZero: true,
//                     title: {
//                         display: true,
//                         text: 'Amount (Rp)', // Label untuk sumbu Y
//                         font: {
//                             weight: 'bold', // Membuat teks bold
//                             size: 14, // Ukuran font (opsional)
//                             family: 'Arial', // Font family (opsional)
//                         },
//                     }
//                 },
//                 x: {
//                     title: {
//                         display: true,
//                         text: 'Campaign Name', // Label untuk sumbu X
//                         font: {
//                             weight: 'bold', // Membuat teks bold
//                             size: 14, // Ukuran font (opsional)
//                             family: 'Arial', // Font family (opsional)
//                         },
//                     }
//                 }
//             }
//         }
//     });
// })
// .catch(error => console.error('Error fetching chart data:', error));