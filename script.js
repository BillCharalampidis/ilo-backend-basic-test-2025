
document.addEventListener('DOMContentLoaded', () => {
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
//Διαγραφή task
    document.querySelector('ul').addEventListener('click', (event) => {
        if (event.target.classList.contains('delete-btn')) {
          const id = event.target.getAttribute('data-id');
          if (!confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις αυτό το task;')) return;
      
          fetch(`delete.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                event.target.closest('li').remove();
              } else {
                alert('Αποτυχία διαγραφής.');
              }
            })
            .catch(() => {
              alert('Σφάλμα δικτύου κατά τη διαγραφή.');
            });
        }
      });
      
});
