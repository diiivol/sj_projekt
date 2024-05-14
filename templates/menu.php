<!-- Header -->
<?php
  include_once('partials/header.php');
?>

  <!-- Menu -->
  <div class="container menu pt-3 mb-4">
    <h1 class="display-4 text-center mb-4">Menu</h1>
    <div class="row">
      <div class="col-md-6 col-lg-4">
        <div class="food-item">
          <img src="../assets/img/bryndzove-halusky.jpg" alt="Bryndzové Halušky" class="img-fluid mb-3" onclick="toggleText('bryndzove-halusky')">
          <h3>Bryndzové Halušky</h3>
          <p>Tradičné slovenské jedlo s varenými haluškami z čerstvých zemiakových knedlíkov, ktoré sú podávané s kvalitnou ovčou bryndzou a obložené opečenou slaninou.</p>
          <p class="m-0">Cena: 12€</p>
          <!--  -->
          <!-- Akordeón (1b) -->
          <!--  -->
          <div id="bryndzove-halusky" style="display: none;">
            <br>
            <p>Ingredients:</p>
            <!--  -->
            <!-- Zoznam (1b) -->
            <!--  -->
            <ul>
              <li>zemiakové knedlíky</li>
              <li>ovčia bryndza</li>
              <li>slanina</li>
            </ul>
            <!--  -->
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="food-item">
          <img src="../assets/img/kapustnica.jpg" alt="Kapustnica" class="img-fluid mb-3" onclick="toggleText('kapustnica')">
          <h3>Kapustnica</h3>
          <p>Výnimočná slovenská kapustová polievka s kombináciou kyslej kapusty, rôznych druhov mäsa a aromatických korenín, starostlivo varovaná na úžasné chute.</p>
          <p class="m-0">Cena: 10€</p>
          <div id="kapustnica" style="display: none;">
            <br>
            <p>Ingridients:</p>
            <ul>
              <li>kyslá kapusta</li>
              <li>mäso</li>
              <li>korenie</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="food-item">
          <img src="../assets/img/svieckova-na-smotane.jpg" alt="Sviečková na smotane" class="img-fluid mb-3" onclick="toggleText('svieckova-na-smotane')">
          <h3>Sviečková na smotane</h3>
          <p>Marínovaný hovädzí sviečkový rezeň podávaný s bohatou smotanovou omáčkou a tradičnými knedľami, výnimočná chuťová skúsenosť pre gurmánov.</p>
          <p class="m-0">Cena: 15€</p>
          <div id="svieckova-na-smotane" style="display: none">
            <br>
            <p>Ingridients:</p>
            <ul>
              <li>hovädzí rezeň</li>
              <li>smotana</li>
              <li>knedle</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="food-item">
          <img src="../assets/img/pirohy.jpg" alt="Pirohy" class="img-fluid mb-3" onclick="toggleText('pirohy')">
          <h3>Pirohy</h3>
          <p>Špeciálne slovenské knedle plnené lahodnou zmesou zemiakov, syra, kapusty alebo mäsa, varené a následne jemne opečené pre dokonalú textúru.</p>
          <p class="m-0">Cena: 11€</p>
          <div id="pirohy" style="display: none;">
            <br>
            <p>Ingridients:</p>
            <ul>
              <li>zemiakové knedle</li>
              <li>syr</li>
              <li>kapusta</li>
              <li>mäso</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="food-item">
          <img src="../assets/img/zivanska.jpg" alt="Živánska" class="img-fluid mb-3" onclick="toggleText('zivanska')">
          <h3>Živánska</h3>
          <p>Grilovaný alebo panvovo opečený bravčový alebo kurací steak, zahalený v plátku šunky a prekrytý kvalitným syrom, sprevádzaný špeciálnymi prílohami.</p>
          <p class="m-0">Cena: 13€</p>
          <div id="zivanska" style="display: none;">
            <br>
            <p>Ingridients:</p>
            <ul>
              <li>bravčový alebo kurací steak</li>
              <li>šunka</li>
              <li>syr</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="food-item">
          <img src="../assets/img/rezen.jpg" alt="Rezeň" class="img-fluid mb-3" onclick="toggleText('rezen')">
          <h3>Rezeň</h3>
          <p>Klasický mäsový rezeň - krehký a zlatohnedý, podávaný s vybranými prílohami podľa výberu, ideálny pre milovníkov tradičnej slovenskej kuchyne.</p>
          <p class="m-0">Cena: 12€</p>
          <div id="rezen" style="display: none;">
            <br>
            <p>Ingridients:</p>
            <ul>
              <li>rezeň</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--  -->
  <!-- Footer (2b) -->
  <!--  -->
    <!-- Niekoľko stĺpcov s informáciami o stránke -->
    <!-- Copyright -->
  <!--  -->
  <?php
    include_once('partials/footer.php')
  ?>