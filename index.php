<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="png" href="images/icon/lili.png" />
    <title>EduShop - Plateforme de cours en ligne</title>

    <!-- Charger uniquement ton style principal -->
    <link rel="stylesheet" href="css/style.css" />

    <!-- Google Fonts si besoin -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins :wght@400;600&display=swap" rel="stylesheet">

    <!-- Script facultatif pour le menu mobile -->
    <script>
        function sideMenu(toggle) {
            const menu = document.getElementById('side-menu');
            menu.style.right = toggle === 1 ? '-100%' : '0';
        }
    </script>
</head>
<body class="bg-gray-50">

<!-- HEADER AVEC NAVBAR -->
<header id="header">
    <nav class="navbar">
        <div class="logo">
            <img src="images/lolo.jpg" alt="Logo EduShop" />
        </div>

        <ul class="desktop-nav">
            <li><a class="<?= ($_SERVER['PHP_SELF'] == '/index.php') ? 'active' : '' ?>" href="index.php">Accueil</a></li>
            <li><a href="#portfolio_section">Portfolio</a></li>
            <li><a href="#services_section">Services</a></li>
            <li><a href="#contactus_section">Contact</a></li>
        </ul>

        <?php if (isset($_SESSION['user'])): ?>
            <a class="get-started" href="logout.php">Déconnexion</a>
        <?php else: ?>
            <a class="get-started" href="login.php">Connexion</a>
        <?php endif; ?>

        
        <!-- Menu burger pour mobile -->
        <img src="images/icon/menu.png" class="menu" onclick="sideMenu(0)" alt="Menu" />
    </nav>

    <!-- Hero Title -->
    <div class="head-container">
        <div class="quote">
            <p>Investissez en vous : ce que vous apprenez est une richesse éternelle, impossible à perdre.</p>
            <h5>Un apprentissage personnalisé et interactif....</h5>
            
            <h6 style="color:rgb(244, 41, 163);">Des cours pour tous les budgets et tous les niveaux.</h6>
                <div class="play">
                <img src="images/icon/play.png" alt="Play" />
                <span><a href="https://www.youtube.com " target="_blank">Watch Now</a></span>
            </div>
        </div>
        <div class="svg-image">
            <img src="images/extra/svg1.jpg" alt="Illustration éducative" />
        </div>
    </div>

    <!-- Side Menu Mobile -->
    <div class="side-menu" id="side-menu">
        <div class="close" onclick="sideMenu(1)">
            <img src="images/icon/close.png" alt="Fermer" />
        </div>
        <div class="user">
            <img src="images/icon/user.png" alt="User" />
            <p><?= isset($_SESSION['user']) ? $_SESSION['user']['email'] : 'Visiteur' ?></p>
        </div>
        <ul>
            <li><a href="#about_section">À propos</a></li>
            <li><a href="#portfolio_section">Portfolio</a></li>
            <li><a href="#services_section">Services</a></li>
            <li><a href="#contactus_section">Contact</a></li>
            <li><a href="#feedBACK">Feedback</a></li>
        </ul>
    </div>
</header>

<!-- SECTION COURS POPULAIRES -->
<div class="title">
    <span>Nos Formations Populaires</span>
</div>

<br /><br />

<div class="course">
    <center>
        <div class="cbox grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="det">
                <a href="courses.php?category=programmation">
                    <img src="images/courses/book.png" />Cours de programmation
                </a>
            </div>
            <div class="det">
                <a href="courses.php?category=web">
                    <img src="images/courses/web.png" />Développement Web
                </a>
            </div>
            <div class="det">
                <a href="courses.php?category=data">
                    <img src="images/courses/data.png" />Structures de données
                </a>
            </div>
            <div class="det">
                <a href="courses.php?category=algorithm">
                    <img src="images/courses/algo.png" />Algorithmes
                </a>
            </div>
        </div>
    </center>
</div>

<!-- ABOUT -->
<div class="diffSection" id="about_section">
  <center><p style="font-size: 50px; padding: 100px">About</p></center>
  <div class="about-content">
    <div class="side-image">
      <img class="sideImage" src="images/extra/e3.jpg" />
    </div>
    <div class="side-text">
      <h2>Qu'est-ce que EduShop ?</h2>
      <p>
        EduShop est une plateforme d'apprentissage en ligne qui propose des cours gratuits et payants. 
        Grâce à HTML, CSS et JavaScript, nous rendons l'apprentissage amusant et attractif.
      </p>
    </div>
  </div>
