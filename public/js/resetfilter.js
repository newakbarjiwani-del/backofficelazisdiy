function resetFilter() {
    document.getElementById('start_date').value = '';
    document.getElementById('end_date').value = '';
    window.location.href = "/dashboard"; // Reset URL tanpa parameter
}