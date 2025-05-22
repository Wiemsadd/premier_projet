// This file should not contain PHP code. The data should be passed from the HTML page.
document.addEventListener('DOMContentLoaded', function() {
    // These variables should be defined in the HTML page via <script> tags or data attributes
    if (typeof enrollmentsLabels === 'undefined' || typeof enrollmentsData === 'undefined' || typeof categoryLabels === 'undefined' || typeof categoryData === 'undefined' || typeof revenueLabels === 'undefined' || typeof revenueData === 'undefined') {
        console.error('Dashboard data variables are not defined.');
        return;
    }

    const enrollmentsCtx = document.getElementById('enrollmentsChart').getContext('2d');
    new Chart(enrollmentsCtx, {
        type: 'line',
        data: {
            labels: enrollmentsLabels,
            datasets: [{
                label: 'Inscriptions',
                data: enrollmentsData,
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: false },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    const categoryCtx = document.getElementById('coursesByCategoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Nombre de cours',
                data: categoryData,
                backgroundColor: '#6366F1'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: false },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'doughnut',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenus',
                data: revenueData,
                backgroundColor: ['#8B5CF6', '#EC4899', '#F59E0B', '#10B981', '#3B82F6']
            }]
        },
        options: {
            responsive: true
        }
    });
});