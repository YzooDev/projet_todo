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
    <li><a href="/category/all">Catégories</a></li>
    <li><a href="/category/new">Ajout Catégorie</a></li>
    <li><a href="/task/new">Ajout Tache</a></li>
    <li><a href="/task/activeall">Mes Taches Actives</a></li>
    <li><a href="/task/inactiveall">Mes Taches Inactives</a></li>
    <li><a href="/logout">Déconnexion</a></li>
    <?php endif ?>
  </ul>
</nav>