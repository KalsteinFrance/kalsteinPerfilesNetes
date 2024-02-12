jQuery(document).ready(function($) {
    var ctx = document.getElementById('sales');
    var sales = new Chart(ctx, {
        type: 'bar',        
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
            label: 'Sales of the month',
            data: [12, 19, 3, 5, 2, 3, 10],
            backgroundColor: [
                'rgba(33, 35, 128, 0.2)',
                'rgba(33, 35, 128, 0.2)',
                'rgba(33, 35, 128, 0.2)',
                'rgba(33, 35, 128, 0.2)',
                'rgba(33, 35, 128, 0.2)',
                'rgba(33, 35, 128, 0.2)',
                'rgba(33, 35, 128, 0.2)'
            ],
            borderColor: [
                'rgba(33, 35, 128, 1)',
                'rgba(33, 35, 128, 1)',
                'rgba(33, 35, 128, 1)',
                'rgba(33, 35, 128, 1)',
                'rgba(33, 35, 128, 1)',
                'rgba(33, 35, 128, 1)',
                'rgba(33, 35, 128, 1)'
            ],
            borderWidth: 1
            }]
        },
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
    });
    
    
    
    var ctx = document.getElementById('activity');
    var visitors = new Chart(ctx, {         
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets:[{
                label: 'Costumers of the month',
                data: [12, 19, 3, 5, 2, 3, 10],
                backgroundColor: [
                    'rgba(33, 35, 128, 0.2)'
                ],
                borderColor: [
                    'rgba(33, 35, 128, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
    });
    
    
    
    var ctx = document.getElementById('sales2');
    var visitors = new Chart(ctx, {         
        type: 'pie',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets:[{
                label: 'Costumers of the month',
                data: [12, 19, 3, 5, 2, 3, 10],
                backgroundColor: [
                    '#c8474d',
                ],
                borderColor: [
                    '#fff'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
    });
    
    
    var ctx = document.getElementById('visitors');
    var visitors = new Chart(ctx, {         
        type: 'pie',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets:[{
                label: 'Costumers of the month',
                data: [12, 19, 3, 5, 2, 3, 10],
                backgroundColor: [
                    '#c8474d',
                ],
                borderColor: [
                    '#212380'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
    
    });
    });
    