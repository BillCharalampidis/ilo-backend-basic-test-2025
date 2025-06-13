const checkboxes = document.querySelectorAll('input[type="checkbox"][data-id]');
checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        const id = checkbox.getAttribute('data-id');
        //fetch request με AJAX
        fetch(`toggle.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success){
                checkbox.classList.toggle('done', checkbox.checked);
            } else {
                alert('Κάτι πήγε στραβά με το toggle.');
                checkbox.checked = !checkbox.checked;
            }
        })
        .catch(() => {
            alert('Σφάλμα δικτύου.');
            checkbox.checked = !checkbox.checked;
        })
    })
});
