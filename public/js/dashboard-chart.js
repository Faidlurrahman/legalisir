document.addEventListener('DOMContentLoaded', function() {
    if (typeof grafikAktaData !== 'undefined') {
        const { labels, dataLahir, dataMati, dataKawin, dataCerai } = grafikAktaData;
        const canvas = document.getElementById('grafikAkta');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Kelahiran',
                        data: dataLahir,
                        borderColor: '#38b2ac',
                        backgroundColor: 'rgba(56,178,172,0.05)',
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointBackgroundColor: '#38b2ac',
                        borderWidth: 3,
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Kematian',
                        data: dataMati,
                        borderColor: '#f87171',
                        backgroundColor: 'rgba(248,113,113,0.05)',
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointBackgroundColor: '#f87171',
                        borderWidth: 3,
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Perkawinan',
                        data: dataKawin,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99,102,241,0.05)',
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointBackgroundColor: '#6366f1',
                        borderWidth: 3,
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Perceraian',
                        data: dataCerai,
                        borderColor: '#fbbf24',
                        backgroundColor: 'rgba(251,191,36,0.05)',
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointBackgroundColor: '#fbbf24',
                        borderWidth: 3,
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 20,
                        ticks: {
                            stepSize: 5,
                            callback: function(value) { return value; },
                            color: '#64748B'
                        }
                    },
                    x: { ticks: { color: '#64748B' } }
                }
            }
        });
    }
});
