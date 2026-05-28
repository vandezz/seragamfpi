<?php
// chatadmin.php – halaman admin untuk kelola chat karyawan
$BASE = base_url();
?>
<div class="row">
<div class="col-12 col-lg-4">
  <div class="card card-warning card-outline">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-list mr-2"></i>Daftar Chat Karyawan</h3>
    </div>
    <div class="card-body p-0">
      <?php if(empty($threads)): ?>
        <p class="text-muted text-center py-4">Belum ada pesan masuk.</p>
      <?php else: ?>
      <ul class="list-group list-group-flush" id="thread-list">
        <?php foreach($threads as $t): ?>
        <li class="list-group-item list-group-item-action thread-item d-flex justify-content-between align-items-start"
            style="cursor:pointer"
            data-idk="<?= (int)$t->id_karyawan ?>"
            data-nama="<?= htmlspecialchars($t->nama_karyawan) ?>">
          <div>
            <strong><?= htmlspecialchars($t->nama_karyawan) ?></strong>
            <br><small class="text-muted"><?= htmlspecialchars($t->kd_bagian) ?></small>
            <br><small class="text-muted" style="max-width:180px;display:inline-block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
              <?= htmlspecialchars($t->pesan_terakhir ?: '') ?>
            </small>
          </div>
          <div class="text-right ml-2">
            <small class="text-muted d-block"><?= $t->waktu_terakhir ? date('d/m H:i', strtotime($t->waktu_terakhir)) : '' ?></small>
            <?php if($t->belum_dibaca > 0): ?>
            <span class="badge badge-warning badge-pill"><?= (int)$t->belum_dibaca ?></span>
            <?php endif; ?>
          </div>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="col-12 col-lg-8">
  <div class="card card-warning card-outline" id="chat-panel" style="display:none">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-comments mr-2"></i>Chat dengan: <span id="chat-nama">-</span></h3>
    </div>
    <div class="card-body p-0">
      <div id="chat-box"
           style="height:400px;overflow-y:auto;padding:12px;background:#f9f9f9;border-bottom:1px solid #dee2e6">
        <p class="text-muted text-center small mt-5" id="chat-empty">Pilih karyawan untuk melihat pesan.</p>
      </div>
      <div class="input-group p-2" style="background:#fff">
        <input type="text" id="chat-input" class="form-control"
               placeholder="Balas pesan..." maxlength="500" autocomplete="off">
        <div class="input-group-append">
          <button class="btn btn-warning" id="chat-send"><i class="fas fa-paper-plane"></i></button>
        </div>
      </div>
    </div>
  </div>
  <div class="card card-outline" id="chat-placeholder">
    <div class="card-body text-center text-muted py-5">
      <i class="fas fa-comments fa-3x mb-3 d-block"></i>
      Pilih karyawan di sebelah kiri untuk membuka percakapan.
    </div>
  </div>
</div>
</div>

<script>
(function(){
  var BASE     = '<?= $BASE ?>';
  var curIdk   = 0;
  var lastId   = 0;
  var pollTimer= null;

  function renderMsg(m) {
    var isMine = (m.role === 1);
    var bg     = isMine ? '#d4edda' : '#fff';
    var align  = isMine ? 'text-right' : 'text-left';
    var el     = document.createElement('div');
    el.className = 'mb-2 ' + align;
    el.innerHTML =
      '<small class="text-muted">' + (isMine ? '<b>Admin</b>' : '<b>' + m.nama + '</b>') + ' &bull; ' + m.waktu + '</small>' +
      '<div class="d-inline-block px-3 py-2 rounded" style="background:' + bg + ';max-width:85%;border:1px solid #ced4da;word-break:break-word">' + m.pesan + '</div>';
    return el;
  }

  function appendMessages(list) {
    if(!list.length) return;
    var box   = document.getElementById('chat-box');
    var empty = document.getElementById('chat-empty');
    if(empty) empty.remove();
    list.forEach(function(m){ box.appendChild(renderMsg(m)); lastId = m.id; });
    box.scrollTop = box.scrollHeight;
  }

  function loadThread(idk) {
    if(!idk) return;
    lastId  = 0;
    curIdk  = idk;
    var box = document.getElementById('chat-box');
    box.innerHTML = '<p class="text-muted text-center small mt-5" id="chat-empty">Memuat...</p>';
    fetch(BASE + 'index.php/page/chatAmbil?id_karyawan=' + idk + '&after_id=0')
      .then(function(r){ return r.json(); })
      .then(function(data){
        box.innerHTML = '';
        if(data.length){
          appendMessages(data);
        } else {
          box.innerHTML = '<p class="text-muted text-center small mt-5" id="chat-empty">Belum ada pesan.</p>';
        }
      });
  }

  function poll() {
    if(!curIdk) return;
    fetch(BASE + 'index.php/page/chatAmbil?id_karyawan=' + curIdk + '&after_id=' + lastId)
      .then(function(r){ return r.json(); })
      .then(function(data){ appendMessages(data); })
      .catch(function(){});
  }

  // Pilih thread
  document.querySelectorAll('.thread-item').forEach(function(el){
    el.addEventListener('click', function(){
      document.querySelectorAll('.thread-item').forEach(function(x){ x.classList.remove('active'); });
      el.classList.add('active');
      var idk  = parseInt(el.getAttribute('data-idk'));
      var nama = el.getAttribute('data-nama');
      document.getElementById('chat-nama').textContent = nama;
      document.getElementById('chat-panel').style.display = '';
      document.getElementById('chat-placeholder').style.display = 'none';
      loadThread(idk);
      // hapus badge
      var badge = el.querySelector('.badge-pill');
      if(badge) badge.remove();
    });
  });

  // Kirim
  function kirim(){
    var input = document.getElementById('chat-input');
    var pesan = input.value.trim();
    if(!pesan || !curIdk) return;
    input.disabled = true;
    var fd = new FormData();
    fd.append('pesan', pesan);
    fd.append('id_karyawan', curIdk);
    fetch(BASE + 'index.php/page/chatKirim', {method:'POST', body:fd})
      .then(function(r){ return r.json(); })
      .then(function(res){
        if(res.ok){ input.value = ''; poll(); }
        else alert('Gagal: ' + (res.msg || ''));
      })
      .catch(function(){ alert('Gagal mengirim.'); })
      .finally(function(){ input.disabled = false; input.focus(); });
  }

  document.getElementById('chat-send').addEventListener('click', kirim);
  document.getElementById('chat-input').addEventListener('keydown', function(e){
    if(e.key === 'Enter') kirim();
  });

  // Auto-poll setiap 8 detik
  setInterval(poll, 8000);
})();
</script>
