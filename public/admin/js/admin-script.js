// ============================================
// Government School Admin Panel - Main JS
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile Menu Toggle
    initMobileMenu();
    
    // Sidebar Menu Toggle
    initSidebarMenu();
    
    // Form Validation
    initFormValidation();
    
    // DataTables - Initialize after a small delay
    setTimeout(initDataTables, 50);
    
    // Confirmation Dialogs
    initConfirmDialogs();
    
    // Auto-hide Alerts
    initAlerts();
    
    // Class Stream Toggle
    initClassStreamToggle();
});

// Mobile Menu Functionality
function initMobileMenu() {
    const menuToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.querySelector('.admin-sidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    }
}

// Sidebar Menu Functionality
function initSidebarMenu() {
    const menuItems = document.querySelectorAll('.menu-item.has-submenu');
    
    menuItems.forEach(item => {
        const link = item.querySelector('.menu-link');
        const submenu = item.querySelector('.submenu');
        
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Close other submenus
            menuItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('open');
                    const otherSubmenu = otherItem.querySelector('.submenu');
                    if (otherSubmenu) {
                        otherSubmenu.classList.remove('open');
                    }
                }
            });
            
            // Toggle current submenu
            item.classList.toggle('open');
            if (submenu) {
                submenu.classList.toggle('open');
            }
        });
    });
}

// Form Validation
function initFormValidation() {
    const forms = document.querySelectorAll('form[onsubmit="return validation()"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                return false;
            }
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const validationDiv = document.getElementById('validation');
    let errors = [];
    
    // Clear previous errors
    if (validationDiv) {
        validationDiv.innerHTML = '';
    }
    
    // Get all required fields
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        const value = field.value.trim();
        const fieldName = field.name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        
        if (!value) {
            isValid = false;
            errors.push(`${fieldName} is required`);
            field.classList.add('error');
        } else {
            field.classList.remove('error');
        }
        
        // Mobile number validation
        if (field.name === 'mobile_number' && value) {
            if (!/^\d{10}$/.test(value)) {
                isValid = false;
                errors.push('Mobile number must be 10 digits');
                field.classList.add('error');
            }
        }
    });
    
    // Display errors
    if (!isValid && validationDiv) {
        validationDiv.innerHTML = errors.join('<br>');
    }
    
    return isValid;
}

// DataTables Initialization
function initDataTables() {
    if (typeof $ === 'undefined' || !$.fn.DataTable) {
        return;
    }
    
    try {
        const tables = document.querySelectorAll('.data-table');
        
        if (tables.length === 0) {
            return;
        }
        
        let initializedCount = 0;
        
        tables.forEach(function(table, index) {
            try {
                // Skip if already initialized
                if ($.fn.DataTable.isDataTable(table)) {
                    return;
                }
                
                // Verify table has proper structure
                const thead = table.querySelector('thead');
                const tbody = table.querySelector('tbody');
                
                if (!thead || !tbody) {
                    return;
                }
                
                // Get column count from thead
                const headerRow = thead.querySelector('tr');
                if (!headerRow) {
                    return;
                }
                
                const headerCells = headerRow.querySelectorAll('th');
                const headerCount = headerCells.length;
                
                if (headerCount === 0) {
                    return;
                }
                
                
                // Initialize the table
                $(table).DataTable({
                    "paging": true,
                    "pageLength": 10,
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "ordering": true,
                    "order": [[0, "asc"]],
                    "searching": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": false,
                    "language": {
                        "search": "Search:",
                        "lengthMenu": "Show _MENU_ entries",
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty": "No entries available",
                        "emptyTable": "No data available in table",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Next",
                            "previous": "Previous"
                        }
                    },
                    "columnDefs": [
                        { 
                            "orderable": false, 
                            "targets": headerCount - 1 // Last column not orderable
                        }
                    ]
                });
                
                initializedCount++;
                
            } catch (tableError) {
                // silently handle
            }
        });

    } catch (e) {
        // silently handle
    }
}

// Confirmation Dialogs
function initConfirmDialogs() {
    const deleteLinks = document.querySelectorAll('a[onclick*="confirm"]');
    
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const confirmed = confirm('Are you sure you want to delete this?');
            if (!confirmed) {
                e.preventDefault();
                return false;
            }
        });
    });
}

// Auto-hide Alerts
function initAlerts() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
}

// Class and Stream Toggle
function initClassStreamToggle() {
    const classSelect = document.getElementById('class');
    const streamDiv = document.getElementById('stream_div');
    
    if (classSelect && streamDiv) {
        classSelect.addEventListener('change', function() {
            const selectedClass = this.value;
            
            // Show stream for Class XI and XII
            if (selectedClass === 'XI' || selectedClass === 'XII') {
                streamDiv.style.display = 'flex';
                document.getElementById('stream').required = true;
            } else {
                streamDiv.style.display = 'none';
                document.getElementById('stream').required = false;
                document.getElementById('stream').value = '';
            }
        });
        
        // Trigger on page load
        classSelect.dispatchEvent(new Event('change'));
    }
}

// Utility Functions
function printReceipt(receiptId) {
    const printWindow = window.open('', '_blank');
    const receiptContent = document.getElementById(receiptId);
    
    if (receiptContent) {
        printWindow.document.write('<html><head><title>Print Receipt</title>');
        printWindow.document.write('<style>body{font-family:Arial;padding:20px;}table{width:100%;border-collapse:collapse;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(receiptContent.innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
}

function exportTableToExcel(tableId, filename = 'export') {
    const table = document.getElementById(tableId);
    
    if (!table) return;
    
    let html = table.outerHTML;
    const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
    const downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    downloadLink.href = url;
    downloadLink.download = filename + '.xls';
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

// Mobile Sidebar Toggle
function toggleSidebar() {
    const sidebar = document.querySelector('.admin-sidebar');
    if (sidebar) {
        sidebar.classList.toggle('open');
    }
}