</div>

<!-- PORTFOLIO -->
<div class="diffSection" id="portfolio_section">
  <center>
    <p style="font-size: 50px; padding: 100px; padding-bottom: 40px">
      Portfolio
    </p>
  </center>
  <div class="content">
    <p>
      "Le savoir est le seul bagage que vous pouvez emporter partout, sans jamais le perdre"
    </p>
  </div>
</div>
<div class="extra">
  <p>Croissance Annuelle des Données  </p>
  <div class="smbox">
    <span
      ><center>
        <div class="data">154</div>
        <div class="det">Enrolled Students</div>
      </center></span
    >
    <span
      ><center>
        <div class="data">62</div>
        <div class="det">Total Courses</div>
      </center></span
    >
    <span
      ><center>
        <div class="data">56</div>
        <div class="det">Placed Students</div>
      </center></span
    >
    <span
      ><center>
        <div class="data">27</div>
        <div class="det">Total Projects</div>
      </center></span
    >
  </div>
</div>

<!-- SERVICES -->
<div class="service-swipe">
  <div class="diffSection" id="services_section">
    <center>
      <p
        style="
          font-size: 50px;
          padding: 100px;
          padding-bottom: 40px;
          color: #fff;
        "
      >
        Services
      </p>
    </center>
  </div>
  <a href="subjects/computer_courses.html"
    ><div class="s-card">
      <img src="images/icon/computer-courses.png" />
      <p>Free Online Computer Courses</p>
    </div></a
  >
  <a href="subjects/jee.html"
    ><div class="s-card">
      <img src="images/icon/brainbooster.png" />
      <p>Building Concepts for Competitive Exams</p>
    </div></a
  >
  <a href="#"
    ><div class="s-card">
      <img src="images/icon/online-tutorials.png" />
      <p>Online Video Lectures</p>
    </div></a
  >
  <a href="subjects/jee.html#sample_papers"
    ><div class="s-card">
      <img src="images/icon/papers.jpg" />
      <p>Sample Papers of Various Competitive Exams</p>
    </div></a
  >
  <a href="#"
    ><div class="s-card">
      <img src="images/icon/p3.png" />
      <p>Performance and Ranking Report</p>
    </div></a
  >
  <a href="#contactus_section"
    ><div class="s-card">
      <img src="images/icon/discussion.png" />
      <p>Discussion with Our Tutors & Mentors</p>
    </div></a
  >
  <a href="subjects/quiz.html"
    ><div class="s-card">
      <img src="images/icon/q1.png" />
      <p>Daily Brain Teasing Questions to Improve IQ</p>
    </div></a
  >
  <a href="#contactus_section"
    ><div class="s-card">
      <img src="images/icon/help.png" />
      <p>24x7 Online Support</p>
    </div></a
  >
</div>

<!-- REVIEWS -->
<div id="makeitfull">
    <a href="#review_section">
        <img src="images/icon/makeitfull.png" alt="Voir avis" />
    </a>
</div>
<div class="review">
    <div class="diffSection" id="review_section">
        <center>
            <p style="font-size: 40px; padding: 100px; padding-bottom: 40px; color: #2e3d49;">
                Ce que disent nos étudiants
            </p>
        </center>
    </div>
    <div class="rev-container">
        <div class="rev-card">
            <div class="identity">
                <img src="images/humanNotExist4.jpg" alt="Avis utilisateur 1" />
                <p>Sophie Daniel</p>
                <h6>Java</h6>
                <div class="rating">
                    <img src="images/icon/star.png" />
                    <img src="images/icon/star.png" />
                    <img src="images/icon/star.png" />
                    <img src="images/icon/star.png" />
                    <img src="images/icon/star.png" />
                </div>
            </div>
            <div class="rev-cont">
                <p id="title">Avis:</p>
                <p id="content">
                    J'ai suivi le cours Java Fondamental avec Rishab Sir. C'était une expérience incroyable. Les exercices, les défis et les explications étaient clairs et passionnants.
                </p>
            </div>
        </div>
        <div class="rev-card">
            <div class="identity">
                <img src="images/humanNotExist2.jpg" alt="Avis utilisateur 2" />
                <p>Clayton Sethi</p>
                <h6>C/C++</h6>
                <div class="rating">
                    <img src="images/icon/star.png" />
                    <img src="images/icon/star.png" />
                    <img src="images/icon/star.png" />
                    <img src="images/icon/star.png" />
                    <img src="images/icon/star.png" />
                </div>
            </div>
            <div class="rev-cont">
                <p id="title">Avis:</p>
                <p id="content">
                    Edulinks m'a permis de développer ma logique de programmation. Arnav Bhaiya explique très bien et rend chaque concept facile à comprendre.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- CONTACT US -->
