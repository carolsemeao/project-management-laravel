// Filter issues by project
function filterIssues(event) {
	const selectedProjectId = event.target.value;
	const tableRows = document.querySelectorAll('tbody tr[data-project-id]');
	let visibleCount = 0;

	tableRows.forEach((row) => {
		const projectId = row.getAttribute('data-project-id');

		if (selectedProjectId === '' || projectId === selectedProjectId) {
			row.style.display = '';
			visibleCount++;
		} else {
			row.style.display = 'none';
		}
	});

	// Update the issue count
	const countElement = document.querySelector('.card-text');
	if (countElement) {
		countElement.textContent = `${visibleCount} issues`;
	}
}

// Make the function available globally
window.filterIssues = filterIssues;
