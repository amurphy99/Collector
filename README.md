# Collector / Modified Version

The code modifications here won't be reflected in the current running version. Newly created trial types will be storted here and we will add some documentation to the rest of the system code to help with making new trials work in the future. 

The actual version that is in use is in Google Drive under "VDRT". It isn't the exact full system, but there may be more details there. I actually probably should have used that to make this...


# Project Structure
```diff
Collector
 ├── Archive/...                  # Original files from the fork
 │
 ├── VDRT/                        # Module of the code used for the current system
 │   ├── Code/...
 │   └── ...                      # ToDo: Add path to wherever the new task types go
 │
 ├── TaskTypes/                   # Folder for new task types
+│   ├── <Task Name>/             # Example task folder
 │   │   ├── README.md            # Info about the task
 │   │   ├── TrialTypes/          # Trials created for this task
+│   │   │   ├── <Trial Name>     # Example trial type folder
 │   │   │   │   ├── display.php
 │   │   │   │   └── scoring.php
 │   │   │   └── ...     
 │   │   └── ...
 │   └── ...
 └── ...

```

* `VDRT` is the overall/default folder that is copied when creating a new task type. In the future if we make changes to the more "backend" code, that will go in here, and would be there for all future trials created.
* `TrialTypes` contains folders for each of the task types we create. Within each of those is a `TrialTypes` folder where we store all of the new trial types we created for that task (e.g. `recog`, `instructRKG`, and `RKG` for the task we created today).
* So to use a task type that was created previously, you copy the `VDRT` folder locally and upload the trials from `TrialTypes/<Trial Name>/TrialTypes` into the corresponding folder on the copy.


# Helpful Notes
```php
// Print the session data
<div>
    <h3>Session Data</h3>
    <?php
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    ?>
</div>
```