<div class="diffSection" id="contactus_section">
    <center><p style="font-size: 50px; padding: 100px">Contactez-nous</p></center>
    <div class="csec"></div>
    <div class="back-contact">
        <div class="cc">
            <form action="mailto:votre@email.com" method="post" enctype="text/plain" onsubmit="showLoading(event)">
                <label>Nom <span class="imp">*</span></label>
                <label style="margin-left: 185px">Prénom <span class="imp">*</span></label>
                <br />
                <center>
                    <input type="text" name="fname" style="margin-right: 10px; width: 175px" required />
                    <input type="text" name="lname" style="width: 175px" required />
                    <br />
                </center>
                <label>Email <span class="imp">*</span></label><br />
                <input type="email" name="mail" style="width: 100%" required /><br />
                <label>Message <span class="imp">*</span></label><br />
                <input type="text" name="message" style="width: 100%" required /><br />
                <label>Détails supplémentaires</label><br />
                <textarea name="additional"></textarea><br />
                <button type="submit" id="csubmit">Envoyer</button>
            </form>
        </div>
    </div>
</div>

<!-- FEEDBACK -->
<div class="title2" id="feedBACK">
    <span>Donnez votre avis</span>
    <div class="shortdesc2">
        <p>Merci de partager votre retour</p>
    </div>
</div>
<div class="feedbox">
    <div class="feed">
        <form action="mailto:feedback@example.com" method="post" enctype="text/plain" onsubmit="showFeedbackLoading(event)">
            <label>Votre nom</label><br />
            <input type="text" name="fname" class="fname" required />
            <br />
            <label>Email</label><br />
            <input type="email" name="mail" required />
            <br />
            <label>Détails supplémentaires</label><br />
            <textarea name="additional"></textarea><br />
            <button type="submit" id="csubmit">Envoyer</button>
        </form>
    </div>
</div>

<!-- SLIDING TEXT -->
<marquee
    style="background: linear-gradient(to right, #fa4b37, #df2771); margin-top: 50px;"
    direction="left"
    onmouseover="this.stop()"
    onmouseout="this.start()"
    scrollamount="20">
    <div class="marqu">
        "L'éducation est le passeport vers le futur" – "Votre attitude déterminera votre altitude" – "Si vous trouvez l'éducation coûteuse, essayez l'ignorance"
    </div>
</marquee>

<!-- FOOTER -->
<footer>
    <div class="footer-container">
        <div class="left-col">
            <img src="images/icon/image2.JPG" style="width: 200px" />
            <div class="logo"></div>
            <p>
                EduShop est une plateforme d'apprentissage en ligne qui propose des cours variés pour tous.
                Que vous souhaitiez améliorer vos compétences, préparer des examens ou explorer de nouvelles matières,
                EduShop a quelque chose pour vous.
            </p>
            <br />
            <p>
                <img src="images/icon/location.png" /> TEK-UP<br />
                1234, Rue de l'éducation<br />Tunis, Tunisie
            </p>
            <br />
            <p>
                <img src="images/icon/phone.png" /> +216 12 34 56 78<br />
                <img src="images/icon/mail.png" /> contact@edushop.tn
            </p>
        </div>
        <div class="right-col">
            <h1>Notre Newsletter</h1>
            <div class="border"></div>
            <br />
            <p>Inscrivez-vous pour recevoir les dernières actualités.</p>
            <div class="newsletter-form">
                <input class="txtb" type="email" placeholder="Entrez votre email" />
                <input class="btn" type="submit" value="Soumettre" onclick="alert('Inscrit!')" />
            </div>
        </div>
    </div>
</footer>

<!-- SCRIPT DE CHARGEMENT -->
<script>
function showLoading(e) {
    document.getElementById('loading').style.display = 'block';
}
function showFeedbackLoading(e) {
    document.getElementById('feedbackLoading').style.display = 'block';
}
</script>

<!-- SCRIPTS -->
<script src="js/script1.js"></script>
</body>
</html>