document.addEventListener('DOMContentLoaded', function () {
	const statusSelects = document.querySelectorAll('.status-select');

	// Exit early if no status selects found
	if (statusSelects.length === 0) return;

	// Check if we have CSRF token
	const csrfToken = document.querySelector('meta[name="csrf-token"]');
	if (!csrfToken) {
		return;
	}

	// Check if toast element exists
	const toastElement = document.getElementById('statusToast');
	if (!toastElement) {
		return;
	}

	const toast = new window.bootstrap.Toast(toastElement);

	statusSelects.forEach((select) => {
		select.addEventListener('change', function () {
			const issueId = this.dataset.issueId;
			const newStatus = this.value;
			const originalStatus = this.dataset.originalStatus;

			// Don't make request if status hasn't actually changed
			if (newStatus === originalStatus) {
				return;
			}

			// Disable select while updating
			this.disabled = true;

			fetch(`/dashboard/issues/${issueId}/status`, {
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
					console.log('Response status:', response.status);
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
