import './bootstrap';
//import feather from 'feather-icons';
import './mobile-menu';
import './issue';
import './projects';

// Import Chart.js and make it available globally
import Chart from 'chart.js/auto';
window.Chart = Chart;

//feather.replace();

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
	const sidebar = document.getElementById('sidebar');
	const toggleBtn = document.getElementById('sidebarToggle');
	const closeBtn = document.getElementById('sidebarClose');
	const overlay = document.getElementById('sidebarOverlay');

	// Toggle sidebar function
	function toggleSidebar() {
		if (window.innerWidth >= 992) {
			// Desktop behavior - collapse/expand
			sidebar.classList.toggle('collapsed');
		} else {
			// Mobile behavior - show/hide with overlay
			sidebar.classList.toggle('show');
			overlay.classList.toggle('show');
			document.body.style.overflow = sidebar.classList.contains('show')
				? 'hidden'
				: '';
		}
	}

	// Close sidebar on overlay click (mobile)
	function closeSidebar() {
		sidebar.classList.remove('show');
		overlay.classList.remove('show');
		document.body.style.overflow = '';
	}

	// Event listeners
	if (toggleBtn) {
		toggleBtn.addEventListener('click', toggleSidebar);
	}

	if (closeBtn) {
		closeBtn.addEventListener('click', closeSidebar);
	}

	if (overlay) {
		overlay.addEventListener('click', closeSidebar);
	}

	// Handle window resize
	window.addEventListener('resize', function () {
		if (window.innerWidth >= 992) {
			// Desktop - remove mobile classes
			sidebar.classList.remove('show');
			if (overlay) overlay.classList.remove('show');
			document.body.style.overflow = '';
		} else {
			// Mobile - remove desktop classes
			sidebar.classList.remove('collapsed');
		}
	});

	// Close sidebar on escape key (mobile)
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && window.innerWidth < 992) {
			closeSidebar();
		}
	});

	// Initialize based on screen size
	if (window.innerWidth < 992) {
		sidebar.classList.remove('collapsed');
	}

	// Profile image upload handler - only add if element exists
	const profileImageInput = document.querySelector('#profile_image');
	const showProfileImage = document.querySelector('#show_profile_image');

	if (profileImageInput && showProfileImage) {
		profileImageInput.addEventListener('change', function (event) {
			const reader = new FileReader();
			reader.onload = function (event) {
				showProfileImage.src = event.target.result;
			};
			reader.readAsDataURL(event.target.files[0]);
		});
	}

	// Toast notifications - only show notification toasts, not status update toasts
	const toastElements = document.querySelectorAll('.toast');
	if (toastElements.length > 0) {
		toastElements.forEach(function (toastElement) {
			const toast = new bootstrap.Toast(toastElement);
			toast.show();
		});
	}
});
