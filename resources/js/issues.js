document.addEventListener('DOMContentLoaded', function () {
	// console.log('DOM loaded, initializing status selects...');

	const statusSelects = document.querySelectorAll('.status-select');
	// console.log('Found', statusSelects.length, 'status selects');

	// Exit early if no status selects found
	if (statusSelects.length === 0) {
		// console.log('No status selects found on this page');
		return;
	}

	// Check if we have CSRF token
	const csrfToken = document.querySelector('meta[name="csrf-token"]');
	if (!csrfToken) {
		//console.error('CSRF token not found!');
		return;
	}

	// Check if toast element exists
	const toastElement = document.getElementById('statusToast');
	if (!toastElement) {
		// console.error('Status toast element not found!');
		return;
	}

	// Check if bootstrap is available
	if (typeof window.bootstrap === 'undefined') {
		//console.error('Bootstrap is not available!');
		return;
	}

	const toast = new window.bootstrap.Toast(toastElement);

	statusSelects.forEach((select) => {
		select.addEventListener('change', function () {
			// console.log('Status select changed for issue:', this.dataset.issueId);

			const issueId = this.dataset.issueId;
			const newStatus = this.value;
			const originalStatus = this.dataset.originalStatus;

			// console.log('Issue ID:', issueId);
			// console.log('New Status:', newStatus);
			// console.log('Original Status:', originalStatus);

			// Don't make request if status hasn't actually changed
			if (newStatus === originalStatus) {
				// console.log('Status unchanged, skipping request');
				return;
			}

			// Disable select while updating
			this.disabled = true;
			// console.log('Making AJAX request to update status...');

			fetch(`/admin/issues/${issueId}/status`, {
				method: 'PATCH',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
					Accept: 'application/json',
				},
				body: JSON.stringify({
					status: newStatus,
				}),
			})
				.then((response) => {
					// console.log('Response status:', response.status);
					if (!response.ok) {
						throw new Error(`HTTP error! status: ${response.status}`);
					}
					return response.json();
				})
				.then((data) => {
					// console.log('Response data:', data);
					if (data.success) {
						// Update the original status to the new one
						this.dataset.originalStatus = newStatus;

						// Show success toast
						const toastText = document.querySelector('#statusToastText');
						const toastElement = document.querySelector('#statusToast');

						if (toastText && toastElement) {
							toastText.textContent = 'Status updated successfully!';
							toastElement.className = 'toast text-bg-success';
							toast.show();
						}

						// console.log('Status updated successfully');
					} else {
						throw new Error(data.message || 'Update failed');
					}
				})
				.catch((error) => {
					//console.error('Error updating status:', error);

					// Revert to original value
					this.value = originalStatus;

					// Show error toast
					const toastText = document.querySelector('#statusToastText');
					const toastElement = document.querySelector('#statusToast');

					if (toastText && toastElement) {
						toastText.textContent = 'Failed to update status: ' + error.message;
						toastElement.className = 'toast text-bg-danger';
						toast.show();
					}
				})
				.finally(() => {
					// Re-enable select
					this.disabled = false;
					// console.log('Request completed, select re-enabled');
				});
		});
	});
});
