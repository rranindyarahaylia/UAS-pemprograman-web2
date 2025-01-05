<?php
include 'task.php'; // Menghubungkan file task.php untuk mengelola tugas
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            background: #2C3E50;
            color: white;
            position: fixed;
            transition: all 0.3s;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        .task-card {
            transition: transform 0.2s;
        }

        .task-card:hover {
            transform: translateY(-5px);
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            .content {
                margin-left: 0;
            }
            .sidebar.active {
                margin-left: 0;
            }
            .content.active {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar px-3 py-4" style="width: 250px;">
        <h3 class="mb-4 text-white">Todo App</h3>
        <ul class="nav flex-column">
            <li class="nav-item mb-3">
                <a href="#" class="nav-link text-white">
                    <i class="bx bx-home"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="#" class="nav-link text-white">
                    <i class="bx bx-list-ul"></i> Tasks
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="bx bx-user"></i> Profile
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content flex-grow-1">
        <nav class="navbar bg-white shadow-sm mb-4">
            <div class="container-fluid">
                <button class="btn btn-link" id="menu-toggle">
                    <i class="bx bx-menu fs-4"></i>
                </button>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <i class="bx bx-user-circle fs-4"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>My Tasks</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="bx bx-plus"></i> Add New Task
                </button>
            </div>

            <!-- Task Cards -->
            <div class="row">
                <?php foreach ($tasks as $task): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card task-card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($task['description']); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-<?php echo $task['status'] == 'completed' ? 'success' : ($task['status'] == 'in_progress' ? 'warning' : 'secondary'); ?>">
                                        <?php echo ucfirst($task['status']); ?>
                                    </span>
                                    <div>
                                        <!-- Tombol Edit -->
                                        <a href="index.php?edit_id=<?php echo $task['id']; ?>" class="btn btn-sm btn-primary me-2">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <a href="task.php?delete_id=<?php echo $task['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data?');">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Task -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="task.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Task Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="save_task">Save Task</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Task (Jika Ada) -->
<?php if (isset($task_to_edit)): ?>
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="task.php" method="POST">
                    <input type="hidden" name="task_id" value="<?php echo $task_to_edit['id']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Task Title</label>
                        <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($task_to_edit['title']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"><?php echo htmlspecialchars($task_to_edit['description']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="pending" <?php echo $task_to_edit['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="in_progress" <?php echo $task_to_edit['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="completed" <?php echo $task_to_edit['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_task">Update Task</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle sidebar
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
        document.querySelector('.content').classList.toggle('active');
    });

    // Show modal edit jika ada
    <?php if (isset($task_to_edit)): ?>
        var myModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
        myModal.show();
    <?php endif; ?>
</script>

</body>
</html>
