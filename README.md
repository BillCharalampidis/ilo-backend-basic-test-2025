# Backend Basic Test

## Περιγραφή
Αυτό το repo περιέχει τα βασικά αρχεία για το backend τεστ (PHP χωρίς frameworks). Ο υποψήφιος πρέπει να υλοποιήσει τα εξής:

1. Στο `index.php`:
   - Εμφανίζει μια φόρμα με δύο πεδία: `title` (required) και `description` (optional).
   - Όταν υποβάλλεται η φόρμα, το PHP code:
     - Διαβάζει το `tasks.json`.
     - Ελέγχει αν το `title` έχει μήκος τουλάχιστον 3 χαρακτήρων (validation).
     - Προσθέτει ένα νέο task με: `id` (max id + 1), `title`, `description`, `is_done` false.
     - Αποθηκεύει ξανά στο `tasks.json`.
     - Κάνει redirect σε `index.php`.
   - Εμφανίζει τη λίστα όλων των tasks από το `tasks.json` με checkbox “Done”.

2. Στο `toggle.php`:
   - Λαμβάνει `id` (μέσω GET ή POST).
   - Διαβάζει το `tasks.json`, βρίσκει το task με το συγκεκριμένο `id`, κάνει toggle το `is_done`.
   - Αποθηκεύει ξανά στο `tasks.json` και επιστρέφει JSON του ενημερωμένου task.

3. Στο `script.js`:
   - Αν ο χρήστης αλλάζει το checkbox “Done” για ένα task, στέλνει με AJAX (fetch) request στο `toggle.php?id=[id]`.
   - Όταν έρθει η απάντηση, αλλάζει δυναμικά το style (π.χ. προσθέτει/αφαιρεί `class="done"`).

4. Στο `style.css`:
   - Βασικό styling για τα tasks, π.χ. αν `is_done` είναι true, ο τίτλος έχει line-through και γκρι χρώμα.

## Οδηγίες Εκτέλεσης
1. Ανοίξτε τη γραμμή εντολών και πλοηγηθείτε στον φάκελο:
   ```bash
   cd backend_test
   ```
2. Τρέξτε τον ενσωματωμένο PHP server:
   ```bash
   php -S localhost:8000
   ```
3. Ανοίξτε τον browser στο `http://localhost:8000/index.php`.
4. Διαφορετικά μπορείτε με xamp, wamp, laragon

## Κριτήρια Αξιολόγησης
- Φόρτωση και εμφάνιση των tasks από το `tasks.json`.
- Δημιουργία νέου task μέσω της φόρμας με σωστό validation.
- Toggle της κατάστασης `is_done` (με AJAX ή reload).
- Καθαρότητα κώδικα, validation, basic error handling.
- Documentation στο `README.md` με οδηγίες και περιγραφή.

## Τι Υλοποίησα
Πρόκειται για μια απλή To-Do List εφαρμογή σε PHP με αποθήκευση σε αρχείο JSON. Η εφαρμογή επιτρέπει:

- Προσθήκη νέου task με τίτλο και προαιρετική περιγραφή.
- Επισήμανση ολοκλήρωσης (μέσω checkbox) με άμεση αποθήκευση αλλαγής.
- Διαγραφή task με επιβεβαίωση.
- Επεξεργασία υπάρχοντος task μέσω φόρμας που εμφανίζεται inline.
- Αποθήκευση δεδομένων σε αρχείο tasks.json (χωρίς χρήση βάσης δεδομένων).
- Βασικό responsive styling με υποστήριξη για tasks που έχουν ολοκληρωθεί (γραμμή διαγραφής, γκρι χρώμα κ.λπ.).

Η εφαρμογή δεν χρησιμοποιεί framework και είναι υλοποιημένη με καθαρή PHP, HTML, CSS και JavaScript (vanilla). Οι αλλαγές γίνονται με AJAX, χωρίς ανανέωση σελίδας
