const toggler = document.querySelector(".hamburger");
const navLinksContainer = document.querySelector(".navlinks-container");

const toggleNav = e => {
  // Animation du bouton
  toggler.classList.toggle("open");

  const ariaToggle =
    toggler.getAttribute("aria-expanded") === "true" ? "false" : "true";
  toggler.setAttribute("aria-expanded", ariaToggle);

  // Slide de la navigation
  navLinksContainer.classList.toggle("open");
};

toggler.addEventListener("click", toggleNav);

const navLinks = document.querySelectorAll(".navlinks-container a");
navLinks.forEach(link => {
  link.addEventListener("click", function() {
    navLinksContainer.classList.remove("open");
    toggler.classList.remove("open");
    toggler.setAttribute("aria-expanded", "false");
  });
});

new ResizeObserver(entries => {
  if (entries[0].contentRect.width <= 900){
    navLinksContainer.style.transition = "transform 0.4s ease-out";
  } else {
    navLinksContainer.style.transition = "none";
  }
}).observe(document.body)


  // Identifier les boutons et les champs d'adresse dans le DOM
const useUserBillingAddressButton = document.getElementById('useUserBillingAddressButton');
const useUserShippingAddressButton = document.getElementById('useUserShippingAddressButton');
const adresseFacturationField = document.getElementById('commandeform_adresseFacturation');
const adresseExpeditionField = document.getElementById('commandeform_adresseExpedition');

// Ajouter des écouteurs d'événements aux boutons
useUserBillingAddressButton.addEventListener('click', () => {
    // Remplir les champs d'adresse avec les informations de l'utilisateur
    adresseFacturationField.value = '{{ app.user.adresseUser.numero }} {{ app.user.adresseUser.nom }}, {{ app.user.adresseUser.codePostal }} {{ app.user.adresseUser.ville }}';
});

useUserShippingAddressButton.addEventListener('click', () => {
    // Remplir les champs d'adresse avec les informations de l'utilisateur
    adresseExpeditionField.value = '{{ app.user.adresseUser.numero }} {{ app.user.adresseUser.nom }}, {{ app.user.adresseUser.codePostal }} {{ app.user.adresseUser.ville }}';
});
