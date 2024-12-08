# Δημιουργία Project Laravel με Starter Kit και Ρυθμίσεις Βάσης Δεδομένων

Αυτός ο οδηγός θα σας καθοδηγήσει στη διαδικασία δημιουργίας ενός νέου έργου Laravel με τη χρήση του Laravel installer, καθώς και στη ρύθμιση του starter kit και της βάσης δεδομένων.

## Βήματα

### 1. Δημιουργία Νέου Project Laravel

Ανοίξτε το τερματικό σας και εκτελέστε την παρακάτω εντολή για να δημιουργήσετε ένα νέο έργο Laravel:

```bash
laravel new task_empty
```

### 2. Επιλογή Starter Kit

Κατά τη διάρκεια της διαδικασίας δημιουργίας, θα σας ζητηθεί να επιλέξετε ένα starter kit. Μπορείτε να επιλέξετε "No starter kit" ή κάποιο από τα διαθέσιμα kits:

```
Would you like to install a starter kit? [No starter kit]:
  [none     ] No starter kit
  [breeze   ] Laravel Breeze
  [jetstream] Laravel Jetstream
 > none
```

### 3. Επιλογή Πλαισίου Δοκιμών

Στη συνέχεια, θα σας ζητηθεί να επιλέξετε το πλαίσιο δοκιμών που προτιμάτε. Μπορείτε να επιλέξετε το Pest ή το PHPUnit:

```
Which testing framework do you prefer? [Pest]:
  [0] Pest
  [1] PHPUnit
 > 0
```

### 4. Επιλογή Βάσης Δεδομένων

Θα σας ζητηθεί να επιλέξετε τη βάση δεδομένων που θα χρησιμοποιήσει η εφαρμογή σας. Επιλέξτε "MySQL":

Εχουμε ηδη δημιουργήσει βάση δεδομένων στο Xampp με το όνομα "task_empty"

```
Which database will your application use? [SQLite]:
  [sqlite ] SQLite
  [mysql  ] MySQL
  [mariadb] MariaDB
  [pgsql  ] PostgreSQL (Missing PDO extension)
  [sqlsrv ] SQL Server (Missing PDO extension)
 > mysql
```

### 5. Ενημέρωση Προεπιλεγμένης Βάσης Δεδομένων

Η προεπιλεγμένη βάση δεδομένων θα ενημερωθεί. Θα σας ρωτήσει αν θέλετε να εκτελέσετε τις προεπιλεγμένες migrations της βάσης δεδομένων:

```
Default database updated. Would you like to run the default database migrations? (yes/no) [yes]:
 > yes
```

### 6. Πλοήγηση στον Φάκελο του Έργου

Μετά την ολοκλήρωση της διαδικασίας, πλοηγηθείτε στον φάκελο του Project:

```bash
cd task_empty
```

### 7. Εγκατάσταση Εξαρτήσεων με npm

Εκτελέστε τις παρακάτω εντολές για να εγκαταστήσετε τις εξαρτήσεις του Project:

```bash
npm install && npm run build
```

### 8. Εκτέλεση του Laravel

Τέλος, μπορείτε να εκτελέσετε την εφαρμογή σας με την παρακάτω εντολή:

```bash
composer run dev
```

## Συμπέρασμα

Ακολουθώντας τα παραπάνω βήματα, έχετε δημιουργήσει επιτυχώς ένα νέο Project Laravel με τις επιθυμητές ρυθμίσεις. Αν έχετε άλλες ερωτήσεις ή χρειάζεστε βοήθεια, μη διστάσετε να ρωτήσετε!