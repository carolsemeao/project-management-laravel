import './bootstrap';
import './issue';
import './projects';
import { themeChange } from 'theme-change';
themeChange();

// Import Chart.js and make it available globally
import Chart from 'chart.js/auto';
window.Chart = Chart;

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
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

	// Toast notifications - replaced Bootstrap with custom implementation
	const toastElements = document.querySelectorAll('.toast');
	if (toastElements.length > 0) {
		toastElements.forEach(function (toastElement) {
			// Show toast and auto-hide after delay
			toastElement.style.display = 'block';
			const delay = toastElement.dataset.delay || 5000;
			setTimeout(() => {
				toastElement.style.display = 'none';
			}, delay);

			// Handle close button
			const closeBtn = toastElement.querySelector('.toast-close');
			if (closeBtn) {
				closeBtn.addEventListener('click', () => {
					toastElement.style.display = 'none';
				});
			}
		});
	}
});
