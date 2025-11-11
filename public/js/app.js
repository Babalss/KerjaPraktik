// Interaksi sidebar/navbar: tutup HANYA saat klik overlay / ESC / resize ke desktop
document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggle  = document.getElementById('menu-toggle');

  const isMobile = () => window.innerWidth < 992;

  const openSidebar = () => {
    sidebar?.classList.add('open');
    overlay?.classList.add('show');
    document.body.classList.add('no-scroll');
  };

  const closeSidebar = () => {
    sidebar?.classList.remove('open');
    overlay?.classList.remove('show');
    document.body.classList.remove('no-scroll');
  };

  // Toggle tombol hamburger
  toggle?.addEventListener('click', (e) => {
    e.preventDefault();
    sidebar?.classList.contains('open') ? closeSidebar() : openSidebar();
  });

  // Klik area luar (overlay) → tutup
  overlay?.addEventListener('click', closeSidebar);

  // Tekan ESC → tutup
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeSidebar();
  });

  // Balik ke desktop → paksa tutup, biar layout bersih
  window.addEventListener('resize', () => {
    if (!isMobile()) closeSidebar();
  });

  // MUHIM: hilangkan handler yang menutup saat klik menu/dropdown
  // (tidak ada listener untuk .sidebar a[...] maupun shown.bs.collapse)
});
