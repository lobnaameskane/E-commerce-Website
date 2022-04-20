<?php
$x = 0;
$is_profile = basename(dirname($_SERVER['SCRIPT_FILENAME']))  == "profile";

if (isset($_POST["password"])) {
  require(($is_profile ? "../" : "./") . "php/connection/db.php");

  $email_client = htmlspecialchars($_POST["email"]);
  $pass = $_POST["password"];
  $query = "SELECT  id_client, nom_client, prenom_client,tel_client,  mdp_client FROM client where email = :email_client and act=1 ";
  $sql = $conn->prepare($query);
  $sql->execute(array("email_client" => $email_client));

  if ($row = $sql->fetch())
    if (password_verify($pass, $row["mdp_client"])) {
      $_SESSION["email_client"] = $email_client;
      $_SESSION["nom_client"] = $row["nom_client"];
      $_SESSION["prenom_client"] = $row["prenom_client"];
      $_SESSION["id_client"] = $row["id_client"];
      $_SESSION["tel_client"] = $row["tel_client"];
      $_SESSION["connection_status"] = "connected";
      //header("location: ".$_SESSION["LAST_PAGE"]); //pour etre envoyer a la page voulue au depart
    } else {
      $x = 1;
    }
  else
    $x = 1;
  if ($x == 1) {
    echo "
      <script>
      $( document ).ready(function() {
        $('#toast_connex').toast({
          delay: 3000
      })
      $('#toast_connex').toast('show')
       });
      </script>
      
      ";
  }
}


?>
<div class="toast bg-danger text-light" role="alert" id="toast_connex" aria-live="assertive" style="position: absolute; top: 100px; right: 0;" aria-atomic="true">
  <div class="toast-header">
    <i class="bi bi-x-octagon-fill text-danger"></i>
    <strong class="mr-auto">Erreur de conenxion</strong>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    Erreur de connexion : Compte inexistant ou MDP incorrect
  </div>
</div>
<nav class="navbar navbar-expand-sm  fixed-top navbar-light bg-light ">
  <a class="navbar-brand" href="<?php echo $is_profile ? "../" : "";  ?>index.php" class="h4" style="color:navy">
    <img src="<?php echo $is_profile ? "../" : "";  ?>img/logo.png" alt="" height="50">
    AMOIL
  </a>

  <?php if ($_SERVER['REQUEST_URI'] != "/" && $_SERVER['REQUEST_URI'] != "/index.php") {
  ?>
    <div class="col-6 col-lg-8  col-md-5 col-sm-4 d-flex justify-content-center">
      <form action="navigation" method="get" class="col-12">
        <input class="form-control col-12 " name="search" type="text" placeholder="Search..." style="width: 80%;">

      </form>

    </div><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  <?php }
  ?>
  <div class=" collapse navbar-collapse " id="navbarNavDropdown">
    <ul class="ml-md-auto navbar-nav">
      <li class="nav-item">
        <a href="<?php echo $is_profile ? "../" : "";  ?>cart" class="nav-link pl-2 pr-1 mx-1 py-3 my-n2" aria-label="Panier">
          <i class="bi bi-cart4 mr-4" style="font-size: 2rem;"></i>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $is_profile ? "./" : "profile/";  ?>wishlist.php" class="nav-link pl-2 pr-1 mx-1 py-3 my-n2" aria-label="favoris">


          <i class="bi bi-heart-fill ml-md-4 ml-lg-4 ml-sm-4  mr-4" style="font-size: 2rem;"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a href="#" id="navbarDropdownAccount" class="nav-link dropdown-toggle  pl-2 pr-1 mx-1 py-3 my-n2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Compte">
          <i class="bi bi-person-circle ml-md-4 ml-lg-4 ml-sm-4" style="font-size: 2rem;"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
          <?php
          if (!isset($_SESSION["id_client"])) {
          ?>

            <form class="px-4 py-3" method="POST">
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="email@example.com">
              </div>
              <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
              </div>
              <div class="form-group">
                <div class="form-check">

                </div>
              </div>
              <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="inscription_client">creer un compte</a>
            <a class="dropdown-item" data-toggle="modal" data-target="#modal_password_forgotten">Mot de passe Oublié?</a>
          <?php
          } else {

          ?>
            <a class="dropdown-item" href="<?php echo $is_profile ? "../" : "";  ?>profile/infos">Parametres compte</a>
            <a class="dropdown-item" href="<?php echo $is_profile  ? "../" : ""; ?>profile/commandes">Historique commandes</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo $is_profile ? "../" : ""; ?>php/clients/logout?page=<?php echo $is_profile ? "../index" : basename($_SERVER['SCRIPT_FILENAME'])  ?>">Se deconnecter</a>
          <?php
          }
          ?>
        </div>
      </li>
    </ul>


  </div>
  </div>
</nav>
<div class="modal fade" id="modal_password_forgotten" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Support Problemes de connections</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Pour tout support concernant la connection . Merci de contacter : <a href="mailto:support@amoil.com">support@amoil.com</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>