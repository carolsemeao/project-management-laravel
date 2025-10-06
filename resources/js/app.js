import './bootstrap';
import './projects';
import './modal';
import { themeChange } from 'theme-change';
themeChange();

// Import Cally calendar web component
import 'cally';

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

document.addEventListener('DOMContentLoaded', function () {
	// Universal Calendar date picker functionality
	function initializeCalendarPicker(calendarElement) {
		if (!calendarElement) return;

		// Find related elements based on the calendar's container
		const container =
			calendarElement.closest('[popover]') ||
			calendarElement.closest('.dropdown');
		if (!container) return;

		// Find the popover trigger button and hidden input
		const popoverId = container.id;
		const triggerButton = document.querySelector(
			`[popovertarget="${popoverId}"]`
		);
		if (!triggerButton) return;

		// Extract the base name from popover ID (e.g., "work_date-popover" -> "work_date")
		const baseName = popoverId.replace('-popover', '');
		const hiddenInput = document.getElementById(baseName);
		const selectedDateText =
			triggerButton.querySelector(`#${baseName}_selected_date_text`) ||
			triggerButton.querySelector('#selected_date_text') ||
			triggerButton.querySelector('span:last-child');

		if (!hiddenInput || !selectedDateText) return;

		// Listen for date selection on the calendar
		calendarElement.addEventListener('change', function (event) {
			const selectedDate = event.target.value;
			if (selectedDate) {
				// Update hidden input with ISO format for form submission
				hiddenInput.value = selectedDate;

				// Update display text with formatted date
				const date = new Date(selectedDate);
				const formattedDate = date.toLocaleDateString('de-CH', {
					day: '2-digit',
					month: '2-digit',
					year: 'numeric',
				});
				selectedDateText.textContent = formattedDate;

				// Close the popover smoothly without causing layout shifts
				if (container && container.hidePopover) {
					// Use requestAnimationFrame to ensure smooth closing
					requestAnimationFrame(() => {
						container.hidePopover();
					});
				}
			}
		});
	}

	// Initialize all calendar pickers on the page
	const allCalendarPickers = document.querySelectorAll('calendar-date.cally');
	allCalendarPickers.forEach(initializeCalendarPicker);

	// Estimated time conversion (hours to minutes)
	const estimatedHoursInput = document.querySelector(
		'input[name="estimated_time_hours"]'
	);
	const estimatedMinutesInput = document.querySelector(
		'input[name="estimated_time_minutes"]'
	);

	if (estimatedHoursInput && estimatedMinutesInput) {
		estimatedHoursInput.addEventListener('input', function () {
			const hours = parseFloat(this.value) || 0;
			const minutes = Math.round(hours * 60);
			estimatedMinutesInput.value = minutes;
		});

		// Set initial value if hours field has a value
		if (estimatedHoursInput.value) {
			const hours = parseFloat(estimatedHoursInput.value) || 0;
			estimatedMinutesInput.value = Math.round(hours * 60);
		}
	}
});
