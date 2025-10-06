document.addEventListener('DOMContentLoaded', function () {
	// Handle modal opening buttons
	document.querySelectorAll('[data-modal-target]').forEach((button) => {
		const modalId = button.getAttribute('data-modal-target');
		const modal = document.getElementById(modalId);

		if (modal && modal.tagName === 'DIALOG') {
			button.addEventListener('click', () => {
				modal.showModal();
				//console.log('opened: ' + modal.id);
			});
		}
	});

	// Handle modal closing buttons
	const closeSelectors = [
		'[data-modal-close]',
		'[id^="close-"]',
		'.modal-close',
	];

	closeSelectors.forEach((selector) => {
		document.querySelectorAll(selector).forEach((button) => {
			button.addEventListener('click', () => {
				// Find the closest modal dialog
				const modal = button.closest('dialog.modal');
				if (modal) {
					modal.close();
				}
				//console.log('closed: ' + modal.id);
			});
		});
	});
});
