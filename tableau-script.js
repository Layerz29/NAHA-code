document.addEventListener('DOMContentLoaded', () => {
  // ===== topbar shadow + progress + back-to-top (même logique que l'accueil)
  const topbar = document.querySelector('.topbar');
  const progress = document.querySelector('.scroll-progress');
  const toTop = document.createElement('button');
  toTop.className = 'to-top'; toTop.textContent = '↑'; document.body.appendChild(toTop);

  const onScroll = () => {
    const y = window.scrollY || 0;
    topbar?.classList.toggle('scrolled', y > 8);
    toTop.classList.toggle('show', y > 400);
    if (progress) {
      const h = document.documentElement;
      const ratio = (100 * y / (h.scrollHeight - h.clientHeight)) || 0;
      progress.style.width = ratio + '%';
    }
  };
  window.addEventListener('scroll', onScroll, { passive:true });
  onScroll();
  toTop.addEventListener('click', ()=> window.scrollTo({ top:0, behavior:'smooth' }));

  // ===== Animate on scroll
  const io = new IntersectionObserver((entries)=>{
    entries.forEach(e=>{
      if(e.isIntersecting){ e.target.classList.add('is-inview'); io.unobserve(e.target); }
    });
  }, { threshold:.18 });
  document.querySelectorAll('[data-animate]').forEach(el=> io.observe(el));

  // ===== Counters
  const counters = document.querySelectorAll('[data-counter]');
  const cIO = new IntersectionObserver((entries)=>{
    entries.forEach(e=>{
      if(!e.isIntersecting) return;
      animateCount(e.target, parseInt(e.target.dataset.counter,10) || 0);
      cIO.unobserve(e.target);
    });
  }, { threshold:.7 });
  counters.forEach(el=> cIO.observe(el));

  function animateCount(el, target){
    const start = performance.now(), dur = 900, from = 0;
    const step = (t)=>{
      const p = Math.min(1, (t - start)/dur);
      const val = Math.floor(from + (target - from) * (1 - Math.pow(1-p,3)));
      el.textContent = val.toLocaleString('fr-FR');
      if(p<1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  }

  // ===== Charts (lazy)
  if (window.Chart) {
    const chartIO = new IntersectionObserver((entries)=>{
      entries.forEach(e=>{
        if(!e.isIntersecting) return;
        const c = e.target, type = c.dataset.chart;
        if(type==='bars-week') barsWeek(c);
        if(type==='donut-macros') donutMacros(c);
        if(type==='line-cardio') lineCardio(c);
        chartIO.unobserve(c);
      });
    }, { threshold:.2 });
    document.querySelectorAll('canvas[data-chart]').forEach(cv=> chartIO.observe(cv));
  }

  // ===== Chart configs
  const grid = '#e9ecf3';
  const ticks = '#667085';
  const prot = getCSS('--prot') || '#6e8efb';
  const glu  = getCSS('--glu')  || '#60a5fa';
  const lip  = getCSS('--lip')  || '#faca63';
  const primary = getCSS('--primary') || '#4c5bf9';
  const green   = getCSS('--green')   || '#45c778';

  function baseOpts(){
    return {
      responsive:true, maintainAspectRatio:false,
      plugins:{ legend:{ display:false }, tooltip:{ enabled:true } },
      scales:{
        x:{ grid:{ color:grid }, ticks:{ color:ticks } },
        y:{ grid:{ color:grid }, ticks:{ color:ticks }, beginAtZero:true }
      }
    };
  }

  function barsWeek(canvas){
    new Chart(canvas.getContext('2d'),{
      type:'bar',
      data:{
        labels:['L','M','M','J','V','S','D'],
        datasets:[
          { label:'Ingrédient', data:[600,540,520,680,700,750,680], backgroundColor:primary, borderRadius:8, barThickness:16 },
          { label:'Dépensées', data:[2200,2300,2100,2400,2550,2700,2450], backgroundColor:green, borderRadius:8, barThickness:16 }
        ]
      },
      options: { ...baseOpts(), scales:{ ...baseOpts().scales, y:{ ...baseOpts().scales.y, suggestedMax:3000 } } }
    });
  }

  function donutMacros(canvas){
    new Chart(canvas.getContext('2d'),{
      type:'doughnut',
      data:{
        labels:['Protéines','Glucides','Lipides'],
        datasets:[{ data:[25,50,25], backgroundColor:[prot, glu, lip], borderWidth:0, hoverOffset:4, cutout:'65%' }]
      },
      options:{ plugins:{ legend:{ display:false } } }
    });
  }

  function lineCardio(canvas){
    new Chart(canvas.getContext('2d'),{
      type:'line',
      data:{
        labels:['L','M','M','J','V','S','D'],
        datasets:[{
          data:[20,35,28,40,32,55,30],
          borderColor:primary, backgroundColor:'rgba(76,91,249,.12)',
          tension:.35, fill:true, pointRadius:3, pointBackgroundColor:'#fff', borderWidth:3
        }]
      },
      options:{ ...baseOpts(), scales:{ x:{ grid:{ color:'transparent' } }, y:{ beginAtZero:true, suggestedMax:60 } } }
    });
  }

  function getCSS(varName){
    return getComputedStyle(document.documentElement).getPropertyValue(varName).trim();
  }
});

/* minimal styles pour le bouton top (s’appuie sur ta base) */
(function(){
  const css = `
  .to-top{position:fixed;right:16px;bottom:16px;border:1px solid #dfe3ea;background:#fff;border-radius:10px;
          width:42px;height:42px;font-weight:800;box-shadow:0 10px 20px rgba(0,0,0,.08);display:none;cursor:pointer}
  .to-top.show{display:block}`;
  const s=document.createElement('style'); s.textContent=css; document.head.appendChild(s);
})();
