@include('_header')
<!-- Video Banner -->
<div class="video-banner">
    <video autoplay muted loop playsinline class="w-100">
        <source src="{{ asset('assets/pub.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="video-overlay d-flex flex-column align-items-center justify-content-center text-white text-center">
        <h1 class="display-4 fw-bold mb-3">Bienvenue chez Car Rental</h1>
        <p class="h4 mb-4 fw-bold">Découvrez notre sélection exclusive de véhicules</p>
        <a href="{{ route('car.cars') }}" class="btn btn-primary btn-lg">Voir nos véhicules</a>
    </div>
</div>

<section class="welcome">
    <div class="item d-flex flex-column align-items-center justify-content-center text-white">
        <div class="titre text-center">Car Rental Management</div>
        <p class="text-center mb-5 fw-light fs-1">vous souhaite la bienvenue</p>
        <a href="{{ route('car.cars') }}" class="btn btn-dark btn-animated">Découvrez nos voitures</a>
    </div>
</section>
<section class="about py-5">
      <div class="container d-flex justify-content-between about-container">
          <img src="{{ asset('assets/banner.png') }}" alt="about" />
          <div class="d-flex flex-column justify-content-between content">
                <h3 class="text-dark text-center">À propos de nous</h3>
                <p class="fw-light">Bienvenue sur notre plateforme de gestion de location de voitures ! Chez RentCar, nous sommes passionnés par la simplification du processus de location de voitures pour offrir une expérience utilisateur fluide et agréable.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nihil sed aliquam ipsum eveniet necessitatibus aliquid pariatur recusandae neque, possimus accusantium sint incidunt. Libero pariatur sequi dolores. Tempora consequatur minima quisquam.</p>
                <p class="fw-light">Notre mission est de fournir à nos utilisateurs un moyen pratique et efficace de gérer la location de véhicules. Que vous soyez un administrateur gérant un parc automobile ou un utilisateur à la recherche de la voiture parfaite, notre plateforme offre des fonctionnalités robustes et conviviales pour répondre à vos besoins.</p>
                <a href="{{ route('contact.form') }}" class="btn btn-dark">Contactez-nous</a>
          </div>
      </div>
</section>
<section class="innovation py-5">
    <div class="container innovation-container">
        <div class="fs-3 text-dark fw-bold">Pourquoi nous choisir ?</div>
        <div class="d-flex flex-column w-100 mt-5">
            <div class="item d-flex w-100 mb-4">
                <span class="text-bg-dark number text-white fw-bold fs-3 ">1</span>
                <div class="d-flex flex-column content mx-3 justify-content-center">
                    <p class="mb-3 title text-dark fs-3">Gestion intuitive</p>
                    <p class="description fw-light ">Grâce à notre interface utilisateur conviviale, la gestion des véhicules et des locations devient un jeu d'enfant.</p>
                </div>
            </div>
            <div class="item d-flex w-100 mb-4 mx-5">
                <span class="text-bg-dark number text-white fw-bold fs-3 ">2</span>
                <div class="d-flex flex-column content mx-3 justify-content-center">
                    <p class="mb-3 title text-dark fs-3">Sécurité Avancée</p>
                    <p class="description fw-light ">Vos données sont notre priorité. Nous mettons en œuvre des mesures de sécurité avancées pour assurer la confidentialité et l'intégrité de vos informations.</p>
                </div>
            </div>
            <div class="item d-flex w-100 mb-4">
                <span class="text-bg-dark number text-white fw-bold fs-3 ">3</span>
                <div class="d-flex flex-column content mx-3 justify-content-center">
                    <p class="mb-3 title text-dark fs-3">Flexibilité Personnalisée</p>
                    <p class="description fw-light "> Que vous soyez un utilisateur individuel ou une entreprise, nos fonctionnalités peuvent être adaptées pour répondre à vos exigences spécifiques.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="products py-5">
    <div class="container products-container">
        <div class="fs-3 text-dark fw-bold">Nos voitures</div>
        <div class="mt-5 d-flex flex-wrap justify-content-between all-products">
            @foreach ($cars as $car)
                <div class="item d-flex flex-column justify-content-between p-3">
                    <img src="{{ asset($car->images) }}" alt="voiture" />
                    <div class="fw-light"><b>Designation</b> : {{ $car->brand }}</div>
                    <div class="fw-light"><b>Model</b> : {{ $car->model }}</div>
                    <div class="fw-light"><b>Prix</b> : 19$/Jour</div>
                            <a href="{{ route('cars.detail', ['id' => $car->id]) }}" class="btn-voir-plus"><i class="fas fa-eye text-black"></i> Voir plus</a>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="testimony py-5">
    <div class="container testimonies-container">
        <div class="testimonial-header text-center mb-5">
            <div class="testimonial-circle mx-auto d-flex align-items-center justify-content-center">
                <h2 class="m-0 text-white">Nos clients<br>témoignent</h2>
            </div>
        </div>
        <div class="mt-6 d-flex flex-wrap justify-content-between all-testimonies">
            <div class="testimony-item p-6">
                <div class="testimony-text-container">
                  <p class="text-justify fw-light"></p>
                </div>
                <div class="testimony-user">
                    <img src="{{ asset('assets/v19.jpg') }}" class="testimony-user-logo">
                </div>
                <p><b>Expert Debugger</b> spécialisé dans l'identification et la résolution des problèmes complexes de code, optimisant les performances des applications et garantissant une expérience utilisateur fluide et sans erreur.</p>
                <div class="testimony-user-role"></div>
            </div>
            <div class="testimony-item p-3">
                <div class="testimony-text-container">
                  <p class="text-justify fw-light"></p>
                </div>
                <div class="testimony-user">
                    <img src="{{ asset('assets/v20.jpg') }}" class="testimony-user-logo">
                </div>
                <p><b>Data Scientist</b> transforms complex data into actionable insights using statistical analysis, machine learning, and data visualization techniques to drive business decisions and innovation.</p>
                <div class="testimony-user-role"></div>
            </div>
            <div class="testimony-item p-3">
                <div class="testimony-text-container">
                  <p class="text-justify fw-light"></p>
                </div>
                <div class="testimony-user">
                    <img src="{{ asset('assets/v23.jpg') }}" class="testimony-user-logo">
                </div>
                <p><b>Développeuse Web</b> spécialisée dans la création de sites web modernes et réactifs, combinant créativité et expertise technique pour offrir des solutions numériques sur mesure et optimisées pour tous les appareils.</p>
                <div class="testimony-user-role"></div>
            </div>
            <div class="testimony-item p-3">
                <div class="testimony-text-container">
                  <p class="text-justify fw-light"></p>
                </div>
                <div class="testimony-user">
                  <img src="{{ asset('assets/v21.jpg') }}" class="testimony-user-logo">
                </div>
                <p><b>Développeuse Web</b> crée des expériences numériques fluides et réactives en utilisant les dernières technologies front-end et back-end pour construire des sites web performants et accessibles.</p>
                <div class="testimony-user-role"></div>
            </div>
        </div>
    </div>
</section>
<section class="newsletter py-5">
    <div class="newsletter-container container d-flex flex-column align-items-center text-bg-primary py-5">
        <p class="fs-3 mb-5">Souscrivez à nos newsletter</p>
        <form class="newsletter-form">
            <input type="email" placeholder="example@gmail.com">
            <input type="submit" value="S'abonner">
        </form>
    </div>
 </section>
@include('_footer')