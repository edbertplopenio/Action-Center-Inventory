<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: ../../frontend/public/login.html");
    exit();
}

// Fetch users from the database
include '../config/db_connection.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$conn->close();

// Function to filter users by role
function filterUsersByRole($users, $role)
{
    return array_filter($users, function ($user) use ($role) {
        return $user['role'] === $role;
    });
}

$admins = filterUsersByRole($users, 'Admin');
$inventoryManagers = filterUsersByRole($users, 'Inventory Manager');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="/frontend/public/styles/user_management.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="user-management-container">
        <div class="header">
            <h1>User Management</h1>
            <button class="new-user-button">+ Add New User</button>
        </div>

        <div class="filters">
            <div class="tabs-container">
                <button class="tab active" data-tab="all-users">
                    <i class="fas fa-users"></i> All Users
                </button>
                <button class="tab" data-tab="admins">
                    <i class="fas fa-user-shield"></i> Admins
                </button>
                <button class="tab" data-tab="inventory-manager">
                    <i class="fas fa-box"></i> Inventory Manager
                </button>
            </div>
            <div class="filter-input-container">
                <input type="text" class="filter-input" placeholder="Filter users">
                <i class="fas fa-filter icon-filter"></i>
            </div>
        </div>

        <!-- All Users Content -->
        <div id="all-users" class="tab-content active">
            <table class="user-table" id="user-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Cellphone</th> <!-- Added Cellphone column -->
                        <th>Role</th>
                        <th>Image</th> <!-- Image column -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr data-user-id="<?= htmlspecialchars($user['id']); ?>" data-role="<?= htmlspecialchars($user['role']); ?>">
                            <td><?= htmlspecialchars($user['id']); ?></td>
                            <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td><?= htmlspecialchars($user['cellphone']); ?></td> <!-- Display Cellphone -->
                            <td><?= htmlspecialchars($user['role']); ?></td>
                            <td>
                                <?php if ($user['image']): ?>
                                    <img src="../../frontend/public/images/users/<?= htmlspecialchars($user['image']); ?>" alt="User Image" width="50" height="50">
                                <?php else: ?>
                                    <span>No Image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="action-button user-edit" data-user-id="<?= htmlspecialchars($user['id']); ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="action-button delete" data-user-id="<?= htmlspecialchars($user['id']); ?>"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Admins Content -->
        <div id="admins" class="tab-content">
            <table class="user-table" id="admin-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Cellphone</th> <!-- Added Cellphone column -->
                        <th>Role</th>
                        <th>Image</th> <!-- Image column -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr data-user-id="<?= htmlspecialchars($admin['id']); ?>" data-role="Admin">
                            <td><?= htmlspecialchars($admin['id']); ?></td>
                            <td><?= htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']); ?></td>
                            <td><?= htmlspecialchars($admin['email']); ?></td>
                            <td><?= htmlspecialchars($admin['cellphone']); ?></td> <!-- Display Cellphone -->
                            <td><?= htmlspecialchars($admin['role']); ?></td>
                            <td>
                                <?php if ($admin['image']): ?>
                                    <img src="../../frontend/public/images/users/<?= htmlspecialchars($admin['image']); ?>" alt="User Image" width="50" height="50">
                                <?php else: ?>
                                    <span>No Image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="action-button user-edit" data-user-id="<?= htmlspecialchars($admin['id']); ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="action-button delete" data-user-id="<?= htmlspecialchars($admin['id']); ?>"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Inventory Manager Content -->
        <div id="inventory-manager" class="tab-content">
            <table class="user-table" id="inventory-manager-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Cellphone</th> <!-- Added Cellphone column -->
                        <th>Role</th>
                        <th>Image</th> <!-- Image column -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventoryManagers as $inventoryManager): ?>
                        <tr data-user-id="<?= htmlspecialchars($inventoryManager['id']); ?>" data-role="Inventory Manager">
                            <td><?= htmlspecialchars($inventoryManager['id']); ?></td>
                            <td><?= htmlspecialchars($inventoryManager['first_name'] . ' ' . $inventoryManager['last_name']); ?></td>
                            <td><?= htmlspecialchars($inventoryManager['email']); ?></td>
                            <td><?= htmlspecialchars($inventoryManager['cellphone']); ?></td> <!-- Display Cellphone -->
                            <td><?= htmlspecialchars($inventoryManager['role']); ?></td>
                            <td>
                                <?php if ($inventoryManager['image']): ?>
                                    <img src="../../frontend/public/images/users/<?= htmlspecialchars($inventoryManager['image']); ?>" alt="User Image" width="50" height="50">
                                <?php else: ?>
                                    <span>No Image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="action-button user-edit" data-user-id="<?= htmlspecialchars($inventoryManager['id']); ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="action-button delete" data-user-id="<?= htmlspecialchars($inventoryManager['id']); ?>"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- New User Modal -->
    <div id="new-user-modal" class="modal">
        <div class="modal-content">
            <div class="header">
                <h1>Add New User</h1>
            </div>

            <form id="new-user-form" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label for="first-name">First Name:</label>
                        <input type="text" id="first-name" name="first-name" required>
                    </div>

                    <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <input type="text" id="last-name" name="last-name" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="cellphone">Cellphone Number:</label>
                        <input type="text" id="cellphone" name="cellphone" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="role">Role:</label>
                        <select id="role" name="role" required>
                            <option value="Admin">Admin</option>
                            <option value="Inventory Manager">Inventory Manager</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <script>
                        document.getElementById('show-password').addEventListener('change', function() {
                            const passwordField = document.getElementById('password');

                            if (this.checked) {
                                passwordField.type = 'text'; // Show password
                            } else {
                                passwordField.type = 'password'; // Hide password
                            }
                        });
                    </script>

                    <div class="form-group">
                        <label for="confirm-password">Confirm Password:</label>
                        <input type="password" id="confirm-password" name="confirm-password" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="image">Upload Image:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                </div>

                <div class="form-row buttons-row">
                    <button type="button" class="cancel-button">Cancel</button>
                    <button type="submit" class="save-user-button">Save User</button>
                </div>
            </form>
        </div>
    </div>




    <!-- Edit User Modal -->
    <div id="edit-user-modal" class="modal">
        <div class="modal-content">
            <div class="header">
                <h1>Edit User</h1>
            </div>

            <form id="edit-user-form" enctype="multipart/form-data">
                <input type="hidden" id="edit-user-id" name="id">

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit-first-name">First Name:</label>
                        <input type="text" id="edit-first-name" name="first_name" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-last-name">Last Name:</label>
                        <input type="text" id="edit-last-name" name="last_name" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit-email">Email:</label>
                        <input type="email" id="edit-email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-cellphone">Cellphone:</label>
                        <input type="text" id="edit-cellphone" name="cellphone" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit-role">Role:</label>
                        <select id="edit-role" name="role" required>
                            <option value="Admin">Admin</option>
                            <option value="Inventory Manager">Inventory Manager</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit-image">Current Image:</label>
                        <img id="current-image" src="" alt="Current Image" width="50" height="50">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit-image">Upload New Image:</label>
                        <input type="file" id="edit-image" name="image" accept="image/*">
                    </div>
                </div>

                <div class="form-row buttons-row">
                    <button type="button" class="cancel-button">Cancel</button>
                    <button type="submit" class="save-user-button">Save Changes</button>
                </div>
            </form>
        </div>
    </div>





    <script>
        function initializeUserManagement() {
            fetchAndLoadUsers(); // Fetch and load users when the page initializes

            // Handle tab switching
            document.querySelector('.tabs-container').addEventListener('click', function(event) {
                if (event.target.classList.contains('tab')) {
                    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                    event.target.classList.add('active');
                    document.getElementById(event.target.getAttribute('data-tab')).classList.add('active');
                }
            });

            // Show the modal when the "Add New User" button is clicked
            const modal = document.getElementById("new-user-modal");
            const newUserButton = document.querySelector(".new-user-button");

            newUserButton.addEventListener('click', function() {
                modal.style.display = "flex"; // Display modal
                modal.classList.add('show-modal'); // Add show class for animation
            });

            // Close the modal and reset the form fields when the "Cancel" button is clicked
            const cancelButton = document.querySelector(".cancel-button");
            cancelButton.addEventListener('click', function() {
                const modal = document.getElementById("new-user-modal");

                // Reset all form fields inside the modal
                const form = document.getElementById('new-user-form');
                form.reset(); // This resets the form fields

                modal.classList.remove('show-modal'); // Remove show class for animation
                setTimeout(() => modal.style.display = "none"); // Delay for smooth transition
            });


            // Delete user functionality
            document.querySelectorAll('.delete').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You won\'t be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // AJAX request to delete the user
                            fetch('../../backend/controllers/delete_user.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        id: userId
                                    }),
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire(
                                            'Deleted!',
                                            'User has been deleted.',
                                            'success'
                                        );
                                        // Remove the user row from the table
                                        document.querySelector(`tr[data-user-id="${userId}"]`).remove();
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            data.message,
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire(
                                        'Error!',
                                        'An unexpected error occurred. Please try again.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });

            // Handle edit button click
            document.querySelectorAll('.action-button.user-edit').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.closest('tr').getAttribute('data-user-id');

                    // Fetch user data from the row
                    const row = this.closest('tr');
                    const firstName = row.cells[1].textContent.split(" ")[0];
                    const lastName = row.cells[1].textContent.split(" ")[1];
                    const email = row.cells[2].textContent;
                    const cellphone = row.cells[3].textContent; // Fetch Cellphone
                    const role = row.cells[4].textContent;
                    const currentImage = row.cells[5].querySelector('img') ? row.cells[5].querySelector('img').src : '';

                    // Pre-fill the edit form with existing user data
                    document.getElementById('edit-user-id').value = userId;
                    document.getElementById('edit-first-name').value = firstName;
                    document.getElementById('edit-last-name').value = lastName;
                    document.getElementById('edit-email').value = email;
                    document.getElementById('edit-cellphone').value = cellphone; // Pre-fill Cellphone
                    document.getElementById('edit-role').value = role;
                    document.getElementById('current-image').src = currentImage;

                    // Show the Edit User modal
                    const modal = document.getElementById("edit-user-modal");
                    modal.style.display = "flex";
                    modal.classList.add('show-modal');
                });
            });

            // Close Edit User modal when the Cancel button is clicked
            const cancelButtonEdit = document.querySelector("#edit-user-modal .cancel-button");
            cancelButtonEdit.addEventListener('click', function() {
                const modal = document.getElementById("edit-user-modal");
                modal.classList.remove('show-modal');
                setTimeout(() => modal.style.display = "none");
            });




            document.getElementById('new-user-form').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent page reload

                const formData = new FormData(this); // Get form data

                // Get password and confirm password
                const password = formData.get('password');
                const confirmPassword = formData.get('confirm-password');

                // Validate password format (min 8 chars, at least one uppercase, one lowercase, and one number)
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
                if (!passwordRegex.test(password)) {
                    Swal.fire({
                        title: 'Invalid Password!',
                        text: 'Password must be at least 8 characters long, with at least one uppercase letter, one lowercase letter, and one number.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validate that password and confirm password are the same
                if (password !== confirmPassword) {
                    Swal.fire({
                        title: 'Password Mismatch!',
                        text: 'Password and Confirm Password must be the same.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validate email format
                const email = formData.get('email');
                const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (!emailRegex.test(email)) {
                    Swal.fire({
                        title: 'Invalid Email!',
                        text: 'Please enter a valid email address.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validate phone number (Philippines format, e.g., 09171234567)
                const cellphone = formData.get('cellphone');
                const phoneRegex = /^09\d{9}$/;
                if (!phoneRegex.test(cellphone)) {
                    Swal.fire({
                        title: 'Invalid Phone Number!',
                        text: 'Please enter a valid Philippine mobile number (e.g., 09171234567).',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validate image file size (max 2MB)
                const imageFile = formData.get('image');
                if (imageFile && imageFile.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        title: 'Image too large!',
                        text: 'The image file size should be less than 2MB.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                fetch('../../backend/controllers/add_user.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Dynamically add the user to the table
                            const userId = data.user.id;
                            const firstName = data.user.first_name;
                            const lastName = data.user.last_name;
                            const email = data.user.email;
                            const cellphone = data.user.cellphone; // Add Cellphone
                            const role = data.user.role;
                            const image = data.user.image;

                            const table = document.getElementById("user-table").getElementsByTagName('tbody')[0];
                            const newRow = table.insertRow();

                            newRow.setAttribute('data-user-id', userId);
                            newRow.setAttribute('data-role', role);

                            newRow.innerHTML = `
                    <td>${userId}</td>
                    <td>${firstName} ${lastName}</td>
                    <td>${email}</td>
                    <td>${cellphone}</td> <!-- Add Cellphone -->
                    <td>${role}</td>
                    <td>
                        ${image ? `<img src="../../frontend/public/images/users/${image}" alt="User Image" width="50" height="50">` : `<span>No Image</span>`}
                    </td>
                    <td>
                        <button class="action-button user-edit" data-user-id="${userId}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="action-button delete" data-user-id="${userId}"><i class="fas fa-trash"></i> Delete</button>
                    </td>
                `;

                            // Close the modal and reset the form
                            const modal = document.getElementById("new-user-modal");
                            modal.classList.remove('show-modal');
                            setTimeout(() => modal.style.display = "none");

                            Swal.fire({
                                title: 'Success!',
                                text: 'User added successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: `An unexpected error occurred: ${error.message}`,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            });


            document.getElementById('edit-user-form').addEventListener('submit', function(event) {
                event.preventDefault();

                // Get form values
                const firstName = document.getElementById('edit-first-name').value;
                const lastName = document.getElementById('edit-last-name').value;
                const email = document.getElementById('edit-email').value;
                const cellphone = document.getElementById('edit-cellphone').value;
                const image = document.getElementById('edit-image').files[0]; // Assuming you have an image input field with id 'edit-image'

                // Email validation
                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (!emailPattern.test(email)) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter a valid email address.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Cellphone number validation (Philippine format: starts with 09 and contains 10 digits)
                const cellphonePattern = /^09\d{9}$/;
                if (!cellphonePattern.test(cellphone)) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter a valid Philippine cellphone number (starts with 09 and contains 10 digits).',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Image validation (only accept jpg, jpeg, png, gif)
                const allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (image && !allowedImageTypes.includes(image.type)) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please upload a valid image (jpg, jpeg, png, gif).',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // If all validations pass, proceed with form submission
                const formData = new FormData(this);

                fetch('../../backend/controllers/edit_user.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const user = data.user;

                            // Dynamically update the table row in the relevant tab
                            updateUserRow(user.id, user.first_name, user.last_name, user.email, user.cellphone, user.role, user.image);

                            // Close the modal
                            const modal = document.getElementById("edit-user-modal");
                            modal.classList.remove('show-modal');
                            setTimeout(() => modal.style.display = "none", 300);

                            Swal.fire({
                                title: 'Success!',
                                text: 'User details updated successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'An unexpected error occurred.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: `An unexpected error occurred: ${error.message}`,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            });


        }

        function fetchAndLoadUsers() {
            fetch("../../backend/controllers/get_users.php")
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        loadUsersIntoTable(data.users);
                    } else {
                        console.error("Failed to load users:", data.message);
                    }
                })
                .catch(error => console.error("Error loading users:", error));
        }

        function loadUsersIntoTable(users) {
            const table = document.getElementById("user-table").querySelector("tbody");
            table.innerHTML = ""; // Clear existing table rows

            users.forEach(user => {
                addUserRow(user.id, user.first_name, user.last_name, user.email, user.cellphone, user.role, user.image, "user-table");
            });

            // Re-initialize edit and delete buttons for newly added rows
            initializeEditAndDeleteButtons();
        }

        // Function to update the user row in a given table by userId
        function updateUserRow(userId, firstName, lastName, email, cellphone, role, image) {
            // Map roles to their respective table IDs
            const roleToTableId = {
                "Admin": "admin-table",
                "Inventory Manager": "inventory-manager-table",
                "User": "user-table" // Default table (All Users)
            };

            // Determine the appropriate table ID based on the role
            const tableId = roleToTableId[role] || "user-table"; // Default to All Users if role is unrecognized
            const table = document.getElementById(tableId);

            // Locate the row in the identified table
            const userRow = table.querySelector(`tr[data-user-id="${userId}"]`);

            if (userRow) {
                // Update the table row content
                userRow.cells[1].textContent = `${firstName} ${lastName}`;
                userRow.cells[2].textContent = email;
                userRow.cells[3].textContent = cellphone; // Update Cellphone
                userRow.cells[4].textContent = role;
                userRow.cells[5].innerHTML = image ?
                    `<img src="../../frontend/public/images/users/${image}" alt="User Image" width="50" height="50">` :
                    '<span>No Image</span>';

                // Update the role attribute for filtering purposes
                userRow.setAttribute('data-role', role);
            }
        }

        // Function to add a new user row in a given table by userId
        function addUserRow(userId, firstName, lastName, email, cellphone, role, image, tableId) {
            const table = document.getElementById(tableId).querySelector('tbody');
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-user-id', userId);
            newRow.setAttribute('data-role', role);
            newRow.innerHTML = `
        <td>${userId}</td>
        <td>${firstName} ${lastName}</td>
        <td>${email}</td>
        <td>${cellphone}</td> <!-- Add Cellphone -->
        <td>${role}</td>
        <td>${image ? `<img src="${image}" alt="User Image" width="50" height="50">` : '<span>No Image</span>'}</td>
        <td>
            <button class="action-button user-edit" data-user-id="${userId}">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button class="action-button delete" data-user-id="${userId}"><i class="fas fa-trash"></i> Delete</button>
        </td>
    `;
            table.appendChild(newRow);

            // Re-initialize the event listeners for the new row
            initializeEditAndDeleteButtons();
        }

        // Function to reinitialize the Edit and Delete buttons after updating rows
        function initializeEditAndDeleteButtons() {
            // Re-initialize the Edit button functionality
            document.querySelectorAll('.action-button.user-edit').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.closest('tr').getAttribute('data-user-id');
                    const row = this.closest('tr');
                    const firstName = row.cells[1].textContent.split(" ")[0];
                    const lastName = row.cells[1].textContent.split(" ")[1];
                    const email = row.cells[2].textContent;
                    const cellphone = row.cells[3].textContent; // Fetch Cellphone
                    const role = row.cells[4].textContent;
                    const currentImage = row.cells[5].querySelector('img') ? row.cells[5].querySelector('img').src : '';

                    // Pre-fill the edit form
                    document.getElementById('edit-user-id').value = userId;
                    document.getElementById('edit-first-name').value = firstName;
                    document.getElementById('edit-last-name').value = lastName;
                    document.getElementById('edit-email').value = email;
                    document.getElementById('edit-cellphone').value = cellphone; // Pre-fill Cellphone
                    document.getElementById('edit-role').value = role;
                    document.getElementById('current-image').src = currentImage;

                    // Show the Edit User modal
                    const modal = document.getElementById("edit-user-modal");
                    modal.style.display = "flex";
                    modal.classList.add('show-modal');
                });
            });



            // Re-initialize the Delete button functionality
            document.querySelectorAll('.action-button.delete').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You won\'t be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('../../backend/controllers/delete_user.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        id: userId
                                    }),
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire(
                                            'Deleted!',
                                            'User has been deleted.',
                                            'success'
                                        );
                                        document.querySelector(`tr[data-user-id="${userId}"]`).remove();
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            data.message,
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire(
                                        'Error!',
                                        'An unexpected error occurred. Please try again.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });
        }


        // Initialize the User Management functionality
        initializeUserManagement();
        initializeEditAndDeleteButtons(); // Initialize edit/delete buttons when the page loads
    </script>


    <script>
        // Utility function for debouncing
        function debounce(func, delay) {
            let timer;
            return function(...args) {
                clearTimeout(timer);
                timer = setTimeout(() => func.apply(this, args), delay);
            };
        }

        // Function to filter rows in user management tables
        function filterUserRows(event) {
            const keyword = event.target.value.toLowerCase().trim();
            const container = event.target.closest('.user-management-container');
            const allTabContents = container.querySelectorAll('.tab-content');

            allTabContents.forEach(tabContent => {
                const rows = tabContent.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    const cells = Array.from(row.querySelectorAll('td:not(:has(img, input, button))')); // Skip non-text content
                    let rowMatches = false;

                    // Check if any text cell matches the keyword
                    cells.forEach(cell => {
                        const originalText = cell.getAttribute('data-original-text') || cell.textContent;
                        if (!cell.hasAttribute('data-original-text')) {
                            cell.setAttribute('data-original-text', originalText); // Save the original content
                        }

                        const cellText = originalText.toLowerCase();
                        if (cellText.includes(keyword)) {
                            rowMatches = true;
                            // Highlight matching text
                            const regex = new RegExp(`(${keyword})`, 'gi');
                            cell.innerHTML = originalText.replace(regex, '<mark>$1</mark>');
                        } else {
                            cell.innerHTML = originalText; // Reset to original content
                        }
                    });

                    // Show or hide the row based on matches
                    row.style.display = rowMatches ? '' : 'none';
                });
            });

            // Reset rows when keyword is empty
            if (!keyword) {
                resetUserTableFilters(container);
            }
        }

        // Function to reset all rows and remove highlights
        function resetUserTableFilters(container) {
            const allTabContents = container.querySelectorAll('.tab-content');
            allTabContents.forEach(tabContent => {
                const rows = tabContent.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    row.style.display = ''; // Reset visibility
                    const cells = row.querySelectorAll('td');
                    cells.forEach(cell => {
                        const originalText = cell.getAttribute('data-original-text');
                        if (originalText) {
                            cell.innerHTML = originalText; // Restore original text content
                        }
                    });
                });
            });
        }

        // Attach input event listeners to filter inputs
        document.querySelectorAll('.filter-input').forEach(filterInput => {
            filterInput.addEventListener('input', debounce(filterUserRows, 300));
        });
    </script>



</body>

</html>










<!-- Css for user management -->
<style>
    @import url('https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: #f4f7fc;
        margin: 0;
        padding: 0;
        height: 100vh;
        overflow: hidden;
    }

    .user-management-container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
        background-color: #ffffff;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        height: 95vh;
        display: flex;
        flex-direction: column;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header h1 {
        font-size: 22px;
        color: #333;
        font-weight: 600;
    }

    .new-user-button {
        background-color: #007bff;
        color: #fff;
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .new-user-button:hover {
        background-color: #0056b3;
    }

    .filters {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .tabs-container {
        display: flex;
        align-items: flex-end;
        gap: 5px;
    }

    .tab {
        padding: 8px 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 10px 10px 0 0;
        cursor: pointer;
        font-size: 12px;
        transition: background-color 0.3s, color 0.3s;
        font-weight: 500;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        z-index: 1;
        position: relative;
    }

    .tab.active {
        background-color: white;
        color: #007bff;
        z-index: 2;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
    }

    .tab i {
        margin-right: 8px;
    }

    .tab:hover {
        background-color: #0056b3;
    }

    .filter-input-container {
        display: flex;
        align-items: center;
        position: relative;
    }

    .filter-input {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 20px;
        width: 220px;
        color: #333;
        font-size: 12px;
    }

    .icon-filter {
        position: absolute;
        right: 16px;
        color: #aaa;
    }

    .user-table {
        width: 100%;
        table-layout: fixed;
        /* Enables fixed column widths */
        border-collapse: collapse;
        background-color: #fff;
        border-radius: 10px;
        overflow-y: auto;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        flex-grow: 1;
    }

    .user-table th,
    .user-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #eee;
        overflow: hidden;
        /* Hides overflowing text */
        text-overflow: ellipsis;
        /* Adds ellipsis for truncated text */
        white-space: nowrap;
        /* Prevents text wrapping */
        text-align: center;
    }

    .user-table th {
        background-color: #f4f7fc;
        color: #555;
        font-size: 12px;
        font-weight: 600;
    }

    .user-table td {
        color: #555;
        font-size: 12px;
    }

    .user-table tr:last-child td {
        border-bottom: none;
    }

    /* Specify fixed column widths */
    .user-table th:nth-child(1),
    .user-table td:nth-child(1) {
        width: 10%;
        /* Adjust as needed for User ID */
    }

    .user-table th:nth-child(2),
    .user-table td:nth-child(2) {
        width: 20%;
        /* Adjust as needed for Name */
    }

    .user-table th:nth-child(3),
    .user-table td:nth-child(3) {
        width: 20%;
        /* Adjust as needed for Email */
    }

    .user-table th:nth-child(4),
    .user-table td:nth-child(4) {
        width: 15%;
        /* Adjust as needed for Cellphone */
    }

    .user-table th:nth-child(5),
    .user-table td:nth-child(5) {
        width: 15%;
        /* Adjust as needed for Role */
    }

    .user-table th:nth-child(6),
    .user-table td:nth-child(6) {
        width: 8%;
        /* Adjust as needed for Image */
    }

    .user-table th:nth-child(7),
    .user-table td:nth-child(7) {
        width: 20%;
        /* Adjust as needed for Actions */
    }



    .action-button {
        background-color: #007bff;
        color: #fff;
        padding: 6px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 500;
        margin-right: 5px;
        transition: background-color 0.3s ease;
    }

    .action-button.user-edit {
        background-color: #ffc107;
    }

    .action-button.delete {
        background-color: #dc3545;
    }

    .action-button:hover {
        opacity: 0.9;
    }

    /* Hidden by default, shown when active */
    .tab-content {
        display: none;
        padding-top: 20px;
    }

    .tab-content.active {
        display: block;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        transition: opacity 0.3s ease-in-out;
    }

    .modal.show-modal {
        opacity: 1;
    }

    .modal-content {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        width: 40%;
        transition: transform 0.3s ease;
        transform: translateY(-20px);
        animation: modalFadeIn 0.3s forwards;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 600;
        color: #333;
        font-size: 12px;
    }

    .form-group input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 12px;
        background-color: #f9f9f9;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus {
        border-color: #007bff;
        outline: none;
    }

    .form-group select {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 12px;
        background-color: #f9f9f9;
        transition: border-color 0.3s ease;
        width: 100%;
        /* Ensures the dropdown spans the full width of the form */
    }

    .form-group select:focus {
        border-color: #007bff;
        outline: none;
    }

    .form-group select option {
        padding: 10px;
    }

    .buttons-row {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .cancel-button,
    .save-user-button {
        padding: 10px 15px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .cancel-button {
        background-color: transparent;
        color: #007bff;
        border: 2px solid #007bff;
        width: 200px;
    }

    .cancel-button:hover {
        background-color: #f0f0ff;
    }

    .save-user-button {
        background-color: #007bff;
        color: white;
        width: 200px;
    }

    .save-user-button:hover {
        background-color: #0056b3;
    }
</style>