
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
      //Κουμπί edit
      document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
          const li = button.closest('li');
          li.querySelector('.edit-form').style.display = 'block';
          li.querySelector('.title').style.display = 'none';
          li.querySelector('.description').style.display = 'none';
          button.style.display = 'none'; 
        });
      });
      //Κουμπί Cancel
      document.querySelectorAll('.cancel-btn').forEach(button => {
        button.addEventListener('click', () => {
          const li = button.closest('li');
          li.querySelector('.edit-form').style.display = 'none';
          li.querySelector('.title').style.display = 'inline';
          li.querySelector('.description').style.display = 'inline';
          li.querySelector('.edit-btn').style.display = 'inline';
        });
      });
      //Επεξεργασία tasks
      document.querySelectorAll('.edit-form').forEach(form => {
        form.addEventListener('submit', e => {
          e.preventDefault();
          const li = form.closest('li');
          const id = li.getAttribute('data-id');
          const formData = new FormData(form);
          formData.append('id', id);
          fetch('edit.php', {
            method: 'POST',
            body: formData
          })
          .then(res => {
            console.log('HTTP status:', res.status);
            return res.text();  
          })
          .then(text => {
            console.log('Response text:', text);
            try {
              const data = JSON.parse(text);
              if (data.success) {
                //Εμφάνιση πεδίου επεξεργασίας
                const li = document.querySelector(`li[data-id="${formData.get('id')}"]`);
                li.querySelector('.title').textContent = formData.get('title');
                li.querySelector('.description').textContent = formData.get('description');
                form.style.display = 'none';
                li.querySelector('.title').style.display = 'inline';
                li.querySelector('.description').style.display = 'inline';
                li.querySelector('.edit-btn').style.display = 'inline';
              } else {
                alert('Κάτι πήγε λάθος: ' + data.error);
              }
            } catch(e) {
              alert('Απέτυχε η ανάλυση JSON: ' + e.message);
            }
          })
          .catch(err => {
            console.error('Fetch error:', err);
            alert('Σφάλμα δικτύου');
          });
          

        });
      });
      

});
