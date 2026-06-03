document.addEventListener("keydown", function (e) {
  if (e.ctrlKey && e.key === "z") {
    // Ambil semua item tugas yang ada di daftar
    var items = document.querySelectorAll("#daftarTugas .list-group-item");
    if (items.length === 0) return; // Tidak ada tugas, tidak perlu lakukan apa-apa

    // Ambil item terakhir
    var last = items[items.length - 1];

    // Animasi keluar sebelum dihapus
    last.style.transition = "opacity 0.2s, transform 0.2s";
    last.style.opacity = "0";
    last.style.transform = "translateX(20px)";

    setTimeout(function () {
      last.remove();

      // Kurangi counter jumlah tugas (variabel dari embed JS)
      if (typeof jumlah !== "undefined" && jumlah > 0) {
        jumlah--;
      }

      // Perbarui teks info (fungsi dari embed JS)
      if (typeof perbaruiInfo === "function") {
        perbaruiInfo();
      }

      // Kirim log ke konsol browser
      console.log("[EKSTERNAL] Ctrl+Z — tugas terakhir di-undo");

      // Tampilkan juga di panel log jika fungsi logKe tersedia
      if (typeof logKe === "function") {
        logKe("del", "↩ Ctrl+Z — undo tugas terakhir");
      }
    }, 200);
  }
});

// Fitur 2: Animasi badge counter (opsional, mempercantik tampilan)
// Setiap kali elemen #info berubah teks, beri efek "pop"
(function () {
  var infoEl = document.getElementById("info");
  if (!infoEl) return;

  var observer = new MutationObserver(function () {
    infoEl.style.transform = "scale(1.1)";
    infoEl.style.transition = "transform 0.15s";
    setTimeout(function () {
      infoEl.style.transform = "scale(1)";
    }, 150);
  });

  observer.observe(infoEl, {
    childList: true,
    characterData: true,
    subtree: true,
  });
})();

// Featur 3: Log bahwa file eksternal berhasil dimuat
console.log("[EKSTERNAL] tugas1.js berhasil dimuat. Ctrl+Z aktif.");

// Tampilkan di panel log jika tersedia (akan dieksekusi setelah embed JS siap)
window.addEventListener("load", function () {
  if (typeof logKe === "function") {
    logKe("sys", "// Eksternal JS (tugas1.js) dimuat. Ctrl+Z aktif.");
  }
});
