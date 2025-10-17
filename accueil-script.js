document.addEventListener('DOMContentLoaded', () => {
  const blue = '#4c5bf9';
  const blueSoft = 'rgba(76,91,249,.18)';
  const green = '#45c778';
  const grid = '#e9ecf3';

  const baseOpts = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false }, tooltip: { enabled: true } },
    scales: {
      x: { grid: { color: grid }, ticks: { color: '#667085' } },
      y: { grid: { color: grid }, ticks: { color: '#667085' }, beginAtZero: true }
    }
  };

  // Histogramme principal (droite)
  const perfEl = document.getElementById('chart-perf');
  if (perfEl) {
    new Chart(perfEl.getContext('2d'), {
      type: 'bar',
      data: {
        labels: ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'],
        datasets: [{
          data: [32, 45, 41, 50, 62, 48, 54],
          backgroundColor: blue,
          borderRadius: 8,
          barThickness: 18
        }]
      },
      options: {
        ...baseOpts,
        scales: { ...baseOpts.scales, y: { ...baseOpts.scales.y, suggestedMax: 70 } },
        animation: { duration: 700 }
      }
    });
  }

  // Jauge (demi-donut)
  const gaugeEl = document.getElementById('chart-gauge');
  if (gaugeEl) {
    new Chart(gaugeEl.getContext('2d'), {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [72, 28],
          backgroundColor: [blue, blueSoft],
          borderWidth: 0,
          cutout: '70%'
        }]
      },
      options: {
        rotation: -90,
        circumference: 180,
        plugins: { legend: { display: false }, tooltip: { enabled: false } }
      }
    });
  }

  // Mini barres
  const miniEl = document.getElementById('chart-mini');
  if (miniEl) {
    new Chart(miniEl.getContext('2d'), {
      type: 'bar',
      data: { labels: ['A','B','C','D','E'],
        datasets: [{ data: [5,8,6,9,7], backgroundColor: blue, borderRadius: 6, barThickness: 10 }] },
      options: { ...baseOpts, scales: { x: { display:false }, y: { display:false, beginAtZero:true, suggestedMax: 10 } } }
    });
  }

  // Courbe verte (gauche)
  const greenEl = document.getElementById('chart-green');
  if (greenEl) {
    new Chart(greenEl.getContext('2d'), {
      type: 'line',
      data: {
        labels: Array.from({length: 12}, (_,i)=>i+1),
        datasets: [{
          data: [12,14,13,16,18,17,21,22,20,23,25,27],
          borderColor: green,
          backgroundColor: 'rgba(69,199,120,.15)',
          tension: .35,
          fill: true,
          pointRadius: 0,
          borderWidth: 3
        }]
      },
      options: { ...baseOpts, scales: { x: { display:false }, y: { display:false } } }
    });
  }

  console.log('✅ Accueil NAHA + charts OK');
});
