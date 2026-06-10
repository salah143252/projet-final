<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Utilisateurs - ParaCare Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <?php require_once 'views/admin/sidebar.php'; ?>

    <!-- Contenu principal -->
    <div class="admin-content">
        <div class="admin-header">
            <div>
                <h1>Gestion des Utilisateurs</h1>
                <p style="color:#888; font-size:13px; margin-top:3px;"><?php echo count($utilisateurs); ?> utilisateur(s) inscrit(s)</p>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <?php if (empty($utilisateurs)): ?>
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>Aucun utilisateur inscrit</h3>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Rôle</th>
                        <th>Date d'inscription</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateurs as $user): ?>
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="avatar-initials" style="<?php echo $user['role'] == 'admin' ? 'background:linear-gradient(135deg,#9b59b6,#8e44ad);' : ''; ?>">
                                    <?php echo strtoupper(substr($user['prenom'], 0, 1) . substr($user['nom'], 0, 1)); ?>
                                </div>
                                <div>
                                    <strong><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></strong>
                                    <br><small style="color:#888;">ID: <?php echo $user['id_user']; ?></small>
                                </div>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <?php if (!empty($user['telephone'])): ?>
                                <i class="fas fa-phone" style="color:#2D9CDB; font-size:12px; margin-right:4px;"></i>
                                <?php echo htmlspecialchars($user['telephone']); ?>
                            <?php else: ?>
                                <span style="color:#ccc;">Non renseigné</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['role'] == 'admin'): ?>
                                <span class="role-badge role-admin">
                                    <i class="fas fa-shield-alt"></i> Admin
                                </span>
                            <?php else: ?>
                                <span class="role-badge role-client">
                                    <i class="fas fa-user"></i> Client
                                </span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                        <td>
                            <?php if ($user['role'] != 'admin'): ?>
                                <a href="index.php?page=admin&action=supprimer_user&id=<?php echo $user['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            <?php else: ?>
                                <span style="color:#888; font-size:12px;"><i class="fas fa-lock"></i> Protégé</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
