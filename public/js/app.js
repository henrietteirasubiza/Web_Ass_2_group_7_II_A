// UniStack — app.js

// ── JS Polling (simulated real-time update every 10s) ──
let pollTimer;
function startPolling() {
  const indicator = document.getElementById('poll-indicator');
  if (!indicator) return;

  pollTimer = setInterval(() => {
    fetch(window.location.href)
      .then(r => r.text())
      .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newGrid = doc.querySelector('#posts-container');
        const curGrid = document.getElementById('posts-container');
        if (newGrid && curGrid && newGrid.innerHTML !== curGrid.innerHTML) {
          curGrid.innerHTML = newGrid.innerHTML;
          showToast('📬 New posts loaded!');
        }
      }).catch(() => {});
  }, 10000); // every 10 seconds
}

function showToast(msg) {
  const t = document.createElement('div');
  t.style.cssText = `
    position:fixed; bottom:1.5rem; right:1.5rem; z-index:9999;
    background:#1d4ed8; color:white; padding:.75rem 1.25rem;
    border-radius:8px; font-size:.9rem; box-shadow:0 4px 16px rgba(0,0,0,.2);
    animation: fadeIn .3s ease;
  `;
  t.textContent = msg;
  document.body.appendChild(t);
  setTimeout(() => t.remove(), 3000);
}

// ── Report Modal ──
function openReportModal(postId) {
  document.getElementById('report-post-id').value = postId;
  document.getElementById('report-modal').style.display = 'flex';
}
function closeReportModal() {
  document.getElementById('report-modal').style.display = 'none';
}

// Close modal on backdrop click
document.addEventListener('click', (e) => {
  const modal = document.getElementById('report-modal');
  if (modal && e.target === modal) closeReportModal();
});

// ── Price display helper (for_sale posts) ──
function formatRWF(n) {
  return new Intl.NumberFormat('rw-RW').format(n) + ' RWF';
}

// Auto-dismiss alerts after 5s
document.addEventListener('DOMContentLoaded', () => {
  startPolling();

  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(a => {
    setTimeout(() => {
      a.style.transition = 'opacity .5s';
      a.style.opacity = '0';
      setTimeout(() => a.remove(), 500);
    }, 5000);
  });

  // Confirm on delete
  document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', (e) => {
      if (!confirm(el.dataset.confirm)) e.preventDefault();
    });
  });

  // Mobile menu toggle with improved UX
  const toggleBtn = document.getElementById('nav-toggle-btn');
  const navMenu = document.getElementById('nav-menu');
  const sidebar = document.querySelector('.sidebar');
  const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
  
  // Sidebar toggle
  if (sidebarToggleBtn && sidebar) {
    sidebarToggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      sidebarToggleBtn.classList.toggle('active');
      sidebar.classList.toggle('open');
      document.body.classList.toggle('sidebar-open');
    });
  }
  
  function closeNavMenu() {
    if (toggleBtn) toggleBtn.classList.remove('active');
    if (navMenu) navMenu.classList.remove('open');
    const icon = toggleBtn ? toggleBtn.querySelector('i') : null;
    if (icon) { icon.classList.add('fa-bars'); icon.classList.remove('fa-times'); }
  }

  if (toggleBtn && navMenu) {
    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const opening = !navMenu.classList.contains('open');
      toggleBtn.classList.toggle('active');
      navMenu.classList.toggle('open');
      const icon = toggleBtn.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-bars', !opening);
        icon.classList.toggle('fa-times', opening);
      }
      if (sidebar) sidebar.classList.remove('open');
      if (sidebarToggleBtn) sidebarToggleBtn.classList.remove('active');
    });

    navMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => closeNavMenu());
    });

    document.addEventListener('click', (e) => {
      if (!toggleBtn.contains(e.target) && !navMenu.contains(e.target)) {
        if (navMenu.classList.contains('open')) closeNavMenu();
      }
    });
  }

  // Close sidebar when clicking outside
  if (sidebar) {
    document.addEventListener('click', (e) => {
      if (!sidebar.contains(e.target) && !sidebarToggleBtn?.contains(e.target)) {
        if (sidebar.classList.contains('open')) {
          sidebar.classList.remove('open');
          if (sidebarToggleBtn) sidebarToggleBtn.classList.remove('active');
          document.body.classList.remove('sidebar-open');
        }
      }
    });
  }

  // Sidebar links should close sidebar on mobile
  const navLinks = document.querySelectorAll('.sidebar a');
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      if (sidebar && window.innerWidth < 768) {
        sidebar.classList.remove('open');
        if (sidebarToggleBtn) sidebarToggleBtn.classList.remove('active');
        document.body.classList.remove('sidebar-open');
      }
    });
  });

  // Avatar dropdown
  const avatarBtn = document.getElementById('avatar-btn');
  const avatarMenu = document.getElementById('avatar-menu');
  if (avatarBtn && avatarMenu) {
    avatarBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      avatarMenu.parentElement.classList.toggle('open');
    });
    document.addEventListener('click', (e) => {
      if (!avatarMenu.contains(e.target) && avatarMenu.parentElement.classList.contains('open')) {
        avatarMenu.parentElement.classList.remove('open');
      }
    });
  }

  // Real-time search with suggestions
  const searchInput = document.getElementById('search-input');
  const suggestionsBox = document.getElementById('search-suggestions');
  const searchForm = document.getElementById('search-form');
  
  if (searchInput) {
    let searchTimeout;
    searchInput.addEventListener('input', (e) => {
      clearTimeout(searchTimeout);
      const query = e.target.value.trim();
      
      if (query.length >= 2) {
        searchTimeout = setTimeout(async () => {
          try {
            const response = await fetch(`index.php?page=api&action=search&q=${encodeURIComponent(query)}`);
            const results = await response.json();
            
            if (results.length > 0) {
              suggestionsBox.innerHTML = results.map(post => `
                <div class="search-suggestion-item" onclick="document.getElementById('search-input').value = '${post['title'].replace(/'/g, "\\'")}';
                  searchForm.submit();">
                  <div class="search-suggestion-item-title">${post['title']}</div>
                  <div class="search-suggestion-item-type"><i class="fas fa-tag"></i> ${post['type'].replace('_', ' ')}</div>
                </div>
              `).join('');
              suggestionsBox.classList.add('show');
            } else {
              suggestionsBox.classList.remove('show');
            }
          } catch (err) {
            console.error('Search error:', err);
          }
        }, 300);
      } else {
        suggestionsBox.classList.remove('show');
      }
    });

    // Close suggestions when clicking outside
    document.addEventListener('click', (e) => {
      if (e.target !== searchInput && !suggestionsBox.contains(e.target)) {
        suggestionsBox.classList.remove('show');
      }
    });
  }
});
