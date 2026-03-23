<nav class="container-fluid">
  <ul>
    <li><strong>Todo List</strong></li>
  </ul>
  <ul>
    <li><a href="/">Accueil</a></li>
    <!-- Menu déconnecté -->
    <?php if(!isset($_SESSION["connected"])): ?>
    <li><a href="/register">Inscription</a></li>
    <li><a href="/login">Connexion</a></li>
    <!-- Menu connecté -->
    <?php else : ?>
    <li><a href="/category/all">Categories</a></li>
    <li><a href="/category/new">Ajout Category</a></li>
    <li><a href="/logout">Déconnexion</a></li>
    <?php endif ?>
  </ul>
</nav>