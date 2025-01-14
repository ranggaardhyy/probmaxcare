<?php
include '../views/header.php';
include '../config/db.php';

// Pastikan hanya admin yang dapat mengakses
session_start();
if ($_SESSION['role_id'] !== 1) { // Role admin adalah 1
    header('Location: ../views/login.php');
    exit();
}

$action = $_GET['action'] ?? 'read'; // Tindakan: read, create, update, delete
$role = $_GET['role'] ?? 'consultant'; // Role: consultant (default) atau user
$id = $_GET['id'] ?? null;

// Ambil data role dari database untuk dropdown
$stmt = $pdo->query("SELECT id, name FROM roles"); // Asumsi ada tabel roles dengan kolom id dan name
$roles = $stmt->fetchAll();

// Proses CRUD berdasarkan tindakan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;
    $role_id = $_POST['role_id']; // Ambil role_id yang dipilih dari form

    if ($action === 'create') {
        // Tambah data
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role_id, created_at) VALUES (:username, :email, :password, :role_id, NOW())");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role_id' => $role_id
        ]);
        header("Location: CRUD.php?role=$role");
        exit();
    } elseif ($action === 'update' && $id) {
        // Update data
        $updateQuery = "UPDATE users SET username = :username, email = :email, role_id = :role_id";
        $params = ['username' => $username, 'email' => $email, 'role_id' => $role_id, 'id' => $id];

        if ($password) {
            $updateQuery .= ", password = :password";
            $params['password'] = $password;
        }

        $updateQuery .= " WHERE id = :id";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute($params);
        header("Location: CRUD.php?role=$role");
        exit();
    }
} elseif ($action === 'delete' && $id) {
    // Hapus data terkait di tabel `daily_feedback`
    $stmt = $pdo->prepare("DELETE FROM daily_feedback WHERE user_id = :id");
    $stmt->execute(['id' => $id]);
    
    // Hapus data di tabel `users`
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id AND role_id = :role_id");
    $stmt->execute(['id' => $id, 'role_id' => ($role === 'consultant') ? 2 : 3]);
    
    header("Location: CRUD.php?role=$role");
    exit();
}


// Ambil data untuk Read atau Edit
$accounts = [];
$account = null;
if ($action === 'read') {
    $role_id = ($role === 'consultant') ? 2 : 3;
    $stmt = $pdo->prepare("SELECT id, username, email, created_at FROM users WHERE role_id = :role_id");
    $stmt->execute(['role_id' => $role_id]);
    $accounts = $stmt->fetchAll();
} elseif ($action === 'update' && $id) {
    $stmt = $pdo->prepare("SELECT id, username, email, role_id FROM users WHERE id = :id AND role_id = :role_id");
    $stmt->execute(['id' => $id, 'role_id' => ($role === 'consultant') ? 2 : 3]);
    $account = $stmt->fetch();
    if (!$account) {
        header("Location: CRUD.php?role=$role");
        exit();
    }
}
?>

<div class="relative min-h-screen bg-cover bg-center bg-fixed" style="background-image: url('../assets/images/bg/supri.jpeg');">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="container mx-auto p-6 relative z-10">
        <h1 class="text-3xl font-semibold mb-6 text-white">Manajemen Akun <?= ucfirst($role) ?></h1>
        <a href="CRUD.php?role=consultant" class="bg-pink-700 text-white px-4 py-2 rounded hover:bg-pink-400">Manajemen Konsultan</a>
        <a href="CRUD.php?role=user" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-400">Manajemen Pengguna</a>

        <?php if ($action === 'read'): ?>
            <!-- Tampilkan Daftar -->
            <a href="CRUD.php?action=create&role=<?= $role ?>" class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-400 mt-4 inline-block">Tambah Akun</a>
            <table class="w-full mt-6 border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 text-white px-4 py-2">ID</th>
                        <th class="border border-gray-300 text-white px-4 py-2">Username</th>
                        <th class="border border-gray-300 text-white px-4 py-2">Email</th>
                        <th class="border border-gray-300 text-white px-4 py-2">Created At</th>
                        <th class="border border-gray-300 text-white px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $account): ?>
                        <tr>
                            <td class="border border-gray-300 text-white px-4 py-2"><?= htmlspecialchars($account['id']) ?></td>
                            <td class="border border-gray-300 text-white px-4 py-2"><?= htmlspecialchars($account['username']) ?></td>
                            <td class="border border-gray-300 text-white px-4 py-2"><?= htmlspecialchars($account['email']) ?></td>
                            <td class="border border-gray-300 text-white px-4 py-2"><?= htmlspecialchars($account['created_at']) ?></td>
                            <td class="border border-gray-300 text-white px-4 py-2">
                                <a href="CRUD.php?action=update&role=<?= $role ?>&id=<?= $account['id'] ?>" class="text-green-500 hover:underline">Edit</a> |
                                <a href="CRUD.php?action=delete&role=<?= $role ?>&id=<?= $account['id'] ?>" class="text-red-500 hover:underline" onclick="return confirm('Hapus akun ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($action === 'create' || ($action === 'update' && $account)): ?>
            <!-- Form Tambah / Edit -->
            <form method="POST" class="space-y-4 text-white p-6 rounded-lg shadow-lg">
                <div>
                    <label>Username:</label>
                    <input class= "text-white mt-3 mb-4 w-full p-2 rounded-lg bg-transparent border border-gray-400 px-4 py-2" type="text" name="username" value="<?= htmlspecialchars($account['username'] ?? '') ?>" class="border px-4 py-2 w-full" required>
                </div>
                <div>
                    <label>Email:</label>
                    <input class= "text-whtie mt-3 mb-4 w-full p-2 rounded-lg bg-transparent border border-gray-400 px-4 py-2" type="email" name="email" value="<?= htmlspecialchars($account['email'] ?? '') ?>" class="border px-4 py-2 w-full" required>
                </div>
                <?php if ($action === 'create'): ?>
                    <div>
                    <label>Password:</label>
                    <input class= "text-white mt-3 mb-4 w-full p-2 rounded-lg bg-transparent border border-gray-400 px-4 py-2" type="password" name="password" class="border px-4 py-2 w-full" required>
                    </div>
                <?php endif; ?>
                <div>
                    <label>Role:</label>
                    <select class= "text-white mt-3 mb-4 w-full p-2 rounded-lg bg-transparent border border-gray-400 px-4 py-2"  name="role_id" class="border px-4 py-2 w-full">
                        <?php foreach ($roles as $role_option): ?>
                            <option class= "text-gray-600" value="<?= $role_option['id'] ?>" <?= (isset($account['role_id']) && $account['role_id'] == $role_option['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($role_option['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded"><?= $action === 'create' ? 'Simpan' : 'Update' ?></button>
                <a href="CRUD.php?role=<?= $role ?>" class="ml-2 text-red-500">Batal</a>
            </form>
        <?php endif; ?>
    </div>
</div>


