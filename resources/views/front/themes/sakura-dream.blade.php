<?php
/* ============================================================
   TEMA PREMIUM: SAKURA DREAM
   Dipilih via settings: theme = sakura-dream
   ============================================================ */
$GLOBALS['mc_settings'] = $settings ?? [];
if (!function_exists('mcGet')) {
  function mcGet($key, $default = '') {
    $s = $GLOBALS['mc_settings'];
    if (!isset($s[$key]) || trim((string)$s[$key]) === '') return $default;
    return $s[$key];
  }
}
if (!function_exists('mcDate')) {
  function mcDate($dateStr) {
    if (!$dateStr) return '';
    $days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $months = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $ts = strtotime($dateStr);
    if (!$ts) return $dateStr;
    return $days[date('w',$ts)].', '.date('j',$ts).' '.$months[date('n',$ts)].' '.date('Y',$ts);
  }
}
if (!function_exists('mcTime')) {
  function mcTime($t) {
    $t = trim((string)$t); if ($t === '') return '08:00';
    $t = str_replace('.', ':', $t);
    return preg_match('/^\d{1,2}(:\d{2})?$/', $t) ? (strpos($t, ':') === false ? $t.':00' : $t) : '08:00';
  }
}
$groomNick = mcGet('groom_nickname') ?: mcGet('groom_name', 'Mempelai Pria');
$brideNick = mcGet('bride_nickname') ?: mcGet('bride_name', 'Mempelai Wanita');
$groomFull = mcGet('groom_name', 'Mempelai Pria');
$brideFull = mcGet('bride_name', 'Mempelai Wanita');
$wDate  = mcGet('wedding_date', date('Y-m-d'));
$wTime  = mcTime(mcGet('wedding_time_start', '08:00'));
$wTimeE = mcTime(mcGet('wedding_time_end', '10:00'));
$rDate  = mcGet('reception_date', $wDate);
$rTimeS = mcTime(mcGet('reception_time_start', '11:00'));
$rTimeE = mcTime(mcGet('reception_time_end', '13:00'));
$countdownISO = $wDate.'T'.$wTime.':00+07:00';
$accounts = [];
if (mcGet('gift_account')) $accounts[] = ['bank'=>mcGet('gift_bank','Bank'),'no'=>mcGet('gift_account'),'an'=>mcGet('gift_owner','')];
if (mcGet('gift_account2')) $accounts[] = ['bank'=>mcGet('gift_bank2','Bank'),'no'=>mcGet('gift_account2'),'an'=>mcGet('gift_owner2','')];
$musicUrl = null;
if (!empty($musicRecord) && !empty($musicRecord->file_path)) {
  $mp = $musicRecord->file_path;
  $musicUrl = (str_starts_with($mp,'http') || str_starts_with($mp,'/')) ? $mp : asset('storage/'.ltrim($mp,'/'));
}
$invId = $inv_id ?? 0;
$groomPhoto = mcGet('groom_photo'); $bridePhoto = mcGet('bride_photo');
$groomInitial = mb_substr($groomNick, 0, 1); $brideInitial = mb_substr($brideNick, 0, 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $brideNick }} &amp; {{ $groomNick }} — Sakura Dream</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Shippori+Mincho:wght@400;600&family=Jost:wght@300;400&display=swap" rel="stylesheet">
<style>
:root{--blush:#faf3f1;--sakura:#e88ca0;--sakura-dk:#c96a82;--ink:#5a3d42;--ink-dim:rgba(90,61,66,.62);--card:#ffffff}
*{margin:0;padding:0;box-sizing:border-box;-webkit-tap-highlight-color:transparent}
html{scroll-behavior:smooth}
body{font-family:'Jost',sans-serif;background:linear-gradient(180deg,#fdf8f6 0%,var(--blush) 40%,#f7e9ec 100%);color:var(--ink);overflow-x:hidden;font-weight:300}
#petals{position:fixed;inset:0;z-index:1;pointer-events:none}
.wrap{position:relative;z-index:2;max-width:520px;margin:0 auto}
.serif{font-family:'Cormorant Garamond',serif}.jp{font-family:'Shippori Mincho',serif}
#cover{position:fixed;inset:0;z-index:100;background:linear-gradient(180deg,#fdeef1,#f7dce3);display:flex;align-items:center;justify-content:center;transition:opacity .9s,visibility .9s}
#cover.open{opacity:0;visibility:hidden}
.cover-card{text-align:center;padding:46px 32px;margin:24px;max-width:400px;background:rgba(255,255,255,.72);backdrop-filter:blur(6px);border:1px solid rgba(232,140,160,.4);box-shadow:0 24px 60px rgba(201,106,130,.18)}
.branch{font-size:44px;letter-spacing:.3em;color:var(--sakura)}
.kicker{font-size:11px;letter-spacing:.44em;text-transform:uppercase;color:var(--sakura-dk);margin-top:8px}
.cover-names{font-family:'Cormorant Garamond',serif;font-size:46px;margin:14px 0;line-height:1.15;font-weight:500}
.cover-names em{font-family:'Shippori Mincho',serif;font-size:30px;color:var(--sakura-dk)}
.btn{display:inline-block;margin-top:24px;padding:14px 44px;background:var(--sakura-dk);color:#fff;font-size:12px;letter-spacing:.3em;text-transform:uppercase;cursor:pointer;border:none;border-radius:999px;font-family:'Jost';transition:.35s;box-shadow:0 10px 26px rgba(201,106,130,.35)}
.btn:hover{transform:translateY(-2px);box-shadow:0 14px 32px rgba(201,106,130,.5)}
.btn-line{display:inline-block;padding:12px 34px;border:1px solid var(--sakura-dk);color:var(--sakura-dk);font-size:12px;letter-spacing:.26em;text-transform:uppercase;cursor:pointer;background:transparent;border-radius:999px;transition:.3s;text-decoration:none;font-family:'Jost'}
.btn-line:hover{background:rgba(232,140,160,.12)}
.guest{margin-top:18px;font-size:13px;color:var(--ink-dim)}
.guest b{display:block;font-family:'Cormorant Garamond',serif;font-size:23px;color:var(--ink);margin-top:6px}
section{padding:68px 26px;text-align:center}
.sec-kicker{font-size:11px;letter-spacing:.44em;text-transform:uppercase;color:var(--sakura-dk);margin-bottom:10px}
.sec-title{font-family:'Cormorant Garamond',serif;font-size:38px;font-weight:500}
.hanami{display:flex;align-items:center;justify-content:center;gap:12px;margin:14px auto;max-width:260px;color:var(--sakura)}
.hanami::before,.hanami::after{content:'';height:1px;flex:1;background:linear-gradient(90deg,transparent,var(--sakura))}
.hanami::after{background:linear-gradient(90deg,var(--sakura),transparent)}
#hero{min-height:94vh;display:flex;flex-direction:column;justify-content:center}
.hero-names{font-family:'Cormorant Garamond',serif;font-size:54px;line-height:1.08;margin:14px 0;font-weight:500}
.hero-names em{font-family:'Shippori Mincho',serif;color:var(--sakura-dk);font-size:38px}
.hero-date{letter-spacing:.32em;font-size:13px;color:var(--ink-dim);text-transform:uppercase}
.cd-grid{display:flex;justify-content:center;gap:10px;margin-top:26px}
.cd{width:72px;padding:16px 0;background:var(--card);border-radius:18px;box-shadow:0 8px 24px rgba(201,106,130,.14)}
.cd b{display:block;font-family:'Cormorant Garamond',serif;font-size:34px;color:var(--sakura-dk)}
.cd span{font-size:10px;letter-spacing:.28em;text-transform:uppercase;color:var(--ink-dim)}
.photo{width:150px;height:150px;border-radius:50%;object-fit:cover;margin:0 auto 16px;border:4px solid #fff;box-shadow:0 12px 30px rgba(201,106,130,.25);display:block}
.photo-fallback{width:150px;height:150px;border-radius:50%;margin:0 auto 16px;background:linear-gradient(135deg,#f7dce3,#f2b8c6);display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:62px;color:#fff}
.couple-card{background:var(--card);border-radius:26px;padding:36px 24px;margin:0 auto 18px;max-width:380px;box-shadow:0 16px 44px rgba(201,106,130,.14)}
.couple-card h3{font-family:'Cormorant Garamond',serif;font-size:32px}
.couple-card .full{font-size:15px;color:var(--ink-dim);margin:6px 0}
.couple-card p{font-size:14px;color:var(--ink-dim);line-height:1.7}
.amp{font-family:'Shippori Mincho',serif;font-size:40px;color:var(--sakura);margin:2px 0}
.event{background:var(--card);border-radius:26px;padding:36px 24px;margin:0 auto 18px;max-width:400px;box-shadow:0 16px 44px rgba(201,106,130,.14)}
.event h3{font-family:'Cormorant Garamond',serif;font-size:28px;letter-spacing:.1em;color:var(--sakura-dk)}
.event .date{font-family:'Cormorant Garamond',serif;font-size:20px;margin:12px 0 4px}
.event .time{letter-spacing:.22em;font-size:13px;color:var(--sakura-dk)}
.event .loc{font-size:14px;color:var(--ink-dim);margin:12px 0 18px;line-height:1.7}
.g-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:24px}
.g-grid img{width:100%;height:190px;object-fit:cover;border-radius:18px;transition:.4s;box-shadow:0 8px 22px rgba(201,106,130,.14)}
.g-grid img:hover{transform:scale(1.03)}
.tl{max-width:400px;margin:26px auto 0;text-align:left}
.tl-item{background:var(--card);border-radius:18px;padding:20px;margin-bottom:14px;box-shadow:0 10px 28px rgba(201,106,130,.12)}
.tl-item h4{font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--sakura-dk)}
.tl-item p{font-size:14px;color:var(--ink-dim);line-height:1.7;margin-top:6px}
.field{margin:0 auto 14px;max-width:380px;text-align:left}
.field label{display:block;font-size:10px;letter-spacing:.32em;text-transform:uppercase;color:var(--sakura-dk);margin-bottom:8px}
.field input,.field select,.field textarea{width:100%;background:var(--card);border:1px solid rgba(232,140,160,.4);border-radius:14px;color:var(--ink);padding:13px 16px;font-family:'Jost';font-size:15px;outline:none}
.field input:focus,.field select:focus,.field textarea:focus{border-color:var(--sakura-dk);box-shadow:0 0 0 3px rgba(232,140,160,.15)}
.wish{background:var(--card);border-radius:16px;padding:16px 18px;margin:0 auto 12px;max-width:400px;text-align:left;box-shadow:0 8px 22px rgba(201,106,130,.1)}
.wish b{font-family:'Cormorant Garamond',serif;color:var(--sakura-dk);font-size:17px}
.wish .st{font-size:10px;letter-spacing:.2em;color:var(--sakura);text-transform:uppercase;margin-left:8px}
.wish p{font-size:14px;color:var(--ink-dim);margin-top:6px;line-height:1.6}
.bank{background:var(--card);border-radius:20px;padding:24px;margin:0 auto 14px;max-width:380px;box-shadow:0 12px 32px rgba(201,106,130,.14)}
.bank .bk{font-size:11px;letter-spacing:.34em;color:var(--sakura-dk);text-transform:uppercase}
.bank .no{font-family:'Cormorant Garamond',serif;font-size:30px;margin:10px 0 4px;letter-spacing:.06em}
.bank .an{font-size:14px;color:var(--ink-dim)}
.copy{margin-top:12px}
footer{padding:60px 26px 90px;text-align:center}
footer .jp{font-size:34px;color:var(--sakura-dk)}
#musBtn{position:fixed;bottom:22px;right:22px;z-index:90;width:52px;height:52px;border-radius:50%;border:none;background:var(--sakura-dk);color:#fff;font-size:20px;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 26px rgba(201,106,130,.4)}
.rv{opacity:0;transform:translateY(36px);transition:opacity .9s,transform .9s}
.rv.on{opacity:1;transform:none}
@media(min-width:640px){.hero-names{font-size:66px}}
</style>
</head>
<body>
<canvas id="petals"></canvas>
<div class="wrap">

<div id="cover">
  <div class="cover-card">
    <div class="branch">🌸</div>
    <div class="kicker">Undangan Pernikahan</div>
    <div class="cover-names">{{ $brideNick }} <em>&amp;</em> {{ $groomNick }}</div>
    <div class="jp" style="color:var(--sakura-dk);letter-spacing:.5em;font-size:13px">ご招待</div>
    <div class="guest">Kepada Yth.<br>Bapak/Ibu/Saudara/i<b>{{ $guestName }}</b></div>
    <button class="btn" onclick="openInv()">Buka Undangan</button>
  </div>
</div>

<section id="hero">
  <div class="rv"><div class="jp" style="color:var(--sakura-dk);letter-spacing:.5em;font-size:14px">結婚式</div></div>
  <div class="rv"><h1 class="hero-names">{{ $brideNick }} <em>&amp;</em> {{ $groomNick }}</h1></div>
  <div class="rv"><div class="hanami">🌸</div></div>
  <div class="rv"><div class="hero-date">{{ mcDate($wDate) }}</div></div>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Menuju Hari Bahagia</div><div class="sec-title serif">Hitung Mundur</div><div class="hanami">🌸</div></div>
  <div class="cd-grid rv">
    <div class="cd"><b id="cdD">0</b><span>Hari</span></div>
    <div class="cd"><b id="cdH">0</b><span>Jam</span></div>
    <div class="cd"><b id="cdM">0</b><span>Menit</span></div>
    <div class="cd"><b id="cdS">0</b><span>Detik</span></div>
  </div>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Assalamu'alaikum Wr. Wb.</div><div class="sec-title serif">Mempelai</div><div class="hanami">🌸</div></div>
  <div class="couple-card rv">
    @if($bridePhoto)<img class="photo" src="{{ $bridePhoto }}" alt="{{ $brideFull }}">@else<div class="photo-fallback">{{ $brideInitial }}</div>@endif
    <h3>{{ $brideNick }}</h3><div class="full">{{ $brideFull }}</div>
    <p>Putri dari<br>{{ mcGet('bride_parents', mcGet('bride_child_of', '')) }}</p>
  </div>
  <div class="amp rv">🌸</div>
  <div class="couple-card rv">
    @if($groomPhoto)<img class="photo" src="{{ $groomPhoto }}" alt="{{ $groomFull }}">@else<div class="photo-fallback">{{ $groomInitial }}</div>@endif
    <h3>{{ $groomNick }}</h3><div class="full">{{ $groomFull }}</div>
    <p>Putra dari<br>{{ mcGet('groom_parents', mcGet('groom_child_of', '')) }}</p>
  </div>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Waktu &amp; Tempat</div><div class="sec-title serif">Rangkaian Acara</div><div class="hanami">🌸</div></div>
  <div class="event rv">
    <h3>Akad Nikah</h3>
    <div class="date">{{ mcDate($wDate) }}</div><div class="time">{{ $wTime }} — {{ $wTimeE }} WIB</div>
    <div class="loc">{{ mcGet('wedding_location', 'Kediaman Mempelai') }}</div>
    @if(mcGet('wedding_map_link'))<a class="btn-line" target="_blank" href="{{ mcGet('wedding_map_link') }}">Lihat Peta</a>@endif
  </div>
  <div class="event rv">
    <h3>Resepsi</h3>
    <div class="date">{{ mcDate($rDate) }}</div><div class="time">{{ $rTimeS }} — {{ $rTimeE }} WIB</div>
    <div class="loc">{{ mcGet('reception_location', mcGet('wedding_location', 'Kediaman Mempelai')) }}</div>
    @if(mcGet('reception_map_link'))<a class="btn-line" target="_blank" href="{{ mcGet('reception_map_link') }}">Lihat Peta</a>@endif
  </div>
</section>

@if(!empty($gallery))
<section>
  <div class="rv"><div class="sec-kicker">Momen Indah</div><div class="sec-title serif">Galeri</div><div class="hanami">🌸</div></div>
  <div class="g-grid rv">
    @foreach(array_slice($gallery, 0, 8) as $img)<img src="{{ $img }}" alt="Galeri" loading="lazy">@endforeach
  </div>
</section>
@endif

@if(!empty($stories) && count($stories))
<section>
  <div class="rv"><div class="sec-kicker">Perjalanan Kami</div><div class="sec-title serif">Kisah Cinta</div><div class="hanami">🌸</div></div>
  <div class="tl">
    @foreach($stories as $st)
    <div class="tl-item rv"><h4>{{ $st->title ?? 'Cerita' }}</h4><p>{{ $st->description ?? $st->content ?? '' }}</p></div>
    @endforeach
  </div>
</section>
@endif

<section>
  <div class="rv"><div class="sec-kicker">Konfirmasi</div><div class="sec-title serif">RSVP</div><div class="hanami">🌸</div></div>
  <form id="rsvpForm" class="rv" onsubmit="return sendRSVP(event)">
    <div class="field"><label>Nama Lengkap</label><input required name="name" placeholder="Nama Anda"></div>
    <div class="field"><label>Kehadiran</label><select name="status"><option value="Hadir">Hadir</option><option value="Tidak Hadir">Berhalangan</option></select></div>
    <div class="field"><label>Jumlah Tamu</label><input type="number" name="guest_count" min="1" value="1"></div>
    <button class="btn" type="submit">Kirim Konfirmasi</button>
  </form>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Doa &amp; Harapan</div><div class="sec-title serif">Ucapan</div><div class="hanami">🌸</div></div>
  <div id="wishList" class="rv"></div>
  <form id="wishForm" class="rv" onsubmit="return sendWish(event)" style="margin-top:22px">
    <div class="field"><label>Nama</label><input required name="name" placeholder="Nama Anda"></div>
    <div class="field"><label>Ucapan</label><textarea required name="message" rows="3" placeholder="Tulis doa terbaik..."></textarea></div>
    <button class="btn-line" type="submit">Kirim Ucapan</button>
  </form>
</section>

@if(!empty($accounts) || mcGet('gift_address'))
<section>
  <div class="rv"><div class="sec-kicker">Tanda Kasih</div><div class="sec-title serif">Hadiah</div><div class="hanami">🌸</div></div>
  @foreach($accounts as $a)
  <div class="bank rv"><div class="bk">{{ $a['bank'] }}</div><div class="no">{{ $a['no'] }}</div><div class="an">a.n. {{ $a['an'] }}</div>
  <button class="btn-line copy" onclick="copyNo('{{ $a['no'] }}')">Salin Nomor</button></div>
  @endforeach
  @if(mcGet('gift_address'))<div class="bank rv"><div class="bk">Hadiah Fisik</div><p style="font-size:14px;color:var(--ink-dim);margin-top:10px;line-height:1.7">{{ mcGet('gift_address') }}</p></div>@endif
</section>
@endif

<footer>
  <div class="rv"><div class="jp">ありがとう</div>
  <p style="color:var(--ink-dim);font-size:14px;line-height:1.8;max-width:380px;margin:14px auto">Terima kasih atas doa dan kehadiran Anda. Kehadiran Anda adalah hadiah terindah bagi kami.</p>
  <div class="hanami">🌸</div>
  <div class="serif" style="font-size:22px">{{ $brideNick }} &amp; {{ $groomNick }}</div></div>
</footer>
</div>

@if($musicUrl)
<audio id="mus" loop src="{{ $musicUrl }}"></audio>
<button id="musBtn" onclick="toggleMus()">♪</button>
@endif

<script>
const INV_ID = {{ (int)$invId }};
function openInv(){document.getElementById('cover').classList.add('open');document.body.style.overflow='';const m=document.getElementById('mus');if(m)m.play().catch(()=>{});}
document.body.style.overflow='hidden';
const target = new Date("{{ $countdownISO }}").getTime();
setInterval(()=>{const d=target-Date.now();if(d<0)return;
  cdD.textContent=Math.floor(d/864e5);cdH.textContent=Math.floor(d/36e5)%24;cdM.textContent=Math.floor(d/6e4)%60;cdS.textContent=Math.floor(d/1e3)%60;},1000);
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('on');io.unobserve(e.target)}}),{threshold:.12});
document.querySelectorAll('.rv').forEach(el=>io.observe(el));
// kelopak sakura
const cv=document.getElementById('petals'),cx=cv.getContext('2d');let P=[];
function rs(){cv.width=innerWidth;cv.height=innerHeight}rs();addEventListener('resize',rs);
for(let i=0;i<42;i++)P.push({x:Math.random()*innerWidth,y:Math.random()*-innerHeight,r:Math.random()*5+3,s:Math.random()*.9+.4,ph:Math.random()*6.28,sw:Math.random()*1.6+.5,rot:Math.random()*6.28,vr:(Math.random()-.5)*.02});
function petal(x,y,r,rot){cx.save();cx.translate(x,y);cx.rotate(rot);cx.fillStyle='rgba(244,167,195,.75)';
  cx.beginPath();for(let k=0;k<5;k++){const a=k/5*6.283;cx.ellipse(Math.cos(a)*r*.42,Math.sin(a)*r*.42,r*.42,r*.26,a,0,6.29)}cx.fill();cx.restore()}
(function loop(t){cx.clearRect(0,0,cv.width,cv.height);P.forEach(p=>{p.y+=p.s;p.x+=Math.sin(t/1600+p.ph)*p.sw*.5;p.rot+=p.vr;
  if(p.y>cv.height+10){p.y=-10;p.x=Math.random()*cv.width}petal(p.x,p.y,p.r,p.rot)});requestAnimationFrame(loop)})(0);
async function sendRSVP(e){e.preventDefault();const f=e.target;
  const r=await fetch('/api/rsvp.php?inv_id='+INV_ID,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({name:f.name.value,status:f.status.value,guest_count:f.guest_count.value})});
  alert(r.ok?'Terima kasih atas konfirmasinya!':'Gagal, coba lagi.');f.reset();return false;}
async function loadWishes(){try{const r=await fetch('/api/ucapan.php?inv_id='+INV_ID);const d=await r.json();
  wishList.innerHTML=(d.data||d||[]).map(w=>`<div class="wish"><b>${esc(w.name)}</b><span class="st">${esc(w.status||'')}</span><p>${esc(w.message||w.ucapan||'')}</p></div>`).join('')||'<p style="color:var(--ink-dim)">Belum ada ucapan.</p>';}catch(e){}}
function esc(s){return String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]))}
async function sendWish(e){e.preventDefault();const f=e.target;
  const r=await fetch('/api/ucapan.php?inv_id='+INV_ID,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({name:f.name.value,message:f.message.value})});
  if(r.ok){f.reset();loadWishes();}else alert('Gagal mengirim.');return false;}
loadWishes();
function copyNo(t){navigator.clipboard.writeText(t).then(()=>alert('Nomor tersalin!'));}
function toggleMus(){const m=document.getElementById('mus');if(m.paused){m.play();musBtn.style.opacity=1}else{m.pause();musBtn.style.opacity=.5}}
</script>
</body>
</html>
