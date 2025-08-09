document.addEventListener('DOMContentLoaded', function () {
	updateContactPersonSelect();
	handleProjectEditFormChanges();
});

function updateContactPersonSelect() {
	const contactPersonSelect = document.getElementById('customer_id');
	const companySelect = document.getElementById('company_id');

	if (!contactPersonSelect || !companySelect) {
		return;
	}

	const customerEmail = document.getElementById('customer_email_text');
	const customerPhone = document.getElementById('customer_phone_text');
	const customerNotes = document.getElementById('customer_notes_text');

	if (!customerEmail || !customerPhone || !customerNotes) {
		return;
	}

	// Function to filter contact person options based on selected company
	function filterContactPersonOptions(
		selectedCompanyId,
		resetSelection = false
	) {
		const contactPersonOptions = contactPersonSelect.querySelectorAll('option');

		contactPersonOptions.forEach((option) => {
			if (!selectedCompanyId || selectedCompanyId === '') {
				// No company selected: show only the default option and options without company ID
				if (
					option.value === '' ||
					!option.dataset.companyId ||
					option.dataset.companyId === ''
				) {
					option.style.display = 'block';
				} else {
					option.style.display = 'none';
				}
			} else {
				// Company selected: show default option AND options that match the selected company
				if (
					option.value === '' ||
					option.dataset.companyId === selectedCompanyId
				) {
					option.style.display = 'block';
				} else {
					option.style.display = 'none';
				}
			}
		});

		// Reset contact person selection when requested or when company changes
		if (resetSelection) {
			// Only reset if we're actually changing the selection
			const currentValue = contactPersonSelect.value;
			contactPersonSelect.value = '';

			// Only manipulate selected attributes if we're actually changing
			if (currentValue !== '') {
				// Remove selected attribute from all options
				contactPersonOptions.forEach((option) => {
					option.removeAttribute('selected');
				});
				// Set selected attribute on the default option
				const defaultOption =
					contactPersonSelect.querySelector('option[value=""]');
				if (defaultOption) {
					defaultOption.setAttribute('selected', 'selected');
				}
			}

			// Reset customer information
			customerEmail.textContent = 'Not assigned';
			customerPhone.textContent = 'Not assigned';
			customerNotes.textContent = 'No notes';
		}
	}

	// Function to update customer information display
	function updateCustomerInfo() {
		const selectedOption = contactPersonSelect.querySelector(
			`option[value="${contactPersonSelect.value}"]`
		);
		const currentValue = contactPersonSelect.value;

		// Only manipulate selected attributes if user is actively changing the selection
		// Don't interfere with server-side rendered selected attributes on page load
		if (
			document.readyState === 'complete' ||
			document.readyState === 'interactive'
		) {
			// Remove selected attribute from all options first
			contactPersonSelect.querySelectorAll('option').forEach((option) => {
				option.removeAttribute('selected');
			});

			if (currentValue === '' || !selectedOption) {
				// No customer selected - set selected attribute on default option
				const defaultOption =
					contactPersonSelect.querySelector('option[value=""]');
				if (defaultOption) {
					defaultOption.setAttribute('selected', 'selected');
				}
			} else {
				// Customer selected - set selected attribute on the chosen option
				selectedOption.setAttribute('selected', 'selected');
			}
		}

		// Always update the display text
		if (currentValue === '' || !selectedOption) {
			// No customer selected
			customerEmail.textContent = 'Not assigned';
			customerPhone.textContent = 'Not assigned';
			customerNotes.textContent = 'No notes';
		} else {
			// Customer selected - update info
			customerEmail.textContent =
				selectedOption.dataset.email || 'Not assigned';
			customerPhone.textContent =
				selectedOption.dataset.phone || 'Not assigned';
			customerNotes.textContent = selectedOption.dataset.notes || 'No notes';
		}
	}

	// Initial setup - preserve server-side selected values
	const initialCompanyId = companySelect.value;
	const initialCustomerId = contactPersonSelect.value;

	// Filter options but don't reset if there's an initial selection
	filterContactPersonOptions(initialCompanyId, false);

	// If there's an initial customer selection, update the display without changing selection
	if (initialCustomerId) {
		const selectedOption = contactPersonSelect.querySelector(
			`option[value="${initialCustomerId}"]`
		);
		if (selectedOption) {
			// Update customer info display
			customerEmail.textContent =
				selectedOption.dataset.email || 'Not assigned';
			customerPhone.textContent =
				selectedOption.dataset.phone || 'Not assigned';
			customerNotes.textContent = selectedOption.dataset.notes || 'No notes';
		}
	} else {
		// No initial selection - show default text
		customerEmail.textContent = 'Not assigned';
		customerPhone.textContent = 'Not assigned';
		customerNotes.textContent = 'No notes';
	}

	// Company select change event
	companySelect.addEventListener('change', function () {
		const selectedCompanyId = this.value;

		if (!selectedCompanyId || selectedCompanyId === '') {
			// Company reset to default - reset everything
			filterContactPersonOptions('', true);
		} else {
			// Company selected - filter options and reset customer selection
			filterContactPersonOptions(selectedCompanyId, true);
		}
	});

	// Contact person select change event
	contactPersonSelect.addEventListener('change', function () {
		updateCustomerInfo();
	});
}

function handleProjectEditFormChanges() {
	const form = document.getElementById('projectEditForm');
	const cancelButton = document.getElementById('cancelButton');

	if (!form || !cancelButton) {
		return;
	}

	let formChanged = false;
	let initialFormData = null;

	// Initialize form data after a short delay to ensure form is fully loaded
	setTimeout(() => {
		initialFormData = new FormData(form);
	}, 100);

	// Function to check if form has changed
	function hasFormChanged() {
		if (!initialFormData) return false;

		const currentFormData = new FormData(form);

		// Compare each field
		for (let [key, value] of currentFormData.entries()) {
			if (initialFormData.get(key) !== value) {
				return true;
			}
		}

		// Check if any select elements have different selected values
		const selects = form.querySelectorAll('select');
		for (let select of selects) {
			if (select.value !== initialFormData.get(select.name)) {
				return true;
			}
		}

		return false;
	}

	// Track form changes
	const formElements = form.querySelectorAll('input, textarea, select');
	formElements.forEach((element) => {
		element.addEventListener('change', function () {
			formChanged = hasFormChanged();
		});

		element.addEventListener('input', function () {
			formChanged = hasFormChanged();
		});
	});

	// Handle cancel button click
	if (cancelButton) {
		cancelButton.addEventListener('click', function (e) {
			if (formChanged) {
				e.preventDefault();
				leavePage();
			} else {
				leavePage();
			}
		});
	}

	function leavePage() {
		const redirectUrl = cancelButton.getAttribute('data-redirect-url');
		window.location.href = redirectUrl;
	}

	// Handle form submission (reset change tracking)
	form.addEventListener('submit', function () {
		formChanged = false;
	});

	// Handle page unload (browser back/forward, refresh, etc.)
	window.addEventListener('beforeunload', function (e) {
		if (formChanged) {
			e.preventDefault();
			e.returnValue =
				'__("You have unsaved changes. Are you sure you want to leave?")';
			return e.returnValue;
		}
	});
}
