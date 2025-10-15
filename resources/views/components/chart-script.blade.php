@props(['statusChart', 'priorityChart'])
<script>
    const resolveChartColors = chartData => {
        const computedStyle = getComputedStyle(document.documentElement);
        const resolvedData = JSON.parse(JSON.stringify(chartData));

        const resolveColors = colors => colors.map(color => {
            if (color.startsWith('var(')) {
                const varName = color.slice(4, -1);
                return computedStyle.getPropertyValue(varName).trim() || '#6c757d';
            }
            return color;
        });

        // Handle different chart types
        resolvedData.data.datasets.forEach(dataset => {
            if (dataset.backgroundColor) {
                dataset.backgroundColor = Array.isArray(dataset.backgroundColor)
                    ? resolveColors(dataset.backgroundColor)
                    : resolveColors([dataset.backgroundColor]);
            }
            if (dataset.borderColor) {
                dataset.borderColor = Array.isArray(dataset.borderColor)
                    ? resolveColors(dataset.borderColor)
                    : resolveColors([dataset.borderColor]);
            }
        });

        return resolvedData;
    };

    document.addEventListener('DOMContentLoaded', function () {
        // Issue Status Chart
        const statusCtx = document.getElementById('projectIssueStatusChart');
        let statusChart;
        const originalProjectIssueStatusData = @json($projectIssueStatusChart);

        if (statusCtx) {
            statusChart = new Chart(statusCtx, resolveChartColors(originalProjectIssueStatusData));
            setTimeout(() => statusChart.options.animation.delay = undefined, 1000);
        }

        // Issue Priorities Chart
        const priorityCtx = document.getElementById('projectIssuePriorityChart');
        let priorityChart;
        const originalProjectIssuePriorityData = @json($projectIssuePriorityChart);

        if (priorityCtx) {
            priorityChart = new Chart(priorityCtx, resolveChartColors(originalProjectIssuePriorityData));
            setTimeout(() => priorityChart.options.animation.delay = undefined, 1000);
        }

        const updateAllChartColors = () => {
            if (statusChart) {
                const resolvedData = resolveChartColors(originalProjectIssueStatusData);
                statusChart.data.datasets.forEach((dataset, index) => {
                    dataset.backgroundColor = resolvedData.data.datasets[index].backgroundColor;
                    dataset.borderColor = resolvedData.data.datasets[index].borderColor;
                });
                statusChart.update('none');
            }

            if (priorityChart) {
                const resolvedData = resolveChartColors(originalProjectIssuePriorityData);
                priorityChart.data.datasets.forEach((dataset, index) => {
                    dataset.backgroundColor = resolvedData.data.datasets[index].backgroundColor;
                    dataset.borderColor = resolvedData.data.datasets[index].borderColor;
                });
                priorityChart.update('none');
            }
        };

        // Theme change listeners
        new MutationObserver(mutations =>
            mutations.some(m => m.type === 'attributes' && m.attributeName === 'data-theme') &&
            setTimeout(updateAllChartColors, 100)
        ).observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

        document.addEventListener('click', e =>
            (e.target.classList.contains('theme-controller') || e.target.closest('.theme-controller')) &&
            setTimeout(updateAllChartColors, 100)
        );
    });
</script>