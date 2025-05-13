<?php
    session_start();

    // Load counts from PHP files
    ob_start();
    include('get_salesCount.php');
    $salesCount = ob_get_clean();

    ob_start();
    include('get_inventoryCount.php');
    $inventoryCount = ob_get_clean();

    ob_start();
    include('get_customerCount.php');
    $customerCount = ob_get_clean();

    ob_start();
    include('get_completedOrders.php');
    $completedCount = ob_get_clean();
    
    if (!isset($_SESSION['username'])) {
        // Not logged in — redirect to login
        header("Location: ../users/index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/AdminPage.css">
    <link rel="stylesheet" href="../assets/css/CustomAdminPage.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>
<!-- Display PHP variables in the dashboard -->
<div class="row mt-4">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Sales</p>
                            <h5 class="font-weight-bolder mb-0">
                                <?php echo $salesCount; ?>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Inventory</p>
                            <h5 class="font-weight-bolder mb-0">
                                <?php echo $inventoryCount; ?>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Customers</p>
                            <h5 class="font-weight-bolder mb-0">
                                <?php echo $customerCount; ?>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Completed Orders</p>
                            <h5 class="font-weight-bolder mb-0">
                                <?php echo $completedCount; ?>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>body


<!-- Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
<!-- Dashboard JavaScript -->
<script>
    // Helper function to handle fetch errors
    function handleFetchError(endpoint, elementId) {
        return error => {
            console.error(`Error fetching data from ${endpoint}:`, error);
            const element = document.getElementById(elementId);
            if (element) {
                element.textContent = 'Error loading data';
                element.classList.add('text-danger');
            }
        };
    }
    
    // Sales per day chart
    fetch('sales_perDay.php')
        .then(response => response.json())
        .then(json => {
            const ctx = document.getElementById('salesPerDayChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: json.labels,
                    datasets: [{
                        label: 'Sales Per Day',
                        data: json.data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(handleFetchError('sales_perDay.php', 'salesPerDayChart'));
    
    // Sales per month chart
    fetch('sales_perMonth.php')
        .then(response => response.json())
        .then(json => {
            const ctx = document.getElementById('salesPerMonthChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: json.labels,
                    datasets: [{
                        label: 'Sales Per Month',
                        data: json.data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(handleFetchError('sales_perMonth.php', 'salesPerMonthChart'));
    
    // Sales per quarter chart
    fetch('sales_perQuarterly.php')
        .then(response => response.json())
        .then(json => {
            const ctx = document.getElementById('salesPerQuarterChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: json.labels,
                    datasets: [{
                        label: 'Sales Per Quarter',
                        data: json.data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(handleFetchError('sales_perQuarterly.php', 'salesPerQuarterChart'));
    
    // Sales per year chart
    fetch('sales_perYear.php')
        .then(response => response.json())
        .then(json => {
            const ctx = document.getElementById('salesPerYearChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: json.labels,
                    datasets: [{
                        label: 'Sales Per Year',
                        data: json.data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(handleFetchError('sales_perYear.php', 'salesPerYearChart'));
    
    // Load all statistics data in parallel for better performance
    Promise.all([
        fetch('get_totalSales.php').then(response => response.text()),
        fetch('orders_overview.php').then(response => response.json()),
        fetch('roles.php').then(response => response.json()),
        fetch('top_sellingProducts_day.php').then(response => response.json()),
        fetch('top_sellingProducts_month.php').then(response => response.json()),
        fetch('top_sellingProducts_year.php').then(response => response.json())
    ])
    .then(([totalSales, orderStats, roleStats, topDay, topMonth, topYear]) => {
        // Process total sales
        document.getElementById('totalSales').textContent = parseInt(totalSales).toLocaleString();
        
        // Process order statistics
        document.getElementById('pendingCount').textContent = `${orderStats.Pending} Orders`;
        document.getElementById('cancelledCount').textContent = `${orderStats.Cancelled} Orders`;
        document.getElementById('processingCount').textContent = `${orderStats['Out For Delivery']} Orders`;
        document.getElementById('completedCount').textContent = `${orderStats.Completed} Orders`;
        
        // Process user roles
        document.getElementById('todayAdmins').textContent = (roleStats['Admin'] + roleStats['SuperAdmin']) || 0;
        document.getElementById('todayUsers').textContent = roleStats['User'] || 0;
        
        // Process top selling products - day
        renderTopProductsList(topDay, 'topSellingDayList', 'No products sold today');
        
        // Process top selling products - month
        renderTopProductsList(topMonth, 'topSellingMonthList', 'No products sold this month');
        
        // Process top selling products - year
        renderTopProductsList(topYear, 'topSellingYearList', 'No products sold this year');
    })
    .catch(error => {
        console.error('Error fetching dashboard data:', error);
        // Display error messages in the UI
        document.getElementById('totalSales').textContent = 'Error';
        document.getElementById('pendingCount').textContent = 'Error';
        document.getElementById('cancelledCount').textContent = 'Error';
        document.getElementById('processingCount').textContent = 'Error';
        document.getElementById('completedCount').textContent = 'Error';
        document.getElementById('todayAdmins').textContent = 'Error';
        document.getElementById('todayUsers').textContent = 'Error';
        
        document.getElementById('topSellingDayList').innerHTML = '<li class="list-group-item border-0 text-center text-danger">Error loading data</li>';
        document.getElementById('topSellingMonthList').innerHTML = '<li class="list-group-item border-0 text-center text-danger">Error loading data</li>';
        document.getElementById('topSellingYearList').innerHTML = '<li class="list-group-item border-0 text-center text-danger">Error loading data</li>';
    });
    
    // Helper function to render top products lists
    function renderTopProductsList(data, elementId, emptyMessage) {
        const list = document.getElementById(elementId);
        list.innerHTML = ''; // Clear existing items
    
        if (!data || data.length === 0) {
            const li = document.createElement('li');
            li.className = 'list-group-item text-center border-0';
            li.textContent = emptyMessage;
            list.appendChild(li);
        } else {
            data.forEach(item => {
                const li = document.createElement('li');
                li.className = 'list-group-item border-0 d-flex justify-content-between align-items-center';
                li.innerHTML = `
                    <div>
                        <span class="text-sm fw-medium">${item.model}</span>
                        <br>
                        <small class="text-muted">Revenue: ₱${item.revenue}</small>
                    </div>
                    <span class="badge bg-gradient-primary rounded-pill">${item.sold} sold</span>
                `;
                list.appendChild(li);
            });
        }
    }
</script>

