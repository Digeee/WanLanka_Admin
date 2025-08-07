document.addEventListener("DOMContentLoaded", function () {
    const addUserBtn = document.querySelector('.add-user-btn');
    const modal = document.getElementById('addUserModal');
    const closeModal = document.getElementById('closeModal');

    addUserBtn.addEventListener('click', function() {
        modal.classList.add('show');
    });

    closeModal.addEventListener('click', function() {
        modal.classList.remove('show');
    });

    // Create a chart for user growth over time
    const ctx = document.getElementById('userGrowthChart').getContext('2d');
    const userGrowthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'User Growth',
                data: [50, 100, 150, 200, 300, 450],
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Users'
                    }
                }
            }
        }
    });
});
